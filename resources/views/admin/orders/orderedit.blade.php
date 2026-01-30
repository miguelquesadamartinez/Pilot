@extends("layouts.app")

@section('content')

    @include('admin.searcher.searchform')

    @isset($order)
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Order') }}: <b>{{$order->OrderNum}}</b>
            </div>
            <div class="card-body">

                {{$order}}

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-center">
                                {{ __('Tracking Number') }}
                            </div>
                            <div class="text-center">
                                <b>{{$order->tracking_number}}</b>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="campo1">{{ __('Delivery status') }}</label>
                            <input type="text" class="form-control" id="campo1" placeholder="Texto del campo 1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

@endsection
