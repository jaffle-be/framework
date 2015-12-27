<?php

namespace Modules\Marketing\Newsletter;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Translatable\Translatable;

/**
 * Class CampaignWidget
 * @package Modules\Marketing\Newsletter
 */
class CampaignWidget extends Model implements PresentableEntity
{
    use Translatable;
    use ModelAutoSort;
    use PresentableTrait;

    protected $presenter = 'Modules\Marketing\Newsletter\WidgetPresenter';

    protected $table = 'newsletter_campaign_widgets';

    //a campaign widget is a block that will be shown in the newsletter.
    //it's basically a reference to which view we need to include.
    //however, not all widgets have the same properties.
    //this class will allow you to fetch all needed properties.

    //you should be able to assign all applicable text fields.
    //let's just store them into a 'many columns' table
    //we could "improve" this further by abstracting this 'duplication'
    //however, it would only make things overcomplicated.

    //another requirement is that we should be able to link any
    //resource to be shown in that specific block.

    //the link to which widget we'll be showing will for now be simply the path where it is stored for the current theme.
    //this will break with a new account. but we need several things to be refactored when we're actually going to sell this.
    protected $fillable = [
        'campaign_id',
        'path',
        'manual',
        'image_id',
        'title',
        'text',
        'title_left',
        'text_left',
        'image_left_id',
        'title_right',
        'text_right',
        'image_right_id',
        'resource_type',
        'resource_id',
        'other_resource_type',
        'other_resource_id',
    ];

    protected $translatedAttributes = ['title', 'text', 'title_left', 'text_left', 'title_right', 'text_right'];

    protected $casts = [
        'manual' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('Modules\Media\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imageLeft()
    {
        return $this->belongsTo('Modules\Media\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imageRight()
    {
        return $this->belongsTo('Modules\Media\Image');
    }

    //for now, we will not implement these relations in the 'other' classes
    //so try to fix all your problems by using this relation starting from campaign widget.
    //i do not see any requirement to be able to show that a product was included in a widget
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function resource()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function otherResource()
    {
        return $this->morphTo();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new CampaignWidgetCollection($models);
    }
}
