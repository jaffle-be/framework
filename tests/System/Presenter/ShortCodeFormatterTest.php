<?php

namespace Test\System\Presenter;

use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\ShortCodeFormatter;
use Modules\System\Translatable\TranslationModel;
use Test\TestCase;
use Mockery as m;

class DummyShortCodeFormatterModel extends TranslationModel implements PresentableEntity
{
    public $content = 'some content with #image# shortcode';

    public function isDirty($attributes = null)
    {
        return true;
    }

    /**
     * @return BasePresenter
     */
    public function present()
    {
    }
}

class ShortCodeFormatterTest extends TestCase
{
    public function testTheActualFormattingGetsTriggered()
    {
        $formatter = new ShortCodeFormatter();

        $instance = new DummyShortCodeFormatterModel();
        $formatter->handle($instance);

        //just a very basic short code example to test if it works.
        //if the syntax for shortcodes ever change, you'll need to change the example
        $this->assertSame("some content with \n#image#\n shortcode", $instance->content);
    }

    public function testItOnlyRunsForATranslationModelThatIsPresentable()
    {
        $mock = m::mock('something');
        $mock->shouldNotReceive('isDirty');

        $formatter = new ShortCodeFormatter();
        $formatter->handle($mock);
    }
}
