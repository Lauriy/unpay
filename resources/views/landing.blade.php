@extends('layouts.app')

@section('content')
    <payment-details></payment-details>
    <payment-method-choice :payment-id="{{$paymentId}}"></payment-method-choice>
@endsection
