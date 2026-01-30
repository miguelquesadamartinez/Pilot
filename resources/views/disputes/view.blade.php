@extends("layouts.app")

@section('content')
    @if(isset($success))
        <div id="success_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'ticked_order_item')
                                    {{ __('Ticked order´s product tick changed successfully') }}
                                @elseif($success == 'status_order')
                                    {{ __('Order status changed successfully') }}
                                @elseif ($success == 'dispute_order_validated')
                                    {{ __('Order dispute validated') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    @if($order_dispute != null)
        <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Order') }}: {{$orderNum}}
            </div>
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-bordered" name="tableResults" id="tableResults" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-sm">{{ __('Product name') }}</th>
                                <th class="th-sm">{{ __('Quantity') }}</th>
                                <th class="th-sm">{{ __('Price') }}</th>
                                <th class="th-sm">{{ __('Discount') }}</th>
                                <th class="th-sm">{{ __('Total') }}</th>
                                <th class="th-sm">{{ __('Ticked') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order_dispute as $item)
                            <tr>
                                <td>{{$item->orderItemProductName}}</td>
                                <td>{{$item->orderItemQtn}}</td>
                                <td>{{number_format($item->orderItemPrice, 2)}}</td>
                                <td>{{number_format($item->orderItemDiscount, 2)}}</td>
                                <td>{{number_format($item->orderItemTotal, 2)}}</td>
                                <td align="center">
                                    <input @if($order_dispute[0]->validated == '1') disabled @endif style="height: 30px;" item_id="{{$item->id}}" class="form-control form-control-user" type="checkbox" name="selected_{{$item->id}}" id="selected_tick_{{$item->id}}" @if($item->ticked == '1') checked @endif>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($order_dispute[0]->validated == '0')      
            <div class="text-center" style="margin-bottom: 20px;">
                <a name="validateOrderDispute_{{$orderNum}}" order="{{$orderNum}}" class="collapse-item" href="/search-order-dispute/validate/{{$orderNum}}">
                    {{ __('Validate dispute') }}
                </a>
            </div>
            <div class="text-center" style="margin-top: 20px;">
                {{ __('Open') }}
            </div>
            <div class="text-center">
                <input style="height: 30px;" orderNum="{{$item->orderNum}}" status="{{$status}}" class="form-control form-control-user" type="checkbox" name="selected_{{$item->orderNum}}" id="selected_dispute_{{$item->orderNum}}" @if($order_dispute[0]->open == 1) checked @endif>
            </div>
        @else
            <div class="text-center" style="margin-top: 20px;">
                {{ __('Dispute already validated') }}
            </div>
            {{--
            <div class="text-center" style="margin-top: 20px;">
                {{ __('Open') }}
            </div>
            <div class="text-center">
                <input style="height: 30px;" orderNum="{{$item->orderNum}}" status="{{$status}}" class="form-control form-control-user" type="checkbox" name="selected_{{$item->orderNum}}" id="selected_dispute_{{$item->orderNum}}" @if($order_dispute[0]->open == 1) checked @endif>
            </div>
            --}}
        @endif
        <div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
            <a class="collapse-item" href="/search-order-dispute/qrcode/{{$orderNum}}">{{ __('Generate order QRcode') }}</a>
        </div>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {
            $('#tableResults_no_usado').DataTable( {
                "pageLength": 10,
                order: [[1, 'desc']],
                    language: {
                        "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
                    }
            });
            if ($("#success_div").length > 0) {
                setTimeout(function() {
                    $("#success_div").slideUp(1500);
                }, 2500);
            }
        });
    </script>

@endsection
