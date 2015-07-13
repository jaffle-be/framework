<?php namespace App\System\Validators;

use Illuminate\Http\Request;
use SoapClient;

class Vat
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate($attribute, $value, $parameters = array())
    {
        $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");

        //some people will add dots to the vat number.
        //we need to replace them when checking the number.
        $value = trim(str_replace('.', '', $value));

        $response = $client->checkVat(array(
            'countryCode' => $this->request->get('vat_country', 'BE'),
            'vatNumber'   => $value
        ));

        return $response->valid;
    }

}