<?php

namespace Modules\Marketing\Newsletter;

use Illuminate\Support\Collection;

/**
 * Class ReportFormatter
 * @package Modules\Marketing\Newsletter
 */
class ReportFormatter
{
    protected $fields = [
        'hard_bounces',
        'soft_bounces',
        'unsubscribes',
        'abuse_reports',
        'forwards',
        'forwards_opens',
        'opens',
        'unique_opens',
        'clicks',
        'unique_clicks',
        'users_who_clicked',
        'emails_sent',
        'unique_likes',
        'recipient_likes',
        'facebook_likes',
    ];

    protected $regular = [
        'emails_sent',
    ];

    protected $good = [
        'forwards',
        'forwards_opens',
        'opens',
        'unique_opens',
        'clicks',
        'unique_clicks',
        'users_who_clicked',
        'emails_sent',
        'unique_likes',
        'recipient_likes',
        'facebook_likes',
    ];

    protected $bad = [
        'hard_bounces',
        'soft_bounces',
        'unsubscribes',
        'abuse_reports',
    ];

    /**
     * @param $result
     * @return Collection
     */
    public function format($result)
    {
        $showing = array_only($result, $this->fields);

        $me = $this;

        //now lets run a map over this, so we can add information on how to display to stat.
        //example:
        //bad stats -> red
        //good stats -> green

        $response = new Collection();

        foreach ($showing as $name => $value) {
            if (in_array($name, $this->regular)) {
                $meaning = 'regular';
            } elseif (in_array($name, $this->bad)) {
                $meaning = $value > 0 ? 'bad' : 'good';
            } else {
                $meaning = $value > 0 ? 'good' : 'regular';
            }

            $response->push([
                'name' => $name,
                'value' => $value,
                'meaning' => $meaning,
            ]);
        }

        return $response;
    }
}
