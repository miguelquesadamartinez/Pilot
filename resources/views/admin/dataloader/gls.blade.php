@extends("layouts.app")

@section('content')

    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Tracking from GLS') }}</h1>
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

                    <form enctype="multipart/form-data" method="POST" class="user" action="/admin/dataloader/send-gls">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-11 mb-3 mb-sm-0">

                            <input name="gls_file" id="gls_file" type="file" accept=".csv" class="form-control form-control-user" >

                            </div>
                            <div style="margin-top: 8px;" class="col-sm-1">
                                <button id="submitButton" class="btn btn-primary" type="submit" data-dismiss="modal">{{ __('Upload') }}</button>
                            </div>
                        </div>
                    </form>

                    @isset ($entrega)
                        <div class="alert alert-primary">
                        {{ __('Founded orders number') }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('Tracking number') }}</th>
                                        <th class="th-sm">{{ __('Order number') }}</th>
                                        <th class="th-sm">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($entrega as $ent)
                                    <tr>
                                        <td>{{$ent->colisNum}}</td>
                                        <td>{{$ent->orderNum}}</td>
                                        <td>{{$ent->status}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>    
                    @endisset

                    @isset ($return_array_not_found)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('Order number not found') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($return_array_not_found as $ret)
                                    <tr>
                                        <td>{{$ret}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>    
                    @endisset

                    @isset($no_data)
                        {{ __('No data inserted') }}
                    @endisset
                </div>
            </div>
        </div>  
    </div>
</div>

@endsection
