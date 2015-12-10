<?php namespace Test\System\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\ContentPresenterTrait;
use Modules\System\Presenter\PresentableCache;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\ShortCodeCompiler;
use Test\TestCase;

class DummyContentPresentableEntity implements PresentableEntity{

    public $content = 'content';

    public $extract = 'extract';

    public function present()
    {
        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity($this);

        return $dummy;
    }

}

class DummyContentPresenter extends BasePresenter{

    protected $shortcodes = ['media'];

    use ContentPresenterTrait;
    use ShortCodeCompiler;
    use MediaShortcodes;

}

class DummyCachableContentPresenter extends BasePresenter implements PresentableCache{

    protected $cached_content = 'cached content';

    protected $cached_extract = 'cached extract';

    use ContentPresenterTrait;

}

class ContentPresenterTest extends TestCase
{

    public function testCheckingIfWeNeedToUseCache()
    {
        $dummy = new DummyContentPresenter();
        $this->assertFalse($dummy->usePresentableCache());

        $this->startMockingFront();

        $dummy = new DummyCachableContentPresenter();
        $this->assertTrue($dummy->usePresentableCache());

        //switch back to most basic
        $this->stopMockingFront();
    }

    public function testExtractReturnsCachedExtractWhenWeShould()
    {
        $this->startMockingFront();

        $dummy = new DummyCachableContentPresenter();

        $this->assertSame('cached extract&nbsp;...', $dummy->extract());

        $this->stopMockingFront();
    }

    public function testExtractReturnsFreshExtractWhenItShould()
    {
        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity(new DummyContentPresentableEntity());

        $this->assertSame("content&nbsp;...", $dummy->extract());
    }

    public function testRemovingCodeSamples()
    {
        $dummy = new DummyContentPresenter();

        $string = "``test``";
        $string2 = "````test something that should be valid code````";
        $string3 = "multiline\n````test something that should be valid code````";

        $this->assertSame('``test``', $dummy->removeCodeSamples($string));
        $this->assertSame("\n", $dummy->removeCodeSamples($string2));
        $this->assertSame("multiline\n\n", $dummy->removeCodeSamples($string3));
    }

    public function testFreshExtractHasCodeSamplesRemoved()
    {
        $entity = new DummyContentPresentableEntity();
        $entity->content = 'before extract````extract with some code````after extract';

        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity($entity);

        $this->assertSame("before extract\nafter extract", $dummy->freshlyBuiltExtract());
    }

    public function testFreshExtractHasMarkdownRemoved()
    {
        //we needed the markdown to be removed, but still keep the text.
        //easiest way was to compile it and strip tags after
        $entity = new DummyContentPresentableEntity();
        $entity->content = "# Some markdown title\n**bold or strong**";

        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity($entity);

        $this->assertSame("Some markdown title\nbold or strong", $dummy->freshlyBuiltExtract());
    }

    public function testFreshExtractHasShortCodesRemoved()
    {
        $entity = new DummyContentPresentableEntity();

        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity($entity);

        $entity->content = "#image#";
        $this->assertSame('', $dummy->freshlyBuiltExtract());

        $entity->content = "#image##image#";
        $this->assertSame('', $dummy->freshlyBuiltExtract());

        $entity->content = "text #image# text";
        $this->assertSame("text  text", $dummy->freshlyBuiltExtract());
    }

    public function testLimitingWordsForSnippetWorks()
    {
        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity(new DummyContentPresentableEntity());

        $this->assertSame('test word count&nbsp;...', $dummy->snippet('test word count', 3));
        $this->assertSame('test word&nbsp;...', $dummy->snippet('test word count', 2));
        $this->assertSame('test&nbsp;...', $dummy->snippet('test word count', 1));
    }

    public function testLimitingCharsForSnippetWorks()
    {
        $dummy = new DummyContentPresenter();
        $dummy->setPresentableEntity(new DummyContentPresentableEntity());

        $this->assertSame('charcount&nbsp;...', $dummy->snippet('charcount', 60, strlen('charcount')));
        $this->assertNull($dummy->snippet('charcount', 60, strlen('charcount') - 1));
        $this->assertNull($dummy->snippet('charcount', 60, strlen('charcount') - 2));

        $this->assertSame('charcount&nbsp;...', $dummy->snippet('charcount charcount', 60, strlen('charcount ')));
        $this->assertSame('charcount&nbsp;...', $dummy->snippet('charcount charcount', 60, strlen('charcount char')));
    }

    public function testGettingContentThroughCachedContent()
    {
        //mock the front
        $this->startMockingFront();

        $dummy = new DummyCachableContentPresenter();
        $entity = new DummyContentPresentableEntity();

        $dummy->setPresentableEntity($entity);
        $this->assertSame('cached content', $dummy->content());

        //switch back to most basic
        $this->stopMockingFront();
    }

    public function testGettingUncachedContent()
    {
        $dummy = new DummyContentPresenter();
        $entity = new DummyContentPresentableEntity();
        $entity->content = '# title **strong**';

        $dummy->setPresentableEntity($entity);

        $this->assertSame('<h1>title <strong>strong</strong></h1>', $dummy->content());
    }

}