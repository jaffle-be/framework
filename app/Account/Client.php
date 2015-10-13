<?php namespace App\Account;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\System\Scopes\ModelAccountResource;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model implements StoresMedia
{
    use Translatable;
    use StoringMedia;
    use ModelAccountResource;

    protected $table = 'account_clients';

    protected $media = '{account}/account/client';

    protected $mediaMultiple = false;

    protected $translatedAttributes = ['description'];

    protected $fillable = ['account_id', 'description', 'name', 'website'];

}