<?php

namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\Account\AccountManager;

/**
 * Class ModelAccountOrSystemResourceScope
 * @package Modules\System\Scopes
 */
class ModelAccountOrSystemResourceScope implements Scope
{
    /**
     * @param AccountManager $manager
     */
    public function __construct(AccountManager $manager)
    {
        $this->account = $manager->account();
    }

    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        if ($this->account) {
            $builder->where(function ($query) {
                $query->where('account_id', $this->account->getKey())
                    ->orWhereNull('account_id');
            });
        }
    }
}
