<?php

namespace App\Contact;

use Illuminate\Database\Eloquent\Model;

class Address extends Model{

    protected $table = "contact_address";

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    protected $fillable = ["firstname", "lastname", "street", "box", "postcode", "city", "latitude", "longitude"];

    protected $hidden = ['owner_id', 'owner_type', 'created_at', 'updated_at', 'country_id'];

    public function owner()
    {
        return $this->morphTo();
    }

    public function format()
    {
        return sprintf('%s %s, %s %s', $this->attributes['street'], $this->attributes['box'], $this->attributes['postcode'], $this->attributes['city']);
    }

    public function country()
    {
        return $this->belongsTo('App\System\Country\Country', 'country_id');
    }

}