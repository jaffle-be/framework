<?php

namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\Account\AccountManager;

/**
 * Class ModelAccountResourceScope
 * @package Modules\System\Scopes
 */
class ModelAccountResourceScope implements Scope
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
            $builder->where($model->getTable().'.account_id', $this->account->getKey());
        }
    }
}
