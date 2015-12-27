<?php

namespace Modules\Shop\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\ContentPresenterTrait;
use Modules\System\Presenter\ShortCodeCompiler;

/**
 * Class ProductFrontPresenter
 * @package Modules\Shop\Presenter
 */
class ProductFrontPresenter extends BasePresenter
{
    protected $shortcodes = ['media'];

    use ContentPresenterTrait;
    use ShortCodeCompiler;
    use MediaShortcodes;

    /**
     * @return string
     */
    public function categories()
    {
        $string = '';

        foreach ($this->entity->categories as $category) {
            $string .= sprintf('<a href="%s">%s</a> ', store_route('store.shop.category', [$category->translate()]), $category->name);
        }

        return $string;
    }
}
