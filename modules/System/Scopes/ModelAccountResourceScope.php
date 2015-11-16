<?php namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Modules\Account\AccountManager;

class ModelAccountResourceScope implements ScopeInterface
{

    public function __construct(AccountManager $manager)
    {
        $this->account = $manager->account();
    }

    public function apply(Builder $builder, Model $model)
    {
        if ($this->account) {
            $builder->where('account_id', $this->account->getKey());
        }
    }

    public function remove(Builder $builder, Model $model)
    {
    }

}