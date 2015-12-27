<?php

namespace Modules\Account\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\Client;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;

/**
 * Class ClientController
 * @package Modules\Account\Http\Admin
 */
class ClientController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page()
    {
        return view('account::admin.clients.page');
    }

    /**
     * @param Client $client
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Client $client)
    {
        $clients = $client->with(['translations'])->get();

        foreach ($clients as $client) {
            $this->prepareImages($client);
        }

        return $clients;
    }

    /**
     * @param Client $client
     * @param Request $request
     * @param AccountManager $manager
     * @return static
     */
    public function store(Client $client, Request $request, AccountManager $manager)
    {
        $input = array_merge(['account_id' => $manager->account()->id], translation_input($request, ['description']));

        return $client->create($input);
    }

    /**
     * @param Client $client
     * @param Request $request
     */
    public function update(Client $client, Request $request)
    {
        $client->fill(translation_input($request, ['description']));

        $client->save();
    }

    /**
     * @param Client $client
     * @throws \Exception
     */
    public function destroy(Client $client)
    {
        $client->delete();
    }
}
