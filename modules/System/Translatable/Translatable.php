<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Modules\System\Translatable\Exception\LocalesNotDefinedException;

trait Translatable
{
    /*
     * Alias for getTranslation()
     */
    public function translate($locale = null, $withFallback = false)
    {
        return $this->getTranslation($locale, $withFallback);
    }

    /*
     * Alias for getTranslation()
     */
    public function translateOrDefault($locale)
    {
        return $this->getTranslation($locale, true);
    }

    /*
     * Alias for getTranslationOrNew()
     */
    public function translateOrNew($locale)
    {
        return $this->getTranslationOrNew($locale);
    }

    /**
     *
     */
    public function getTranslation($locale = null, $withFallback = null)
    {
        $locale = $locale ?: app()->getLocale();

        $withFallback = $withFallback === null ? $this->useFallback() : $withFallback;

        if ($this->getTranslationByLocaleKey($locale)) {
            $translation = $this->getTranslationByLocaleKey($locale);
        } elseif ($withFallback
            && $this->getFallbackLocale()
            && $this->getTranslationByLocaleKey($this->getFallbackLocale())
        ) {
            $translation = $this->getTranslationByLocaleKey($this->getFallbackLocale());
        } else {
            $translation = null;
        }

        return $translation;
    }

    public function hasTranslation($locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $locale) {
                return true;
            }
        }

        return false;
    }

    public function getTranslationModelName()
    {
        return $this->translationModel ?: $this->getTranslationModelNameDefault();
    }

    public function getTranslationModelNameDefault()
    {
        return get_class($this).config('system.translation_suffix', 'Translation');
    }

    public function getRelationKey()
    {
        return $this->translationForeignKey ?: $this->getForeignKey();
    }

    public function getLocaleKey()
    {
        return $this->localeKey ?: config('system.locale_key', 'locale');
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getRelationKey());
    }

    public function getAttribute($key)
    {
        if (str_contains($key, ':')) {
            list($key, $locale) = explode(':', $key);
        } else {
            $locale = app()->getLocale();
        }

        if ($this->isTranslationAttribute($key)) {
            if ($this->getTranslation() === null) {
                return;
            }

            return $this->getTranslation($locale)->$key;
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (str_contains($key, ':')) {
            list($key, $locale) = explode(':', $key);
        } else {
            $locale = app()->getLocale();
        }

        if (in_array($key, $this->translatedAttributes)) {
            $this->getTranslationOrNew($locale)->$key = $value;
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function save(array $options = [])
    {
        if ($this->exists) {
            //this might need a db transaction.
            //if the parent returns true, but the translations return false
            //we information partially while still returning false to the developer.
            //didn't implement yet, since i'm not sure what would happen if a transaction was allready started

            //the original library had a check for dirty() fields, and only ran the parent save when it was actually
            //dirty, which was a bad idea, since it skipped firing events. we also changed the order in which they get fired.
            //since translation is a dependency of the base model, we should first save the dependency
            //this was also interfering with elasticsearch auto indexing, since it was updating the old information
            //into the cluster as the translation savings were only being done after.
            //this happens because in the document saving method, we clone the object and reload all the relations
            //for that document. (i know, not perfect, but it's easier for now to do it like that then to make sure each and every user action
            //holds all the elasticsearch relations before the save. which will never be the case)

            if ($this->saveTranslations()) {
                return parent::save($options);
            }

            return false;
        } elseif (parent::save($options)) {
            // We save the translations only if the instance is saved in the database.
            return $this->saveTranslations();
        }

        return false;
    }

    protected function getTranslationOrNew($locale)
    {
        if (($translation = $this->getTranslation($locale, false)) === null) {
            $translation = $this->getNewTranslation($locale);
        }

        return $translation;
    }

    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($attributes as $key => $values) {
            if ($this->isKeyALocale($key)) {
                foreach ($values as $translationAttribute => $translationValue) {
                    if ($this->alwaysFillable() or $this->isFillable($translationAttribute)) {
                        $this->getTranslationOrNew($key)->$translationAttribute = $translationValue;
                    } elseif ($totallyGuarded) {
                        throw new MassAssignmentException($key);
                    }
                }
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    private function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $key) {
                return $translation;
            }
        }

        return;
    }

    private function getFallbackLocale()
    {
        return config('system.fallback_locale');
    }

    /**
     *
     */
    private function useFallback()
    {
        if (isset($this->useTranslationFallback) && $this->useTranslationFallback !== null) {
            return $this->useTranslationFallback;
        }

        return config('system.use_fallback');
    }

    protected function isTranslationAttribute($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    protected function isKeyALocale($key)
    {
        $locales = $this->getLocales();

        return in_array($key, $locales);
    }

    protected function getLocales()
    {
        $locales = config('system.locales');

        if (empty($locales)) {
            throw new LocalesNotDefinedException('Please make sure you have run "php artisan config:publish dimsav/laravel-translatable" '.
                ' and that the locales configuration is defined.');
        }

        return $locales;
    }

    protected function saveTranslations()
    {
        $saved = true;
        foreach ($this->translations as $translation) {
            if ($saved && $this->isTranslationDirty($translation)) {
                $translation->setAttribute($this->getRelationKey(), $this->getKey());
                $saved = $translation->save();
            }
        }

        return $saved;
    }

    protected function isTranslationDirty(Model $translation)
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    public function getNewTranslation($locale)
    {
        $modelName = $this->getTranslationModelName();
        $translation = new $modelName();
        $translation->setAttribute($this->getLocaleKey(), $locale);
        $this->translations->add($translation);

        return $translation;
    }

    public function __isset($key)
    {
        return in_array($key, $this->translatedAttributes) || parent::__isset($key);
    }

    public function scopeTranslatedIn(Builder $query, $locale)
    {
        return $query->whereHas('translations', function (Builder $q) use ($locale) {
            $q->where($this->getLocaleKey(), '=', $locale);
        });
    }

    public function scopeTranslated(Builder $builder)
    {
        return $builder->has('translations');
    }

    /**
     * Adds scope to get a list of translated attributes, using the current locale.
     * Example usage: Country::scopeListsTranslations('name')->get()->toArray()
     * Will return an array with items:
     *  [
     *      'id' => '1',                // The id of country
     *      'name' => 'Griechenland'    // The translated name
     *  ].
     */
    public function scopeListsTranslations(Builder $query, $translationField)
    {
        $withFallback = $this->useFallback();

        $query
            ->select($this->getTable().'.'.$this->getKeyName(), $this->getTranslationsTable().'.'.$translationField)
            ->leftJoin($this->getTranslationsTable(), $this->getTranslationsTable().'.'.$this->getRelationKey(), '=', $this->getTable().'.'.$this->getKeyName())
            ->where($this->getTranslationsTable().'.'.$this->getLocaleKey(), app()->getLocale());
        if ($withFallback) {
            $query->orWhere(function (Builder $q) {
                $q->where($this->getTranslationsTable().'.'.$this->getLocaleKey(), $this->getFallbackLocale())
                    ->whereNotIn($this->getTranslationsTable().'.'.$this->getRelationKey(), function (QueryBuilder $q) {
                        $q->select($this->getTranslationsTable().'.'.$this->getRelationKey())
                            ->from($this->getTranslationsTable())
                            ->where($this->getTranslationsTable().'.'.$this->getLocaleKey(), app()->getLocale());
                    });
            });
        }
    }

    private function alwaysFillable()
    {
        return config('system.always_fillable', false);
    }

    private function getTranslationsTable()
    {
        return app($this->getTranslationModelName())->getTable();
    }
}
