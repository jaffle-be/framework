<?php

namespace Test\System\Presenter;

use Modules\System\Presenter\ShortCodeCompiler;
use Test\TestCase;

class ExceptionDummyShortCodeCompiler
{
    use ShortCodeCompiler;
}

class DummyShortCodeCompiler
{
    protected $shortcodes = ['media', 'other'];

    use ShortCodeCompiler;

    public function compileMediaShortCodes($content)
    {
        return $content.' compiled';
    }

    public function compileOtherShortCodes($content)
    {
        return $content.' with others too';
    }

    public function formatMediaShortCodes($content)
    {
        return $content.' formatted';
    }
}

class ShortCodeCompilerTest extends TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testThrowsAnExceptionIfNoShortcodesAreSet()
    {
        $dummy = new ExceptionDummyShortCodeCompiler();
        $dummy->loopShortcodes('something', 'some content');
    }

    public function testCompilingShortcodes()
    {
        $dummy = new DummyShortCodeCompiler();
        $this->assertSame('some content compiled with others too', $dummy->compileShortcodes('some content'));
    }
}
