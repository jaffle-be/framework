<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;

/**
 * This class is meant to mock our account, so we can have images grouped in a collection
 * In other words, we are now able to add multiple image relations to one model
 * each relation should have it's own mocking class.
 * Class AccountLogo
 */
class AccountLogo extends Model implements StoresMedia
{

    use StoringMedia;

    protected $media = '{account}/account/logo';

    protected $mediaMultiple = false;

    protected $fillable = ['id'];

    protected $table = 'accounts';
}
