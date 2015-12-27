<?php

namespace Test\System\Presenter;

use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\PresentableEntity;
use Test\TestCase;

class DummyPresentableEntity implements PresentableEntity
{
    public $name = 'my name';

    /**
     * @return BasePresenter
     */
    public function present()
    {
        return new DummyPresenter($this);
    }
}

class DummyPresenter extends BasePresenter
{
    public function fromDummy()
    {
        return 'from dummy';
    }
}

class BasePresenterTest extends TestCase
{
    public function testPropertyGetsReturnedFromEntityWhenNoMethodPresentOnPresenter()
    {
        $presenter = $this->presenter();
        $this->assertSame('my name', $presenter->name);
    }

    public function testMethodGetsUsedWhenItExists()
    {
        $presenter = $this->presenter();
        $this->assertSame('from dummy', $presenter->fromDummy);
    }

    /**
     * @return DummyPresenter
     */
    protected function presenter()
    {
        $entity = new DummyPresentableEntity();
        $presenter = new DummyPresenter();
        $presenter->setPresentableEntity($entity);

        return $presenter;
    }
}
