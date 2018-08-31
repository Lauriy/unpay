<?php

namespace App\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class ChoosePaymentMethodRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            # TODO: Complex validation based on payment method chosen
            'method' => 'string|required|in:' . implode(',', array_keys(config('omnipay.gateways'))),
            'creditCardNumber' => ['string', new CardNumber],
            'creditCardHolder' => 'string',
            'creditCardExpirationYear' => ['int', new CardExpirationYear($this->get('creditCardExpirationMonth'))],
            'creditCardExpirationMonth' => ['int', new CardExpirationMonth($this->get('creditCardExpirationYear'))],
            # TODO: Restore
            'creditCardCvc' => ['int', /*new CardCvc($this->get('creditCardCvc'))*/]
        ];
    }
}
