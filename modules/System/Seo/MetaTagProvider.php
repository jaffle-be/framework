<?php

namespace Modules\System\Seo;

use Illuminate\Http\Request;

abstract class MetaTagProvider
{
    protected $prefix;

    protected $config;

    protected $defaults;

    protected $images = [];

    protected $properties = [];

    public function __construct(array $config, array $defaults = [])
    {
        $this->config = $config;

        $this->defaults = $defaults;
    }

    public function generate(SeoEntity $seo = null)
    {

        /** @var Request $request */
        $request = app('request');

        $this->setupDefaults();
        $this->addProperty('url', $request->getUri());
        if ($seo) {
            $this->addLocale($seo);
            $this->handle($seo);
            $this->addTypeDefaults($seo);
        } else {
            $this->addLocale();
        }

        $properties = $this->eachProperties($this->properties);
        $images = $this->eachProperties($this->images, 'image');

        return PHP_EOL.$properties.PHP_EOL.$images;
    }

    protected function setupDefaults()
    {
        $defaults = !empty($this->config) ? $this->config : [];

        foreach ($defaults as $key => $value):
            if ($key == 'images'):
                if (empty($this->images)):
                    $this->images = $value;
        endif; elseif (!empty($value) && !array_key_exists($key, $this->properties)):
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

    protected function addLocale(SeoEntity $seo = null)
    {
        $cases = [
            'nl' => 'nl_BE',
            'fr' => 'fr_BE',
            'en' => 'en_GB',
            'de' => 'de_DE',
        ];

        $this->addProperty('locale', $cases[app()->getLocale()]);

        //if multiple locale install and multiple selected
        //provide the translated routes
        //if we have an seo entity set. you need to get it from there.
        //this basically doesn't work for facebook.
        //facebook wants the same url for the same page in different locales
        //duh :(
    }

    abstract protected function handle(SeoEntity $seo);

    protected function addTypeDefaults($seo)
    {
        if (isset($this->properties['type'])) {
            $type = $this->properties['type'];

            //add all the extras for the specific type, if they haven't been defined yet.

            if (isset($this->defaults[$type])) {
                foreach ($this->defaults[$type] as $key => $default) {
                    $property = $this->nameForTypeSpecificProperty($type, $key);

                    if (!isset($this->properties[$property])) {
                        $this->properties[$property] = $default;
                    }
                }
            }
        }
    }

    /**
     * @param $type
     * @param $key
     *
     * @return string
     */
    protected function nameForTypeSpecificProperty($type, $key)
    {
        $property = $type.':'.$key;

        return $property;
    }

    /**
     * Make list of open graph tags.
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

                $html = $this->handleMultipleProperties($prefix, $property, $value, $html); else:

                $key = $this->getPropertyKey($prefix, $property);

                // if empty jump to next
                if (empty($value)) {
                    continue;
                }

        if ($this->hasCustomRenderMethod($key)) {
            $html[] = $this->customRenderMethod($key, $value);
        } else {
            $html[] = $this->tag($key, $value);
        }

        endif;
        endforeach;

        return implode(PHP_EOL, $html);
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
            $key = $prefix.$property;

        return $key; elseif (is_string($prefix)):
            $key = (is_string($property)) ? $prefix.':'.$property : $prefix;

        return $key; else:
            $key = $property;

        return $key;
        endif;
    }

    protected function hasCustomRenderMethod($key)
    {
        $method = $this->customRenderMethodName($key);

        return method_exists($this, $method);
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function customRenderMethodName($key)
    {
        $method = 'render'.ucfirst(camel_case($key));

        return $method;
    }

    protected function customRenderMethod($key, $value)
    {
        $method = $this->customRenderMethodName($key);

        return call_user_func([$this, $method], $key, $value);
    }

    protected function tag($key, $value)
    {
        if (!property_exists($this, 'prefix')) {
            throw new \Exception('Need to define the prefix property for generating meta tags');
        }

        return '<meta name="'.$this->prefix.strip_tags($key).'" content="'.strip_tags($value).'">';
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
}
