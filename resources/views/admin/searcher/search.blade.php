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
    @include('admin.searcher.searchform')
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

    @endif

    @if(isset($orders) && $orders != null)
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Orders') }}
            </div>
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-bordered" name="tableResults" id="tableResults" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-sm">{{ __('Order Reference') }}</th>
                                <th class="th-sm">{{ __('Order Date') }}</th>
                                <th class="th-sm">{{ __('Pharmacy name') }}</th>
                                <th class="th-sm">{{ __('Laboratory') }}</th>
                                <th class="th-sm">{{ __('View order') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->OrderNum}}</td>
                                <td>{{$order->orderDate}}</td>
                                <td>{{$order->pharmacyName}}</td>
                                <td>{{$order->laboratoryName($order->id)}}</td>
                                <td align="center">
                                    <a href="/order/view-order/{{$order->id}}" ><i class="fas fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    @endif

    @if($tickets != null)
    <div class="card shadow mb-4">
    <div class="card-header">
                {{ __('Tickets') }}
            </div>
        <div class="card-body">



            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsTickets" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Title') }}</th>
                            <th class="th-sm">{{ __('Order Number') }}</th>
                            <th class="th-sm">{{ __('Category') }}</th>
                            <th class="th-sm">{{ __('Status') }}</th>
                            <th class="th-sm">{{ __('Edit ticket') }}</th>
                            <th class="th-sm">{{ __('View order') }}</th>
                            <th class="th-sm">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{$ticket->title}}</td>
                            <td>{{$ticket->order_number}}</td>
                            <td>
                                @if($ticket->categories_id == 1000)
                                    {{ __('No category') }}
                                @elseif($ticket->categories_id == 1001)
                                    {{ __('Commercial problem') }}
                                @elseif($ticket->categories_id == 1002)
                                    {{ __('Logistics problem') }}
                                @elseif($ticket->categories_id == 1003)
                                    {{ __('Sales problem Theramex') }}
                                @elseif($ticket->categories_id == 1004)
                                    {{ __('Logistics problem Theramex') }}
                                @elseif($ticket->categories_id == 1005)
                                    {{ __('Sales problem AGINAX') }}
                                @elseif($ticket->categories_id == 1006)
                                    {{ __('Logistics problem AGINAX') }}
                                @elseif($ticket->categories_id == 1007)
                                    {{ __('Sales problem BNSANTE_GC') }}
                                @elseif($ticket->categories_id == 1008)
                                    {{ __('Logistics problem BNSANTE_GC') }}
                                @elseif($ticket->categories_id == 1009)
                                    {{ __('Sales problem LIFESTYLES') }}
                                @elseif($ticket->categories_id == 1010)
                                    {{ __('Logistics problem LIFESTYLES') }}
                                @elseif($ticket->categories_id == 1011)
                                    {{ __('Sales problem HAVEA_FR') }}
                                @elseif($ticket->categories_id == 1012)
                                    {{ __('Logistics problem HAVEA_FR') }}
                                @else
                                    @if($locale == 'en')
                                        {{$ticket->ticketCategory->category_en}}
                                    @elseif($locale == 'es')
                                        {{$ticket->ticketCategory->category_es}}
                                    @elseif($locale == 'fr')
                                        {{$ticket->ticketCategory->category_fr}}
                                    @endif
                                @endif
                            </td>
                            
                            <td>
                                @if($ticket->status_id == 0)
                                    {{ __('Closed') }}
                                @elseif($ticket->status_id == 1000)
                                    {{ __('Open') }}
                                @else
                                    @if($locale == 'en')
                                        {{$ticket->ticketStatus->status_en}}
                                    @elseif($locale == 'es')
                                        {{$ticket->ticketStatus->status_es}}
                                    @elseif($locale == 'fr')
                                        {{$ticket->ticketStatus->status_fr}}
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                <a href="/ticketing/edit-ticket/{{$ticket->id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td align="center">
                                <a href="/order/view-order/{{$ticket->orders_id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td align="center">   
                                {{ Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    @endif

    @isset($noResults)
    <div class="text-center">
        <h1>{{ __('No results found ...') }}</h1>
    </div>
    @endisset

    <script type="text/javascript">
        $(document).ready(function () {
            $('#tableResults').DataTable( {
                "pageLength": 10,
                order: [[1, 'desc']],
                    language: {
                        "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
                    }
                });
            });
    </script>

@endsection
