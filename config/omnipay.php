<?php

return [
    # Default gateway
    'gateway' => 'Dummy',
    'defaults' => [
        'testMode' => true,
    ],
    'gateways' => [
        //'PayPal_Express' => [
        //    'username' => 'AYADOBuJg8LN6JS57G7JdnTD4_x4oL3ZuL39UD3LNLUvJx9RfIRRcwaflAWMbQQJ72c7DHRa0h0mBpsT',
        //    'password' => 'EMhfXwrNUYN2oOrG5pj68o0iHCaVZrIqVlz6c-z-8jsAsuiJsE7UHJYyrlUnPyy_C-Vd4Vmd8s-AzsVB',
        //    'signature' => '',
        //    'solutionType' => ['Sole', 'Mark'],
        //    'landingPage' => ['billing', 'login'],
        //    'brandName' => 'UNCTAD',
        //    'headerImageUrl' => '',
        //    'logoImageUrl' => '',
        //    'borderColor' => ''
        //],
        'Dummy' => [

        ],
        'TwoCheckout' => [
            'accountNumber' => '901390248',
            'secretWord' => 'N2IxNzlkOTUtNGIxNi00ZWI0LThhODktOGJmMDk0ZDdkNmI5'
        ]
    ],
];