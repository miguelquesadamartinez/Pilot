@extends("layouts.app")

@section('content')

    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Laphal file check') }}</h1>
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

                    <form enctype="multipart/form-data" method="POST" class="user" action="/laphal/send-file">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input required name="laphal_file" id="laphal_file" type="file" accept=".xls,.xlsx" class="form-control form-control-user" >
                            </div>
                            <div style="margin-top: 8px;" class="col-sm-4">
                                <input required type="date" name="search_date_init" placeholder="{{ __('Date') }}"  value="{{ !empty($search_date_init) ? $search_date_init : '' }}" class="form-control">
                            </div>
                            <div style="margin-top: 8px;" class="col-sm-4">
                                <input required type="date" name="search_date_end" placeholder="{{ __('Date') }}"  value="{{ !empty($search_date_end) ? $search_date_end : '' }}" class="form-control">
                            </div>
                            <div style="margin-top: 8px;" class="col-sm-1">
                                <button id="submitButton" class="btn btn-primary" type="submit" data-dismiss="modal">{{ __('Upload') }}</button>
                            </div>
                        </div>
                    </form>

                    @if(isset($dsmOrdersNotInFile) && $dsmOrdersNotInFile->count() > 0 )
                        <div class="alert alert-primary">
                            {{ __('Orders not in file') }}: {{$fileName}} - 
                            {{ Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - 
                            {{ Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('Order Reference') }}</th>
                                        <th class="th-sm">{{ __('Pharmacy') }}</th>
                                        <th class="th-sm">{{ __('CIP') }}</th>
                                        <th class="th-sm">{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($dsmOrdersNotInFile as $order)
                                    <tr>
                                        <td>{{$order->reference}}</td>
                                        <td>{{$order->pharmacy->name}}</td>
                                        <td>{{$order->pharmacy->cip}}</td>
                                        <td>{{ Carbon\Carbon::parse($order->updated_at)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($noResults) && $noResults == true)
                        <div class="text-center">
                            <b>{{ __('No orders missing') }}</b>
                        </div>   
                    @endif

                </div>
            </div>
        </div>  
    </div>
</div>

@endsection
