<?php namespace App\System\Seo;

abstract class MetaTagProvider
{
    protected $prefix;

    protected $config;

    protected $images = [];

    protected $properties = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    abstract protected function handle(SeoEntity $seo);

    public function generate(SeoEntity $seo = null)
    {
        $this->setupDefaults();

        if($seo)
        {
            $this->handle($seo);
        }

        $properties = $this->eachProperties($this->properties);
        $images     = $this->eachProperties($this->images, 'image');

        return PHP_EOL . $properties . PHP_EOL . $images;
    }

    protected function setupDefaults()
    {
        $defaults = !empty($this->config) ? $this->config : [];

        foreach ($defaults as $key => $value):
            if ($key == 'images'):
                if (empty($this->images)):
                    $this->images = $value;
                endif;
            elseif (!empty($value) && !array_key_exists($key, $this->properties)):
                $this->addProperty($key, $value);
            endif;
        endforeach;
    }

    /**
     * Add or update property.
     *
     * @param string       $key
     * @param string|array $value
     *
     * @return $this
     */
    public function addProperty($key, $value)
    {
        $this->properties[$key] = $value;

        return $this;
    }

    /**
     * Remove property.
     *
     * @param string $key
     *
     * @return $this
     */
    public function removeProperty($key)
    {
        array_forget($this->properties, $key);

        return $this;
    }

    /**
     * Add image to properties.
     *
     * @param string $url
     *
     * @return $this
     */
    public function addImage($url)
    {
        $this->images[] = $url;

        return $this;
    }

    /**
     * Add images to properties.
     *
     * @param array $urls
     *
     * @return $this
     */
    public function addImages(array $urls)
    {
        array_push($this->images, $urls);

        return $this;
    }

    /**
     * Make list of open graph tags
     *
     * @param array       $properties
     * @param null|string $prefix
     *
     * @return string
     */
    protected function eachProperties(array $properties, $prefix = null)
    {
        $html = [];

        foreach ($properties as $property => $value):
            // multiple properties
            if (is_array($value)):

                $html = $this->handleMultipleProperties($prefix, $property, $value, $html);
            else:

                $key = $this->getPropertyKey($prefix, $property);

                // if empty jump to next
                if (empty($value)) continue;

                $html[] = $this->tag($key, $value);
            endif;
        endforeach;

        return implode(PHP_EOL, $html);
    }

    protected function tag($key, $value)
    {
        if(!property_exists($this, 'prefix'))
        {
            throw new \Exception('Need to define the prefix property for generating meta tags');
        }

        return '<meta name="' . $this->prefix . strip_tags($key) . '" content="' . strip_tags($value) . '">';
    }

    /**
     * @param $prefix
     * @param $property
     * @param $value
     * @param $html
     *
     * @return array
     */
    protected function handleMultipleProperties($prefix, $property, $value, $html)
    {
        $subListPrefix = (is_string($property)) ? $property : $prefix;
        $subList = $this->eachProperties($value, $subListPrefix);

        $html[] = $subList;

        return $html;
    }

    /**
     * @param $prefix
     * @param $property
     *
     * @return string
     */
    protected function getPropertyKey($prefix, $property)
    {
        if (is_numeric($property)):
            $key = $prefix . $property;

            return $key;
        elseif (is_string($prefix)):
            $key = (is_string($property)) ? $prefix . ':' . $property : $prefix;

            return $key;
        else:
            $key = $property;

            return $key;
        endif;
    }
}