<?php namespace System\Eventing;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Product\Product;
use Modules\System\Eventing\BelongsToMany;
use Modules\System\Eventing\EventedRelations;
use Test\AdminTestCase;

class EventedRelationsStub extends Model
{

    use EventedRelations;

}

class EventedRelationsTest extends AdminTestCase
{

    public function testEventedBelongsToMany()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');

        $this->assertInstanceOf(BelongsToMany::class, $relation);
    }

    public function testSetsQueryCorrectly()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');
        $product = new Product();

        $this->assertInstanceOf(Builder::class, $relation->getQuery());
    }

    public function testSetsSelf()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');
        $this->assertInstanceOf(EventedRelationsStub::class, $relation->getParent());
    }

    public function testSetsTable()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');

        $this->assertSame($relation->getTable(), 'evented_relations_stub_product');

        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, 'tablename', null, null, 'test_relation');

        $this->assertSame($relation->getTable(), 'tablename');
    }

    public function testSetsForeignKey()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');

        $this->assertSame($relation->getForeignKey(), 'evented_relations_stub_product.evented_relations_stub_id');

        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, 'custom_id', null, 'test_relation');

        $this->assertSame($relation->getForeignKey(), 'evented_relations_stub_product.custom_id');
    }

    public function testSetsOtherKey()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');

        $this->assertSame($relation->getOtherKey(), 'evented_relations_stub_product.product_id');

        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, 'custom_id', 'test_relation');

        $this->assertSame($relation->getOtherKey(), 'evented_relations_stub_product.custom_id');
    }

    public function testSetsRelationName()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null, 'test_relation');
        $this->assertSame('test_relation', $relation->getRelationName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWhenNoRelationNameGiven()
    {
        $stub = new EventedRelationsStub();
        $relation = $stub->eventedBelongsToMany(Product::class, null, null, null);
    }

}