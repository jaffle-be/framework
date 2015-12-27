<?php

namespace Modules\Account\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\Client;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;

class ClientController extends AdminController
{

    use MediaWidgetPreperations;

    public function page()
    {
        return view('account::admin.clients.page');
    }

    public function index(Client $client)
    {
        $clients = $client->with(['translations'])->get();

        foreach ($clients as $client) {
            $this->prepareImages($client);
        }

        return $clients;
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
