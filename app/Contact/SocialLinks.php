<?php namespace App\Contact;

use App\System\Scopes\ModelAccountResource;
use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    use ModelAccountResource;

    protected $table = 'contact_social_links';

    protected $hidden = ['account_id', 'owner_id', 'owner_type', 'created_at', 'updated_at'];

    protected $fillable = [
        'account_id',
        'facebook',
        'twitter',
        'google',
        'pinterest',
        'linkedin',
        'vimeo',
        'rss',
        'skype',
        'dribbble',
        'youtube',
        'instagram',
    ];

    public function available()
    {
        $data = $this->toArray();

        $data = array_except($data, ['id']);

        $data = array_filter($data, function($item){
            return !empty($item);
        });

        return $data;
    }

    public function getFillable()
    {
        $fillable = $this->fillable;

        $fillable = array_flip($fillable);

        return array_flip(array_except($fillable, ['id', 'account_id']));
    }

}