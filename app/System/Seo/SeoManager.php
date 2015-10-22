<?php namespace App\System\Seo;

use Illuminate\Contracts\Config\Repository;

class SeoManager
{

    protected $config;

    protected $entity;

    protected $providers;

    public function __construct(Repository $config)
    {
        $this->config = $config;

        $this->providers = $config->get('system.seo.providers');
    }

    public function setEntity(SeoEntity $entity)
    {
        $this->entity = $entity;
    }

    public function generate()
    {
        $result = '';

        if ($this->entity) {

            foreach($this->providers as $provider)
            {
                $provider = $this->buildProvider($provider);

                $result .= $provider->generate($this->entity);
            }

        }

        else{
            foreach($this->providers as $provider)
            {
                $provider = $this->buildProvider($provider);

                $result .= $provider->generate();
            }
        }

        return $result;
    }

    /**
     * @param $provider
     *
     * @return MetaTagProvider
     */
    protected function buildProvider($provider)
    {
        $pieces = explode('\\', $provider);

        $shortname = array_pop($pieces);

        $config = $this->config->get('system.seo.' . strtolower($shortname));

        $provider = new $provider($config);

        return $provider;
    }
}