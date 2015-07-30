<?php namespace App\System\Scopes;

use App\Account\AccountManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class ModelAccountResourceScope implements ScopeInterface
{

    public function __construct(AccountManager $manager)
    {
        $this->account = $manager->account();
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('account_id', $this->account->getKey());
    }

    public function remove(Builder $builder, Model $model)
    {

    }

}