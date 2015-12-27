<?php

namespace Modules\System\Validators;

use Illuminate\Http\Request;
use SoapClient;

/**
 * Class Vat
 * @package Modules\System\Validators
 */
class Vat
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = [])
    {
        $client = new SoapClient('http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl');

        //some people will add dots to the vat number.
        //we need to replace them when checking the number.
        $value = trim(str_replace('.', '', $value));

        try {
            $response = $client->checkVat([
                'countryCode' => $this->request->get('vat_country', 'BE'),
                'vatNumber' => $value,
            ]);
        } catch (\Exception $e) {
            //this might allow bad vat numbers to be inserted, we'd need a method just for updating the vat
            //to have better control. We shouldn't be updating the vat with all other model fields.
            return true;
        }

        return $response->valid;
    }
}
