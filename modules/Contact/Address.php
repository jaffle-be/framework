<?php

namespace Modules\Contact;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package Modules\Contact
 */
class Address extends Model
{
    protected $table = 'contact_address';

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    protected $fillable = ['firstname', 'lastname', 'street', 'box', 'postcode', 'city', 'latitude', 'longitude'];

    protected $hidden = ['owner_id', 'owner_type', 'created_at', 'updated_at', 'country_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @param bool|true $microtags
     * @return string
     */
    public function format($microtags = true)
    {
        if ($microtags) {
            $street = $this->microtag('streetAddress', $this->attributes['street']);

            $box = $this->microtag('postOfficeBoxNumber', $this->attributes['box']);

            $postal = $this->microtag('postalCode', $this->attributes['postcode']);

            $city = $this->microtag('addressLocality', $this->attributes['city']);

            $country = $this->microtag('addressCountry', $this->country->iso_code_2, true);

            return sprintf('%s %s, %s %s %s', $street, $box, $postal, $city, $country);
        } else {
            $street = $this->attributes['street'];

            $box = $this->attributes['box'];

            $postal = $this->attributes['postcode'];

            $city = $this->attributes['city'];

            $country = $this->country->iso_code_2;

            return sprintf('%s %s, %s %s %s', $street, $box, $country, $postal, $city);
        }
    }

    /**
     * @param $type
     * @param $value
     * @param bool|false $hidden
     * @return string
     */
    protected function microtag($type, $value, $hidden = false)
    {
        if ($hidden) {
            $hidden = 'style="display:none;"';
        }

        return sprintf('<span itemprop="%s" %s>%s</span>', $type, $hidden, $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('Modules\System\Country\Country', 'country_id');
    }
}
