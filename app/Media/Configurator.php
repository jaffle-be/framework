<?php namespace App\Media;

use App\Theme\Theme;
use Illuminate\Contracts\Config\Repository;
use InvalidArgumentException;

class Configurator
{

    public function __construct(Repository $config, Theme $theme)
    {
        $this->config = $config;

        $config = $config->get('media');

        //cache the owners as this will be reused.
        $this->owners = $config['owners'];

        $this->theme = $theme;
    }

    public function typeExists($type)
    {
        return count($this->getTypes($type)) > 0;
    }

    public function getTypes($type = 'all')
    {
        if ($type == 'all' || $type === null) {
            //use all defined owners
            return array_values($this->owners);
        }

        //make sure the type provided is a known type.
        //type argument in console should be passed by its alias defined in the owners config.
        return array_values(array_intersect_key($this->owners, array_flip([$type])));
    }

    public function getPublicPath(StoresMedia $owner, $size = null)
    {
        return public_path($this->getAbstractPath($owner, $size));
    }

    public function getAbstractPath(StoresMedia $owner, $size = null)
    {
        return $this->config->get('media.path') . '/' . $owner->getMediaFolder($size);
    }

    /**
     * Every resource is account owned, so the sizes are also account specific.
     * Need to watch out with this, it could cause problems for content that will be
     * created by our own team.
     *
     * @param StoresMedia $owner
     *
     * @return array
     */
    public function getImageSizes(StoresMedia $owner, $requested = 'all')
    {
        $alias = $this->alias($owner);

        //get the dimensions defined in the theme that's currently being used.
        $config = $this->config->get($this->theme->name . '.media.images.' . $alias);

        //add our dimension for the admin, flip to be able to merge
        $sizes = array_merge(array_flip($config), array_flip($this->config->get('media.admin.image')));

        //now get the keys to find all sizes
        $sizes = array_keys($sizes);

        if($requested == 'all' || $requested === null)
        {
            return $sizes;
        }

        //the option passed can be , separated list of aliases
        //explode them and make sure to use the actual class instead of the alias
        $requested = explode(',', $requested);

        return array_intersect($sizes, $requested);
    }

    /**
     * Return the alias used for the given media owner type
     *
     * @param StoresMedia $owner
     *
     * @return mixed
     */
    public function alias(StoresMedia $owner)
    {
        $index = array_search(get_class($owner), $this->owners);

        if($index === false)
        {
            throw new InvalidArgumentException('Unknown owner type, you may have forgotten to add it to the config file');
        }

        return $index;
    }

    /**
     * Return the full classname for the media owner type for the given alias
     * @param $alias
     */
    public function classname($alias)
    {
        if(!isset($this->owners[$alias]))
        {
            throw new InvalidArgumentException('Unknown alias given, you may have forgotten to add it to the config file');
        }

        return $this->owners[$alias];
    }


}