<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChoosePaymentMethodRequest;
use App\Payment;
use http\Exception\BadMethodCallException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Omnipay\Omnipay;

class PaymentApiController extends Controller
{
    const NOT_IMPLEMENTED_ERROR_MESSAGE = 'Not implemented';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Payment::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        throw new BadMethodCallException(self::NOT_IMPLEMENTED_ERROR_MESSAGE);
    }

    public function listMethods($id)
    {
        $payment = Payment::findOrFail($id);

        # TODO: don't just return all of them
        return array_keys(config('omnipay.gateways'));
    }

    public function chooseMethod($id, ChoosePaymentMethodRequest $chooseMethodRequest)
    {
        $payment = Payment::findOrFail($id);
        $chosenMethod = $chooseMethodRequest->get('method');
        # TODO: validations
        $payment->chosen_method = $chosenMethod;
        $payment->save();

        # FIXME: figure out barryvdh/laravel-omnipay usage
        //$omnipay = App::make('omnipay');
        //$omnipay->setDefaultGateway($chosenMethod);
        //
        //$card = Omnipay::creditCard($cardInput);
        //
        //$response = App::make('omnipay')->purchase([
        //    'amount' => $payment->amount_in_cents / 100,
        //    'returnUrl' => 'http://localhost:8000/return',
        //    'cancelUrl' => 'http://localhost:8000/cancel',
        //    'card' => $card
        //]);

        $gateway = Omnipay::create($chosenMethod);
        $requestData = [
            'amount' => $payment->amount_in_cents / 100,
            'currency' => $payment->currency,
            'returnUrl' => 'http://localhost:8000/return',
            'card' => [
                'number' => $chooseMethodRequest['creditCardNumber'],
                'firstName' => $chooseMethodRequest['creditCardHolder'],
                'expiryMonth' => $chooseMethodRequest['creditCardExpiryMonth'],
                'expiryYear' => $chooseMethodRequest['creditCardExpiryYear'],
                'cvv' => $chooseMethodRequest['creditCardCvc'],
            ]
        ];
        if ($gateway->getName() === 'Dummy') {

        } else {
            # FIXME: We cannot configure this way, must get barryvdh/laravel-omnipay autoloading working
            $gateway->setAccountNumber(config('omnipay.gateways.TwoCheckoutPlus.accountNumber'));
            $gateway->setSecretWord(config('omnipay.gateways.TwoCheckoutPlus.secretWord'));
            $gateway->setTestMode(true);
            $gateway->setDemoMode(true);
            $cart = [
                [
                    'product_id' => 1,
                    'name' => 'Estonian Tax and Customs Board',
                    'type' => 'Registry call',
                    'quantity' => 1,
                    'price' => $payment->amount_in_cents / 100
                ]
            ];
            $gateway->setCart($cart);
        }
        $request = $gateway->purchase($requestData);
        $payment->request_data = json_encode($request->getData());
        $payment->save();
        $response = $request->send();

        if ($response->isRedirect()) {
            return ['redirectUrl' => $response->getRedirectUrl()];
        }

        if ($response->isSuccessful()) {
            # FIXME: Don't allow redoing this
            $payment->response_data = json_encode($response->getData());
            $payment->paid_at = Carbon::now();
            $payment->save();
            return ['redirectUrl' => $payment->callback_url];
        }

        $payment->response_data = json_encode($response->getMessage());
        $payment->save();

        return ['redirectUrl' => redirect()->to('error')];
    }

//    public function methodChoice(AccessPaymentRequest $accessPaymentRequest)
//    {
//        $returnUrl =
//        $omnipayResponse = Omnipay::purchase([
//            'amount' => $payRequest->get('amountInCents') / 100,
//            'returnUrl' => $returnUrl
//        ])->send();
//
//        if ($omnipayResponse->isSuccessful()) {
//            print_r($omnipayResponse);
//        } elseif ($omnipayResponse->isRedirect()) {
//            return $omnipayResponse->getRedirectResponse();
//        } else {
//            echo $omnipayResponse->getMessage();
//        }
//    }
}
