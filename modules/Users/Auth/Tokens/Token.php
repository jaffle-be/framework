<?php namespace Modules\Users\Auth\Tokens;

use Illuminate\Database\Eloquent\Model;

class Token extends Model{

    const TYPE_RESET = 0;
    const TYPE_CONFIRMATION = 1;

    protected $table = 'users_tokens';

    protected $fillable = ['token_type', 'token_value', 'expires_at'];

    public $timestamps = false;

    protected $dates = ['expires_at'];

    protected $cast = [
        'token_type' => 'int'
    ];

}