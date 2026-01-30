<!DOCTYPE html>

<html class="loading">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('Qr Code for order') }}: {{$orderNum}}</title>
    </head>
    <body>
        <div class="container">
            <div style="text-align: center;">
                <h2>{{ __('Qr Code for order') }}: {{$orderNum}}</h2>
                <h2>{{ __('Pharmacy') }}: {{$order->pharmacyName}} ( {{ $order->CIP }} )</h2>
                @if(isset($order->product))
                    <h2>{{ __('Laboratory') }}: {{$order->product->laboratory->name}}</h2>
                @endif
                <h1>{{ __('QRcode for return') }}</h1>
                <img src="data:image/png;base64,{{ base64_encode($qrCodeData) }}" alt="QR Code">
                <br />
                <br />
                <a href="{{$url}}">{{$url}}</a>
            </div>
        </div>
    </body>
</html>
