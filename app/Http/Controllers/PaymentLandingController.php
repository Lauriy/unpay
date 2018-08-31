<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandRequest;
use App\Payment;

class PaymentLandingController extends Controller
{
    # TODO: Replace this with a JWT-protected API call that should come from one of the 'parts'
    public function land(LandRequest $landRequest)
    {
        $payment = Payment::firstOrCreate(['reference' => $landRequest['reference']], [
            'amount_in_cents' => $landRequest['amountInCents'],
            'currency' => $landRequest['currency'],
            'country' => $landRequest['country'],
            'callback_url' => $landRequest['callbackUrl']
        ]);

        return view('landing', [
            'paymentId' => $payment->id
        ]);
    }

    public function bankResponse($id)
    {
        # TODO: Handle success/fail events
    }
}
