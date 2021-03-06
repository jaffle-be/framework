<?php

namespace Modules\Shop\Product;

/**
 * Class PropertyObserver
 * @package Modules\Shop\Product
 */
class PropertyObserver
{
    protected $groups;

    protected $properties;

    /**
     * @param PropertyGroup $groups
     * @param Property $properties
     */
    public function __construct(PropertyGroup $groups, Property $properties)
    {
        $this->groups = $groups;
        $this->properties = $properties;
    }

    /**
     * @param PropertyGroup $group
     */
    public function creatingGroup(PropertyGroup $group)
    {
        $amount = $this->groups->where('category_id', $group->category_id)
            ->count();

        $group->sort = $amount;
    }

    /**
     * @param PropertyGroup $group
     */
    public function deletedGroup(PropertyGroup $group)
    {
        $this->groups->where('category_id', $group->category_id)
            ->where('sort', '>', $group->sort)
            ->update([
                'sort' => \DB::raw('sort - 1'),
            ]);
    }

    /**
     * @param Property $property
     */
    public function creatingProperty(Property $property)
    {
        $amount = $this->properties
            ->where('category_id', $property->category_id)
            ->where('group_id', $property->group_id)
            ->count();

        $property->sort = $amount;
    }

    /**
     * @param Property $property
     */
    public function deletedProperty(Property $property)
    {
        $this->properties->where('category_id', $property->category_id)
            ->where('group_id', $property->group_id)
            ->where('sort', '>', $property->sort)
            ->update([
                'sort' => \DB::raw('sort - 1'),
            ]);
    }
}
