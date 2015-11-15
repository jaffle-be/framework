<?php namespace Modules\System\Sluggable;

use Modules\System\Locale;
use Modules\System\Scopes\SiteSluggableScope;
use Modules\System\Uri\Uri;

trait SiteSluggable
{

    use Sluggable;

    protected function needsSlugging()
    {
        return $this->exists;
    }

    public function getRouteKeyName()
    {
        if (!starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {

            return 'uris.uri';
        }

        return $this->getKeyName();
    }

    public function getRouteKey()
    {
        return $this->slug->uri;
    }

    public static function bootSiteSluggable()
    {
        /** @var Request $request */
        $request = app('request');

        if (app()->runningInConsole()) {
            return;
        }

        if (!starts_with($request->getRequestUri(), ['/admin', '/api'])) {
            static::addGlobalScope(new SiteSluggableScope());
        }
    }

    public function slug()
    {
        return $this->morphOne('Modules\System\Uri\Uri', 'owner');
    }

    public function getSlug()
    {
        return $this->slug ? $this->slug->uri : null;
    }

    abstract public function getAccount();

    /**
     * Set the slug manually.
     *
     * @param string $slug
     */
    protected function setSlug($uri)
    {
        if (empty($uri)) {
            return;
        }

        //for site sluggables, we do not need to configure anything as we know how we'll name our slug
        //and what relation it uses.
        //all we need to check is.. does it exist? if not, create a new one.
        //if so, update it.

        //old way of handling locales with simple string values
        if (isset($this->attributes['locale'])) {
            $locale = Locale::whereSlug($this->attributes['locale'])->first();
        } else {
            $locale = $this->locale;
        }

        //to find the account id, we'd need the parent document, not the translation document
        //since we didn't define our translation to use a general name, we need to use an interface function
        //which returns a value for us. (and which we can define on each model)

        //both this part and the part for the locales should be cleaned up once we upgrade our system
        //to only use the locale class and not the locale string values.

        //do not change it into :
        //
        //# $account = app('Modules\Account\AccountManager')->account();
        //
        //that would be wrong when we're doing some sort of console command
        //without an actual account reference within accountmanager
        $account = $this->getAccount();

        $this->load('slug');

        if (!$slug = $this->slug) {
            //slugs should always be account specific, at least for now
            $slug = new Uri([
                'account_id' => $account->id,
                'locale_id'  => $locale->id,
                'uri'        => $uri,
            ]);

            $this->slug()->save($slug);
        } else {
            //consider a post as our example resource from now on
            //whenever we update a post its title... we'll be working in a draft.
            //this means that we do not need to save a new uri instance.
            //an uri only becomes active and should then be inserted, when an actual draft is published.
            //the same goes for editing an existing post.
            //when editing a post, you'll actually edit a revision. which will not be online until you publish it.
            //when you publish it, the old post will be taken 'offline'
            //the new post will be created, which will trigger the new uri insertion.

            //the canonical is probably something that needs to be implemented together with the allowRevisions trait
            //instead of implementing it in the uri table

            //when updating the slug, we need to insert a new uri, and set the canonical
            $this->slug->uri = $uri;
            $this->slug->save();
        }
    }

    /**
     * Get all existing slugs that are similar to the given slug.
     *
     * @param string $slug
     *
     * @return array
     */
    protected function getExistingSlugs($slug)
    {
        $uri = new Uri();

        $config = $this->getSluggableConfig();

        $query = $uri->where(function ($query) use ($slug, $config) {
            $query->where('uri', $slug)
                ->orWhere('uri', 'like', $slug . $config['separator'] . '%');
        });

        $this->load('slug');

        if ($this->slug) {
            $query->where('id', '<>', $this->slug->id);
        }

        // get a list of all matching slugs
        $list = $query->lists('uri', $this->getKeyName());

        return $list->all();
    }

}