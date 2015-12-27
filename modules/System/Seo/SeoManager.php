<?php

namespace Modules\System\Seo;

use Illuminate\Contracts\Config\Repository;

/**
 * Class SeoManager
 * @package Modules\System\Seo
 */
class SeoManager
{
    protected $config;

    protected $entity;

    protected $providers;

    protected $defaults;

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;

        $this->providers = $config->get('system.seo.providers');

        $this->defaults = $config->get('system.seo.defaults');
    }

    /**
     * @param SeoEntity $entity
     */
    public function setEntity(SeoEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $result = '';

        if ($this->entity) {
            foreach ($this->providers as $provider) {
                $provider = $this->buildProvider($provider);

                $result .= $provider->generate($this->entity);
            }
        } else {
            foreach ($this->providers as $provider) {
                $provider = $this->buildProvider($provider);

                $result .= $provider->generate();
            }
        }

        return $result;
    }

    /**
     * @param $provider
     * @return
     */
    protected function buildProvider($provider)
    {
        $pieces = explode('\\', $provider);

        $shortname = array_pop($pieces);

        $shortname = strtolower($shortname);

        $config = $this->config->get('system.seo.'.$shortname);

        $defaults = $this->config->get('system.seo.defaults.'.$shortname, []);

        $provider = new $provider($config, $defaults);

        return $provider;
    }
}
