@extends("layouts.app")

@section('content')

    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Search') }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-3">

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>    
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0px !important;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form enctype="multipart/form-data" method="POST" class="user" action="/admin/dataloader/send-sage">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-11 mb-3 mb-sm-0">

                            <input name="sage_file" id="sage_file" type="file" accept=".txt,.csv" class="form-control form-control-user" >
                            
                            <input id="name" name="name" type="text" class="form-control form-control-user" >

                            </div>
                            <div style="margin-top: 8px;" class="col-sm-1">
                                <button id="submitButton" class="btn btn-success" type="submit" data-dismiss="modal">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>

                    @isset ($orders)
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0px !important;">
                                @foreach ($orders as $order)
                                    <li>{{ $order->REFERENCE_ODOO }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endisset

                </div>
            </div>
        </div>  
    </div>
</div>

@endsection
