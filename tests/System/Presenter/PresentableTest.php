<?php namespace Test\System\Presenter;

use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Test\TestCase;
use Mockery as m;


class ExceptionPresenterTestClass{

    use PresentableTrait;

}

class DummyPresenterWithTrait implements PresentableEntity{

    protected $presenter = DummyPresenterClass::class;

    use PresentableTrait;

}

class DummyPresenterClass extends BasePresenter{

    

}


class PresentableTest extends TestCase
{

    /**
     * @expectedException \Exception
     */
    public function testItThrowsAnErrorWhenNoPresenterProperty()
    {
        $test = new ExceptionPresenterTestClass();
        $test->present();
    }

    public function testItReturnsThePresenter()
    {
        $test = new DummyPresenterWithTrait();
        $result = $test->present();
        $this->assertInstanceOf(DummyPresenterClass::class, $result);
    }

    public function testItSetsTheEntityOnTheReturnedInstance()
    {
        $test = new DummyPresenterWithTrait();
        $result = $test->present();
        $this->assertSame($test, $result->getPresentableEntity());
    }

    public function testItCachedThePresenter()
    {
        $test = new DummyPresenterWithTrait();
        $mock = m::mock(DummyPresenterClass::class);
        $mock->shouldReceive('setPresentableEntity')->once()->with($test);

        //pass it as closure, or our illuminate container fails.
        $this->app->bind(DummyPresenterClass::class, function() use ($mock){
            return $mock;
        });

        $test->present();
        $test->present();
    }

}