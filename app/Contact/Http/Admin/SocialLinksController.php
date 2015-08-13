<?php namespace App\Contact\Http\Admin;

use App\Account\AccountManager;
use App\Contact\SocialLinks;
use App\System\Http\AdminController;
use Exception;
use Illuminate\Http\Request;

class SocialLinksController extends AdminController
{

    public function widget(SocialLinks $links)
    {
        return view('contact::admin.widgets.social-links', ['links' => $links->getFillable()]);
    }

    public function index(AccountManager $manager, Request $request)
    {
        $owner = $this->owner($request);

        return $owner->socialLinks()->firstOrCreate(['account_id' => $manager->account()->id]);
    }

    public function update(Request $request, AccountManager $manager, SocialLinks $links)
    {
        $rules = [];

        foreach($links->getFillable() as $link){
            $rules[$link] = 'url';
        }

        $this->validate($request, $rules);

        $owner = $this->owner($request);

        $links = $owner->socialLinks;

        $links->fill($request->except('id'));

        $links->save();
    }

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        $owners = config('contact.social_links_owners');

        if (!isset($owners[$type])) {
            throw new Exception('Invalid owner type provided for social links');
        }

        $class = $owners[$type];

        $class = new $class();

        return $class->findOrFail($id);
    }


}