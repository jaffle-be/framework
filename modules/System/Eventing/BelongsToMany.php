<?php

namespace Modules\System\Eventing;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BelongsToMany extends \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    /**
     * Attach a model to the parent.
     */
    public function attach($id, array $attributes = [], $touch = true)
    {
        if ($id instanceof Model) {
            $id = $id->getKey();
        }

        $query = $this->newPivotStatement();

        $values = $this->createAttachRecords((array) $id, $attributes);

        $query->insert($values);

        if ($touch) {
            $this->touchIfTouching();
        }

        app('events')->fire('eloquent.attached: '.$this->relationName, $values);
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of models.
     *
     *
     */
    public function sync($ids, $detaching = true)
    {
        $changes = [
            'attached' => [],
            'detached' => [],
            'updated' => [],
        ];

        if ($ids instanceof Collection) {
            $ids = $ids->modelKeys();
        }

        // First we need to attach any of the associated models that are not currently
        // in this joining table. We'll spin through the given IDs, checking to see
        // if they exist in the array of current ones, and if not we will insert.
        $current = $this->newPivotQuery()->lists($this->otherKey);

        $records = $this->formatSyncList($ids);

        $detach = array_diff($current, array_keys($records));

        // Next, we will take the differences of the currents and given IDs and detach
        // all of the entities that exist in the "current" array but are not in the
        // the array of the IDs given to the method which will complete the sync.
        if ($detaching && count($detach) > 0) {
            $this->detach($detach);

            $changes['detached'] = (array) array_map(function ($v) {
                return is_numeric($v) ? (int) $v : (string) $v;
            }, $detach);
        }

        // Now we are finally ready to attach the new records. Note that we'll disable
        // touching until after the entire operation is complete so we don't fire a
        // ton of touch operations until we are totally done syncing the records.
        $changes = array_merge(
            $changes, $this->attachNew($records, $current, false)
        );

        if (count($changes['attached']) || count($changes['updated'])) {
            $this->touchIfTouching();
        }

        return $changes;
    }

    /**
     * Detach models from the relationship.
     *
     *
     */
    public function detach($ids = [], $touch = true)
    {
        if ($ids instanceof Model) {
            $ids = (array) $ids->getKey();
        }

        $query = $this->newPivotQuery();

        // If associated IDs were passed to the method we will only delete those
        // associations, otherwise all of the association ties will be broken.
        // We'll return the numbers of affected rows when we do the deletes.
        $ids = (array) $ids;

        if (count($ids) > 0) {
            $values = $query->whereIn($this->otherKey, (array) $ids)->get();
        }

        parent::detach($ids, $touch); // TODO: Change the autogenerated stub

        if (isset($values) && count($values) > 0) {
            //the get method above, returns std objects, so we quickly map them.
            $values = array_map(function ($item) {
                return (array) $item;
            }, $values);

            //fire based on the values, since the $ids can still contain invalid data.
            foreach ($values as $value) {
                app('events')->fire('eloquent.detached: '.$this->relationName, [$value]);
            }
        }
    }
}
