<?php

namespace Modules\Contact\Http\Admin;

use Exception;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Contact\SocialLinks;
use Modules\System\Http\AdminController;

/**
 * Class SocialLinksController
 * @package Modules\Contact\Http\Admin
 */
class SocialLinksController extends AdminController
{
    /**
     * @param SocialLinks $links
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function widget(SocialLinks $links)
    {
        return view('contact::admin.widgets.social-links', ['links' => $links->getFillable()]);
    }

    /**
     * @param AccountManager $manager
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function index(AccountManager $manager, Request $request)
    {
        $owner = $this->owner($request);

        return $owner->socialLinks()->firstOrCreate(['account_id' => $manager->account()->id]);
    }

    /**
     * @param Request $request
     * @param AccountManager $manager
     * @param SocialLinks $links
     * @throws Exception
     */
    public function update(Request $request, AccountManager $manager, SocialLinks $links)
    {
        $rules = [];

        foreach ($links->getFillable() as $link) {
            $rules[$link] = 'url';
        }

        $this->validate($request, $rules);

        $owner = $this->owner($request);

        $links = $owner->socialLinks;

        $links->fill($request->except('id'));

        $links->save();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        $owners = config('contact.social_links_owners');

        if (! isset($owners[$type])) {
            throw new Exception('Invalid owner type provided for social links');
        }

        $class = $owners[$type];

        $class = new $class();

        return $class->findOrFail($id);
    }
}
