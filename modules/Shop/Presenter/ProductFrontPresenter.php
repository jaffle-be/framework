<?php namespace Modules\Shop\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\ContentPresenterTrait;
use Modules\System\Presenter\ShortCodeCompiler;

class ProductFrontPresenter extends BasePresenter
{
    protected $shortcodes = ['media'];

    use ContentPresenterTrait;
    use ShortCodeCompiler;
    use MediaShortcodes;


    public function categories()
    {
        $string = '';

        foreach($this->entity->categories as $category)
        {
            $string .= sprintf('<a href="%s">%s</a>', store_route('store.shop.category', [$category->translate()]), $category->name);
        }

        return $string;
    }

}