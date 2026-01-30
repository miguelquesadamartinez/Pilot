@extends("layouts.app")
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($success) && $success != '')
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'updated_recording')
                                    {{ __('Recording updated successfully') }}
                                @elseif($success == 'new cat')
                                    {{ __('Category created successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @include('admin.searcher.searchform')

    @isset($order)
        @unless(auth()->user()->hasAnyRole(['TeleOperator']))
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Order') }}: <b>{{$order->OrderNum}}</b>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
@php
/*
@endphp
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Tracking Number') }}
                            </div>
                            <div class="text-center">
                            @if($order->colisNum != '')    
                                <b>{{$order->colisNum}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Delivery status') }}
                            </div>
                            <div class="text-center">
                                <b>{{$order->deliveryStatus}}</b>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Shipping date') }}
                            </div>
                            <div class="text-center">
                            @if($order->dateExpedition != '')    
                                <b>{{ date('d-m-Y', strtotime($order->dateExpedition)) }}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
@php
*/
@endphp
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Pharmacy name') }}
                            </div>
                            <div class="text-center">
                                <b>{{html_entity_decode($order->pharmacyName)}}</b>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('CIP') }}
                            </div>
                            <div class="text-center">
                                <b>{{$order->CIP}}</b>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Order date') }}
                            </div>
                            <div class="text-center">
                            @if($order->orderDate != '')    
                                <b>{{ date('d-m-Y', strtotime($order->orderDate)) }}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Order status') }}
                            </div>
                            <div class="text-center">
                                <b>{{$order->sageStatus}}</b>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Desired delivery date') }}
                            </div>
                            <div class="text-center">
                                @if($order->desiredDeliveryDate != '')
                                    <b>{{ date('d-m-Y', strtotime($order->desiredDeliveryDate)) }}</b>
                                @else
                                    --{{ __('Without data') }}--
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Delivery date') }}
                            </div>
                            <div class="text-center">
                            @if($order->dateLivrasion != '')    
                                <b>{{ date('d-m-Y', strtotime($order->dateLivrasion)) }}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Proof of delivery') }}
                            </div>
                            <div class="text-center">
                            @if(isset($order->deliveryFile->id) && $order->deliveryFile->id != '')    
                                <a target="_blank" href="{{route('get.file.proof', $order->deliveryFile->id)}}">{{$order->deliveryFile->fileName}}</a>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>

@php
/*
@endphp

                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Download proof') }}
                            </div>
                            <div class="text-center">
                            @if(isset($order->deliveryFile->id) && $order->deliveryFile->id != '')    
                                <a href="{{route('download.ticket', $order->deliveryFile->id)}}"><i class="fas fa-edit"></i></a>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>

@php
*/
@endphp
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Open tickets') }}
                            </div>
                            <div class="text-center">
                            @if(count ($order->tickets) )    
                                <b><a href="#ticketing">{{ __('View') }}</a>
                                </b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Agent') }}
                            </div>
                            <div class="text-center">
                                <b>{{ 
                                    $order->agent_name 
                                }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Invoices') }}</b>
            </div>
            <div class="card-body">  
            @if($invoices != false)
                <div class="form-group">
                    <div class="row">
                        @foreach($invoices as $invoice)
                            <div class="col-lg-2">
                                <div class="text-center">
                                    {{ __('Download invoice') }} {{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}
                                </div>
                                <div class="text-center">
                                    <a href="{{route('download.invoice', [$order->id, $invoice->invoice, $invoiceType])}}"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            </div>
        </div>
        @else 
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Order') }}: <b>{{$order->OrderNum}}</b>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="text-center">
                                {{ __('Order date') }}
                            </div>
                            <div class="text-center">
                            @if($order->orderDate != '')    
                                <b>{{ date('d-m-Y', strtotime($order->orderDate)) }}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center">
                                {{ __('Pharmacy name') }}
                            </div>
                            <div class="text-center">
                                <b>{{html_entity_decode($order->pharmacyName)}}</b>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center">
                                {{ __('CIP') }}
                            </div>
                            <div class="text-center">
                                <b>{{$order->CIP}}</b>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center">
                                {{ __('Shipping date') }}
                            </div>
                            <div class="text-center">
                            @if($order->dateExpedition != '')    
                                <b>{{ date('d-m-Y', strtotime($order->dateExpedition)) }}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Invoices') }}</b>
            </div>
            <div class="card-body">
                
            @if($invoices != false)
                <div class="form-group">
                    <div class="row">
                    
                        @foreach($invoices as $invoice)
                            <div class="col-lg-2">
                                <div class="text-center">
                                    {{ __('Download invoice') }} {{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}
                                </div>
                                <div class="text-center">
                                    
                                    <a href="{{route('download.invoice', [$order->id, $invoice->invoice, $invoiceType])}}"><i class="fas fa-edit"></i></a>
                                    
                                </div>
                            </div>
                        @endforeach
                    
                    </div>
                </div>
            @endif
            </div>
        </div>
        @endunless
    @endisset
    @if($pharmacy != null)
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Pharmacy') }}: <b>{{$pharmacy->name}}</b>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                    <div class="col-lg-4">
                            <div class="text-center">
                                {{ __('e-mail') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->email != '')    
                                <b>{{$pharmacy->email}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('CIP') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->cip != '')    
                                <b>{{$pharmacy->cip}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                {{ __('Telephone') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->phone != '')    
                                <b>{{$pharmacy->phone}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Iban') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->iban != '')    
                                <b>{{$pharmacy->iban}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Sepa signed') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->sepa_signed != '')
                                @if($pharmacy->sepa_signed == '0') 
                                    <b>{{ __('Yes') }}</b>
                                @else
                                    <b>{{ __('No') }}</b>
                                @endif
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                    <div class="col-lg-4">  
                            <div class="text-center">
                                {{ __('Delivery address street') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->delivery_address_street != '')    
                                <b>{{$pharmacy->delivery_address_street}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>     
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Delivery address province') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->delivery_address_province != '')    
                                <b>{{$pharmacy->delivery_address_province}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>   
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Delivery address town') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->delivery_address_town != '')    
                                <b>{{$pharmacy->delivery_address_town}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>      
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Delivery address zipcode') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->delivery_address_zipcode != '')    
                                <b>{{$pharmacy->delivery_address_zipcode}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                        <div class="col-lg-2">  
                            <div class="text-center">
                                {{ __('Sepa expiration') }}
                            </div>
                            <div class="text-center">
                            @if($pharmacy->sepa_expiration != '')    
                                <b>{{$pharmacy->sepa_expiration}}</b>
                            @else
                                --{{ __('Without data') }}--
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('No pharmacy at database') }}</b>
            </div>
        </div>
    @endif
        @if( count($order->orderItems ) ) 
            <div class="card shadow mb-4">
                <div class="card-header">
                    {{ __('Products') }}</b>
                </div>
                <div class="card-body" style="font-size: 14px !important;">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tableResultsItems" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="th-sm">{{ __('Product name') }}</th>
                                    <th class="th-sm">{{ __('Product reference') }}</th>
                                    <th class="th-sm">{{ __('Laboratory') }}</th>
                                    <th class="th-sm">{{ __('Quantity') }}</th>
                                    <th class="th-sm">{{ __('Price') }}</th>
                                    <th class="th-sm">{{ __('Discount') }}</th>
                                    <th class="th-sm">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_reference }}</td>
                                    <td>{{ $item->product_laboratory }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ number_format($item->discount, 2) }}</td>
                                    <td>{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
@php /*
    @isset($order->deliveries)
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Tracking') }}</b>
            </div>
            <div class="card-body">
                @if( count($order->deliveries) )
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tableResultsTracking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="th-sm">{{ __('Tracking status') }}</th>
                                    <th class="th-sm">{{ __('Date') }}</th>
                                    <th class="th-sm">{{ __('Last update') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->deliveries as $track)
                                <tr>
                                    <td>{{$track->status}}</td>
                                    <td>
                                        @if($track->status == 'Preparing')

                                        @elseif($track->status == 'Non deliveried')

                                        @elseif($track->status == 'Cancelled')
                                            
                                        @elseif($track->status == 'Send')
                                            {{ date('d-m-Y', strtotime($track->dateExpedition)) }}
                                        @elseif($track->status == 'Delivered')
                                            {{ date('d-m-Y', strtotime($track->dateLivrasion)) }}
                                        @endif
                                    </td>
                                    <td>{{ date('d-m-Y H:i', strtotime($track->updated_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        <b>{{ __('No deliveries info') }}</b>
                    </div>
                @endif
            </div>
        </div>
    @endisset
*/ @endphp
@unless(auth()->user()->hasAnyRole(['TeleOperator']))
    @hasanyrole('Ticketing|Searcher|SuperAdmin|It')

        <div id="ticketing" class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <a target="_blank" href="/ticketing/new-ticket" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> {{ __('New ticket') }}</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Support') }}</b>
            </div>
            <div class="card-body">
                @if( count($order->tickets) )
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="th-sm">{{ __('Title') }}</th>
                                    <th class="th-sm">{{ __('View ticket') }}</th>
                                    <th class="th-sm">{{ __('Last update') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->tickets as $tick)
                                <tr>
                                    <td>{{$tick->title}}</td>
                                    <td align="center">
                                        <a href="/ticketing/edit-ticket/{{$tick->id}}" ><i class="fas fa-info-circle"></i></a>
                                    </td>
                                    <td>{{ date('d-m-Y H:i', strtotime($tick->updated_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        <b>{{ __('No ticketing info') }}</b>
                    </div>
                @endif
            </div>
        </div>
    @endhasanyrole

    @isset($order->recordings)

        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Recordings') }}</b>
            </div>
            <div class="card-body">
                @if( count($order->recordings) )
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="th-sm">{{ __('File') }}</th>
                                    <th class="th-sm text-center">{{ __('Related') }}</th>
                                    <th class="th-sm text-center">{{ __('Download recording') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->recordings as $record)
                                <tr>
                                    <td>{{$record->fileName}}</td>
                                    <td> 
                                        <input style="height: 30px;" order_id="{{$order->id}}" record_id="{{$record->id}}" class="form-control form-control-user" type="checkbox" name="selected_{{$record->id}}" id="selected_file_{{$record->id}}" @if($record->selected == '1') checked @endif>
                                    </td>
                                    <td align="center">
                                    <a href="{{route('download.recording', $record->id)}}" data-report_id="{{$record->id}}" ><i class="fas fa-download"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        <b>{{ __('No recording info') }}</b>
                    </div>
                @endif
            </div>
        </div>

    @endisset
@endunless
    <script type="text/javascript">
        $(document).ready(function () {
            //$('#tableResultsItems').DataTable( {
            //    "pageLength": 5,
            //    order: [[0, 'asc']],
            //});

            //$('#tableResultsTracking').DataTable( {
            //    "pageLength": 5,
            //    order: [[1, 'desc']],
            //});
            
            //$('#tableResultsTicketing').DataTable( {
            //    "pageLength": 5,
            //    order: [[0, 'asc']],
            //});

        });
    </script>

@endsection
