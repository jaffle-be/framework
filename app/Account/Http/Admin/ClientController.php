<?php namespace App\Account\Http\Admin;

use App\Account\AccountManager;
use App\Account\Client;
use App\System\Http\AdminController;
use Illuminate\Http\Request;

class ClientController extends AdminController
{

    public function page()
    {
        return view('account::admin.clients.page');
    }

    public function index(Client $client)
    {
        return $client->with(['translations', 'images', 'images.translations'])->get();
    }

    public function store(Client $client, Request $request, AccountManager $manager)
    {
        $input = array_merge(['account_id' => $manager->account()->id], translation_input($request, ['description']));

        return $client->create($input);
    }

    public function update(Client $client, Request $request)
    {
        $client->fill(translation_input($request, ['description']));

        $client->save();
    }

    public function destroy(Client $client)
    {
        $client->delete();
    }

}