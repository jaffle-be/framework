<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Modules\System\Translatable\Exception\LocalesNotDefinedException;
use Test\System\Translatable\TranslatableStub;

/**
 * Class Translatable
 * @package Modules\System\Translatable
 */
trait Translatable
{

    /**
     * @param $locale
     * @return mixed|null|void
     */
    public function translateOrNew($locale)
    {
        if (($translation = $this->translate($locale, false)) === null) {
            $translation = $this->getNewTranslation($locale);
        }

        return $translation;
    }

    /**
     * @param null $locale
     * @param null $withFallback
     * @return null|void
     */
    public function translate($locale = null, $withFallback = null)
    {
        $locale = $locale ?: app()->getLocale();

        $withFallback = $withFallback === null ? $this->useFallback() : $withFallback;

        $translation = $this->getTranslationByLocaleKey($locale);

        if($translation)
        {
            return $translation;
        }

        if ($withFallback && $this->getFallbackLocale())
        {
            $translation = $this->getTranslationByLocaleKey($this->getFallbackLocale());

            if($translation){

                return $translation;
            }
        }

        return null;
    }

    /**
     * @param null $locale
     * @return bool
     */
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

    /**
     * @return string
     */
    public function getTranslationModelName()
    {
        return $this->translationModel ?: $this->getTranslationModelNameDefault();
    }

    /**
     * @return string
     */
    public function getTranslationModelNameDefault()
    {
        return get_class($this).config('system.translation_suffix', 'Translation');
    }

    /**
     * @return mixed
     */
    public function getRelationKey()
    {
        return $this->translationForeignKey ?: $this->getForeignKey();
    }

    /**
     * @return mixed
     */
    public function getLocaleKey()
    {
        return $this->localeKey ?: config('system.locale_key', 'locale');
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getRelationKey());
    }

    /**
     * @param $key
     */
    public function getAttribute($key)
    {
        if (str_contains($key, ':')) {
            list($key, $locale) = explode(':', $key);
        } else {
            $locale = app()->getLocale();
        }

        if ($this->isTranslationAttribute($key)) {
            if ($this->translate() === null) {
                return;
            }

            return $this->translate($locale)->$key;
        }

        return parent::getAttribute($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if (str_contains($key, ':')) {
            list($key, $locale) = explode(':', $key);
        } else {
            $locale = app()->getLocale();
        }

        if (in_array($key, $this->translatedAttributes)) {
            $this->translateOrNew($locale)->$key = $value;
        } else {
            parent::setAttribute($key, $value);
        }
    }

    /**
     * @param array $options
     * @return bool
     */
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

    /**
     * @param array $attributes
     * @return mixed
     */
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($attributes as $key => $values) {
            if ($this->isKeyALocale($key)) {
                foreach ($values as $translationAttribute => $translationValue) {
                    if ($this->alwaysFillable() or $this->isFillable($translationAttribute)) {
                        $this->translateOrNew($key)->$translationAttribute = $translationValue;
                    } elseif ($totallyGuarded) {
                        throw new MassAssignmentException($key);
                    }
                }
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    /**
     * @param $key
     */
    public function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $key) {
                return $translation;
            }
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getFallbackLocale()
    {
        return config('system.fallback_locale');
    }

    /**
     *
     */
    public function useFallback()
    {
        if (isset($this->useTranslationFallback) && $this->useTranslationFallback){

            return $this->useTranslationFallback;
        }

        return config('system.use_fallback');
    }

    /**
     * @param $key
     * @return bool
     */
    public function isTranslationAttribute($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    /**
     * @param $key
     * @return bool
     * @throws LocalesNotDefinedException
     */
    public function isKeyALocale($key)
    {
        $locales = $this->getLocales();

        return in_array($key, $locales);
    }

    /**
     * @return mixed
     * @throws LocalesNotDefinedException
     */
    public function getLocales()
    {
        $locales = config('system.locales');

        if (empty($locales)) {
            throw new LocalesNotDefinedException('Please make sure you have run "php artisan config:publish dimsav/laravel-translatable" '.
                ' and that the locales configuration is defined.');
        }

        return $locales;
    }

    /**
     * @return bool
     */
    public function saveTranslations()
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

    /**
     * @param Model $translation
     * @return bool
     */
    public function isTranslationDirty(Model $translation)
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function getNewTranslation($locale)
    {
        $modelName = $this->getTranslationModelName();
        $translation = new $modelName();
        $translation->setAttribute($this->getLocaleKey(), $locale);
        $this->translations->add($translation);

        return $translation;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return in_array($key, $this->translatedAttributes) || parent::__isset($key);
    }

    /**
     * @param Builder $query
     * @param $locale
     * @return Builder|static
     */
    public function scopeTranslatedIn(Builder $query, $locale)
    {
        return $query->whereHas('translations', function (Builder $q) use ($locale) {
            $q->where($this->getLocaleKey(), '=', $locale);
        });
    }

    /**
     * @param Builder $builder
     * @return Builder|static
     */
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
     * @param Builder $query
     * @param $translationField
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

    /**
     * @return mixed
     */
    public function alwaysFillable()
    {
        return config('system.always_fillable', false);
    }

    /**
     * @return mixed
     */
    public function getTranslationsTable()
    {
        return app($this->getTranslationModelName())->getTable();
    }
}
