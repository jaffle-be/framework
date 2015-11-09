<?php namespace Modules\Marketing\Newsletter;

class CampaignBuilder
{

    protected $widgets = [
        
        [
            'name' => 'regular/2col',
            'items' => 2,
        ],
        [
            'name' => 'regular/full',
            'items' => 1,
        ],
        [
            'name' => 'regular/img-left',
            'items' => 1,
        ],
        [
            'name' => 'regular/img-right',
            'items' => 1,
        ],
        
        [
            'name' => 'complex/2col',
            'items' => 2,
        ],
        [
            'name' => 'complex/full',
            'items' => 1,
        ],
        [
            'name' => 'complex/img-left',
            'items' => 1,
        ],
        [
            'name' => 'complex/img-right',
            'items' => 1,
        ],

        [
            'name' => 'text-only/2col',
            'items' => 2,
        ],
        [
            'name' => 'text-only/2col-bg',
            'items' => 2,
        ],
        [
            'name' => 'text-only/full',
            'items' => 1,
        ],
        [
            'name' => 'text-only/full-bg',
            'items' => 1,
        ],
        
        [
            'name' => 'img-only/2col',
            'items' => 2,
        ],
        [
            'name' => 'img-only/full',
            'items' => 1,
        ],
    ];


    public function build()
    {
        return view('marketing::newsletter.campaign')->render();
    }

    public function getAvailableWidgets()
    {
        return $this->widgets;
    }

}