<?php namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Translatable\Translatable;

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