<?php namespace App\Contact;

trait OwnsAddress
{
    public function address()
    {
        return $this->morphOne('App\Contact\Address', 'owner');
    }

}