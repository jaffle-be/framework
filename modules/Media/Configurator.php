<?php namespace Modules\Media;

use Illuminate\Contracts\Config\Repository;
use InvalidArgumentException;
use Modules\Theme\ThemeManager;

class Configurator
{

    protected $config;

    protected $owners;

    protected $theme;

    public function __construct(Repository $config, ThemeManager $theme)
    {
        $this->config = $config;

        $config = $config->get('media');

        //cache the owners as this will be reused.
        $this->owners = $config['owners'];

        $this->theme = $theme;
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

    public function getPublicBasePath(StoresMedia $owner)
    {
        return public_path($this->config->get('media.path') . '/' . $owner->getMediaFolder());
    }

    public function getPublicPath(StoresMedia $owner, $type, $size = null)
    {
        $path = $this->config->get('media.path') . '/' . $owner->getMediaFolder($type, $size);

        return public_path($path);
    }

    public function getAbstractPath(StoresMedia $owner, $type, $size = null)
    {
        if(!$this->isSupportedMediaType($type))
        {
            throw new InvalidArgumentException('Need to pass a proper media type');
        }

        return $this->config->get('media.path') . '/' . $owner->getMediaFolder($type, $size);
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
        //strtolower was added, on mac it worked due to case insensitivity in paths.
        if(!$current = $this->theme->current())
        {
            $name = strtolower($this->config->get('theme.default'));
        }
        else{
            $name = strtolower($current->name);
        }

        $config = $this->config->get($name . '.media.images.' . $alias);

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

    /**
     * @return array
     */
    public function getSupportedMediaTypes()
    {
        return ['images', 'infographics', 'files', 'videos'];
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isSupportedMediaType($type)
    {
        return in_array($type, $this->getSupportedMediaTypes());
    }

    public function isSupportedMediaOwner($type)
    {
        return count($this->getTypes($type)) > 0;
    }

}