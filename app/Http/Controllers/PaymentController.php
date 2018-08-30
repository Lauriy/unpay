<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listMethods($id)
    {
        $payment = Payment::findOrFail($id);

        # TODO: don't just return all of them
        return array_keys(config('omnipay.gateways'));
    }

    public function chooseMethod($id, $chooseMethodRequest)
    {
        $payment = Payment::findOrFail($id);
        $chosenMethod = $chooseMethodRequest->get('method');
        $payment->chosen_method = $chosenMethod;
        # TODO: validations
        $payment->save();

        # TODO: Maybe return array of required fields here? Then another request where the client sends those?
        # Or maybe just allow sending all the fields but keep the optional
        omnipay()->setGateway($chosenMethod);

        $cardInput = [
            'number' => $chooseMethodRequest['creditCardNumber'],
            'firstName' => $chooseMethodRequest['creditCardHolder'],
            'expiryMonth' => $chooseMethodRequest['creditCardExpiryMonth'],
            'expiryYear' => $chooseMethodRequest['creditCardExpiryYear'],
            'cvv' => $chooseMethodRequest['creditCardCvc'],
        ];
        $card = Omnipay::creditCard($cardInput);

        $response = Omnipay::purchase([
            'amount' => $payment->amount_in_cents / 100,
            'returnUrl' => 'http://localhost:8000/return',
            'cancelUrl' => 'http://localhost:8000/cancel',
            'card' => $card
        ]);

        return $response;
    }
}
