<?php namespace Test\System\Translatable;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery as m;
use Modules\System\Translatable\Translatable;
use Modules\System\Translatable\TranslationModel;
use Test\TestCase;

class StubModel extends Model{

    public $parentSaver;

    public function save(array $options = [])
    {
        return $this->parentSaver->save($options);
    }
}

class TranslatableStub extends StubModel
{

    public $translatedAttributes = [];

    public $translationForeignKey = false;

    public $translationModel = false;

    public $localeKey = false;

    public $translations = [];

    public $useTranslationFallback = false;

    use Translatable;

    public function getForeignKey()
    {
        return 'foreign key';
    }
}

class TranslatableStubTranslation extends TranslationModel
{

}

class TranslationStub
{

    public $attributes = [
        'locale' => 'en'
    ];

    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }
}

class TranslatableTest extends TestCase
{

    public function testTranslateOrNew()
    {
        $mock = m::mock(TranslatableStub::class.'[translate,getNewTranslation]');

        //all we're doing here is testing if we're calling the new translation method if we dont have a translation yet.
        //if we do, we return that translation.

        $translation = new \stdClass();

        //first test says we do
        $mock->shouldReceive('translate')->once()->with('locale', false)->andReturn($translation);
        $mock->shouldNotReceive('getNewTranslation');

        $this->assertSame($translation, $mock->translateOrNew('locale'));

        //second test says we dont
        $mock->shouldReceive('translate')->once()->with('locale', false)->andReturnNull();
        $mock->shouldReceive('getNewTranslation')->once()->with('locale')->andReturn($translation);

        $this->assertSame($translation, $mock->translateOrNew('locale'));
    }

    public function testTranslateWithoutLocaleAndWithoutFallback()
    {
        //without fallback the locale should be the one from our app
        //
    }

    public function testGettingTranslationWithFallback()
    {

    }

    public function testFilling()
    {

    }

    public function testGettingAttribute()
    {

    }

    public function testSettingAttribute()
    {

    }

    public function testUseFallbackLocale()
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->with('system.use_fallback', null)->andReturn(false);
        app()->instance('config', $config);

        //stub has false on property should return false
        $stub = new TranslatableStub();
        $this->assertFalse($stub->useFallback());

        //when its true, it should be true
        $stub->useTranslationFallback = true;
        $this->assertTrue($stub->useFallback());

        //set it back to false to test behaviour of system value
        $stub->useTranslationFallback = false;
        //this was in fact already tested in our first assertion
        $this->assertFalse($stub->useFallback());

        //but when our config returns true, it should assert to true, use a new mock for a new assertion on same method
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->with('system.use_fallback', null)->andReturn(true);
        app()->instance('config', $config);
        $this->assertTrue($stub->useFallback());
    }

    public function testGettingFallbackLocale()
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->with('system.fallback_locale', null)->once()->andReturn(true);
        app()->instance('config', $config);

        $stub = new TranslatableStub();
        $this->assertTrue($stub->getFallbackLocale());
    }

    public function testHasTranslation()
    {
        $stub = new TranslatableStub();

        //test it uses app locale if none specified, our stub uses 'en' which is the default
        $stub->translations = [new TranslationStub()];
        $this->assertTrue($stub->hastranslation());

        $stub->translations = [];
        $this->assertFalse($stub->hastranslation());

        //test using defined language
        $stub->translations = [new TranslationStub()];
        $this->assertTrue($stub->hastranslation('en'));

        $stub->translations = [];
        $this->assertFalse($stub->hastranslation('en'));
    }

    public function testGettingTranslationModelName()
    {
        $stub = new TranslatableStub();
        $this->assertSame(get_class($stub).'Translation', $stub->getTranslationModelName());

        $stub->translationModel = 'CustomTranslation';
        $this->assertSame('CustomTranslation', $stub->getTranslationModelName());
    }

    public function testGettingTranslationModelDefaultName()
    {
        $stub = new TranslatableStub();

        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->once()->with('system.translation_suffix', 'Translation')->andReturn('config suffix');
        app()->instance('config', $config);

        $this->assertSame(get_class($stub).'config suffix', $stub->getTranslationModelNameDefault());

        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->once()->with('system.translation_suffix', 'Translation')->andReturn('Translation');
        app()->instance('config', $config);

        $this->assertSame(get_class($stub).'Translation', $stub->getTranslationModelNameDefault());
    }

    public function testGettingRelationKey()
    {
        $stub = new TranslatableStub();
        $this->assertSame('foreign key', $stub->getRelationKey());

        $stub->translationForeignKey = 'custom foreign key';
        $this->assertSame('custom foreign key', $stub->getRelationKey());
    }

    public function testGettingLocaleKey()
    {
        //from config
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->once()->with('system.locale_key', 'locale')->andReturn('config locale key');
        app()->instance('config', $config);
        $stub = new TranslatableStub();
        $this->assertSame('config locale key', $stub->getLocaleKey());

        //from default specified value, when config has key specified
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->once()->with('system.locale_key', 'locale')->andReturn('locale');
        app()->instance('config', $config);
        $this->assertSame('locale', $stub->getLocaleKey());

        $stub->localeKey = 'custom locale key';
        $this->assertSame('custom locale key', $stub->getLocaleKey());
    }

    public function testTranslationsRelation()
    {
        $stub = new TranslatableStub();
        /** @var HasMany $relation */
        $relation = $stub->translations();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(TranslatableStubTranslation::class, $relation->getRelated());
        $this->assertInstanceOf(TranslatableStub::class, $relation->getParent());
    }

    public function testIsTranslationAttribute()
    {
        $stub = new TranslatableStub();
        $stub->translatedAttributes = ['name', 'test'];

        $this->assertTrue($stub->isTranslationAttribute('name'));
        $this->assertTrue($stub->isTranslationAttribute('test'));
        $this->assertFalse($stub->isTranslationAttribute('unknown'));
    }

    public function testIsKeyALocale()
    {
        $stub = new TranslatableStub();

        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->twice()->with('system.locales', null)->andReturn(['en', 'nl']);
        app()->instance('config', $config);

        $this->assertTrue($stub->isKeyALocale('en'));
        $this->assertFalse($stub->isKeyALocale('de'));

    }

    /**
     * @expectedException \Modules\System\Translatable\Exception\LocalesNotDefinedException
     */
    public function testGettingLocales()
    {
        $stub = new TranslatableStub();

        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->with('system.locales', null)->once()->andReturn(['en', 'nl']);
        app()->instance('config', $config);

        $this->assertSame(['en', 'nl'], $stub->getLocales());

        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->with('system.locales', null)->once()->andReturn([]);
        app()->instance('config', $config);

        $stub->getLocales();
    }

    public function testSaveTranslations()
    {
        $stub = m::mock(TranslatableStub::class);
        $stub->makePartial();

        //lets assume our first model to not be dirty
        //second one is dirty
        //so is the thirth, but it fails
        //so the last one shouldnt be saved

        //this means the following expectations for each translation
        $translation1 = m::mock(TranslatableStubTranslation::class);
        $stub->shouldReceive('isTranslationDirty')->once()->with($translation1)->andReturn(false);
        $translation1->shouldNotReceive('setAttribute');
        $translation1->shouldNotReceive('save');

        $translation2 = m::mock(TranslatableStubTranslation::class);
        $stub->shouldReceive('isTranslationDirty')->once()->with($translation2)->andReturn(true);
        $translation2->shouldReceive('setAttribute')->once()->with($stub->getRelationKey(), $stub->getKey());
        $translation2->shouldReceive('save')->once()->andReturn(true);

        $translation3 = m::mock(TranslatableStubTranslation::class);
        $stub->shouldReceive('isTranslationDirty')->once()->with($translation3)->andReturn(true);
        $translation3->shouldReceive('setAttribute')->once()->with($stub->getRelationKey(), $stub->getKey());
        $translation3->shouldReceive('save')->once()->andReturn(false);

        $translation4 = m::mock(TranslatableStubTranslation::class);
        $stub->shouldNotReceive('isTranslationDirty')->with($translation4);
        $translation4->shouldNotReceive('setAttribute');
        $translation4->shouldNotReceive('save');

        $stub->translations = [
            $translation1,
            $translation2,
            $translation3,
            $translation4,
        ];

        //the end result should be a falls due to failure on the 3th element
        $this->assertFalse($stub->saveTranslations());
    }

    public function testIsTranslationDirty()
    {
        $stub = new TranslatableStub();
        $stub->translatedAttributes = ['name'];

        $translation = new TranslatableStubTranslation();
        $this->assertFalse($stub->isTranslationDirty($translation));
        $translation->name = 'some name';
        $this->assertTrue($stub->isTranslationDirty($translation));
    }

    public function testSavingAnExistingModel()
    {
        //need to make it a partial mock in order to make the parent::save() thing to work.
        //this means we can set expectactions on all methods, except for the save method.
        //we cannot mock it, or we'de have no more logic calling the parent::save() method.
        $stub = m::mock(TranslatableStub::class)->makePartial();
        $stub->exists = true;
        $stub->shouldReceive('saveTranslations')->once()->andReturn(true);

        $parentSaver = m::mock('parent_saver');
        $stub->parentSaver = $parentSaver;
        $parentSaver->shouldReceive('save')->once()->andReturn(true);

        $this->assertTrue($stub->save());

        //when translations couldn't be save properly, we dont save the parent.
        $stub = m::mock(TranslatableStub::class)->makePartial();
        $stub->exists = true;
        $stub->shouldReceive('saveTranslations')->once()->andReturn(false);
        $parentSaver = m::mock('parent_saver');
        $stub->parentSaver = $parentSaver;
        $parentSaver->shouldNotReceive('save');

        $this->assertFalse($stub->save());
    }

    public function testSavingAnewModel()
    {
        $stub = m::mock(TranslatableStub::class)->makePartial();

        //when parent save fails, translations shouldn't be saved
        $parent = m::mock('parent_saver');
        $parent->shouldReceive('save')->andReturn(false);
        $stub->parentSaver = $parent;

        $stub->shouldNotReceive('saveTranslations');

        $this->assertFalse($stub->save());

        //when parent save fails, translations shouldn't be saved
        $parent = m::mock('parent_saver');
        $parent->shouldReceive('save')->andReturn(true);
        $stub->parentSaver = $parent;

        $stub->shouldReceive('saveTranslations')->once()->andReturn('save translations result');

        $this->assertSame('save translations result', $stub->save());
    }

    public function testGettingNewTranslation()
    {
        //need to mock construction since we're initiating a new Model instance within the function
        //or it fails due to datase reasons.
        $collection = m::mock('collection');
        $collection->shouldReceive('add')->with(m::on(function($argument){
            return $argument instanceof TranslatableStubTranslation;
        }))->once();

        $mock = m::mock(TranslatableStub::class)->makePartial();
        $mock->translations = $collection;

        $mock->shouldReceive('getTranslationModelName')->once()->andReturn(TranslatableStubTranslation::class);
        $mock->shouldReceive('getLocaleKey')->once()->andReturn('localeKey');

        $result = $mock->getNewTranslation('en');

        $this->assertInstanceOf(TranslatableStubTranslation::class, $result);
        $this->assertSame('en', $result->getAttribute('localeKey'));
    }

    public function testScopingTranslatedIn()
    {
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('whereHas')->with('translations', m::on(function ($argument) {
            return $argument instanceof \Closure;
        }))->once()->andReturnSelf();

        $stub = new TranslatableStub();
        $stub->scopeTranslatedIn($builder, 'en');
    }

    public function testScopingTranslated()
    {
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('has')->with('translations')->once()->andReturnSelf();

        $stub = new TranslatableStub();
        $stub->scopeTranslated($builder);
    }

    public function testScopingListsTranslations()
    {
        //verifying the end query is alot easier then mocking every method.
        $stub = new TranslatableStub();
        $query = $stub->listsTranslations('name');
        $sql = 'select `translatable_stubs`.`id`, `translatable_stub_translations`.`name` from `translatable_stubs` left join `translatable_stub_translations` on `translatable_stub_translations`.`foreign key` = `translatable_stubs`.`id` where `translatable_stub_translations`.`locale` = ?';
        $this->assertSame($sql, $query->toSql());

        //when using a fallback it produces a very ugly query :(
        //query is the same, but it should add a 'or where' clause
        //specifying it can be from the fallback locale, but only when it didn't have the requested locale
        //for that second part it uses a subselect query
        $stub->useTranslationFallback = 'de';
        $query = $stub->listsTranslations('name');
        $sql = 'select `translatable_stubs`.`id`, `translatable_stub_translations`.`name` from `translatable_stubs` left join `translatable_stub_translations` on `translatable_stub_translations`.`foreign key` = `translatable_stubs`.`id` where `translatable_stub_translations`.`locale` = ? or (`translatable_stub_translations`.`locale` = ? and `translatable_stub_translations`.`foreign key` not in (select `translatable_stub_translations`.`foreign key` from `translatable_stub_translations` where `translatable_stub_translations`.`locale` = ?))';
        $this->assertSame($sql, $query->toSql());
    }

    public function testAlwasFillable()
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('get')->once()->with('system.always_fillable', false)->andReturn('some value');
        app()->instance('config', $config);

        $stub = new TranslatableStub();
        $this->assertSame('some value', $stub->alwaysFillable());
    }

    public function testGettingTranslationTable()
    {
        $mock = m::mock(TranslatableStub::class);
        $mock->makePartial();
        $mock->shouldReceive('getTranslationModelName')->once()->andReturn('classname');

        $translation = m::mock(Model::class);
        $translation->shouldReceive('getTable')->once()->andReturn('the table name');

        $app = m::mock(Container::class);
        $app->shouldReceive('make')->once()->with('classname', [])->andReturn($translation);
        app()->setInstance($app);

        $this->assertSame('the table name', $mock->getTranslationsTable());
    }

}
