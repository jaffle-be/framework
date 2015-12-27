<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Contact\AddressOwner;
use Modules\Contact\OwnsAddress;

/**
 * Class AccountContactInformation
 * @package Modules\Account
 */
class AccountContactInformation extends Model implements AddressOwner
{
    use OwnsAddress;

    protected $table = 'account_contact_information';

    protected $fillable = ['email', 'phone', 'vat', 'website', 'hours'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }
}
