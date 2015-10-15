<?php namespace App\Pages;

class PageRepository implements PageRepositoryInterface
{

    /**
     * @return []
     */
    public function relations()
    {
        return ['user', 'translations'];
    }

}