<?php

namespace Test\System\Presenter;

use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\PresentableCache;
use Modules\System\Presenter\PresentableCacher;
use Modules\System\Presenter\PresentableEntity;
use Test\TestCase;

class DummyPresentableCachableEntity implements PresentableEntity, PresentableCache
{
    //these fields will be filled during tests if they succeed
    public $cached_content;
    public $cached_extract;

    public function isDirty($field)
    {
        return true;
    }

    /**
     * @return BasePresenter
     */
    public function present()
    {
        $presenter = new DummyPresentableCachableEntityPresenter();
        $presenter->setPresentableEntity($this);

        return $presenter;
    }
}

class DummyPresentableCachableEntityPresenter extends BasePresenter
{
    public function content()
    {
        return 'my presented content';
    }

    public function extract()
    {
        return 'my presented extract';
    }
}

class PresentableCacherTest extends TestCase
{
    public function testIfItCashesContentField()
    {
        $cacher = new PresentableCacher();
        $entity = new DummyPresentableCachableEntity();

        $cacher->handle($entity);

        $this->assertSame('my presented content', $entity->cached_content);
    }

    public function testIfItCashesExtractField()
    {
        $cacher = new PresentableCacher();
        $entity = new DummyPresentableCachableEntity();

        $cacher->handle($entity);

        $this->assertSame('my presented extract', $entity->cached_extract);
    }
}
