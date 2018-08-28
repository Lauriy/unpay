<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

# TODO: Extend this controller?
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function pay(PayRequest $payRequest)
    {
        Payment::create([

        ]);

        $omnipayResponse = Omnipay::purchase([

        ])->send();

        if ($omnipayResponse->isSuccessful()) {
            print_r($omnipayResponse);
        } elseif ($omnipayResponse->isRedirect()) {
            return $omnipayResponse->getRedirectResponse();
        } else {
            echo $omnipayResponse->getMessage();
        }
    }
}
