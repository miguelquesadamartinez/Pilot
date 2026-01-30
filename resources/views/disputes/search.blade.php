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

    @include('disputes.searchform')

    @if($order != null)
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
                                @if($already_done == true)
                                    <th class="th-sm">{{ __('Ticked') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{$item->product_name}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->discount}}</td>
                                <td>{{$item->total}}</td>
                                @if($already_done == true)
                                    <td align="center">
<input style="height: 30px;" item_id="{{$item->id}}" class="form-control form-control-user" type="checkbox" name="selected_{{$item->id}}" id="selected_tick_{{$item->id}}" @if($item->ticked == '1') checked @endif>
                                    </td>
                                @endif
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
    @else
        @if($order != null)
            @if($already_done == false)
                <div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
                    <a class="collapse-item" href="/search-order-dispute/save-dispute/{{$order->id}}">{{ __('Create dispute') }}</a>
                </div>
            @else
                <div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
                    {{ __('Dispute already created') }}
                </div>
                <div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
                    <a class="collapse-item" href="/search-order-dispute/view/{{$orderNum}}">{{ __('View dispute') }}</a>
                </div>
                <div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
                    <a class="collapse-item" href="/search-order-dispute/qrcode/{{$orderNum}}">{{ __('Generate order QRcode') }}</a>
                </div>
            @endif
        @endif
    @endisset

    <script type="text/javascript">
        $(document).ready(function () {
            $('#tableResults_no_usado').DataTable( {
                "pageLength": 10,
                order: [[1, 'desc']],
                    language: {
                        "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
                    }
                });
            });
    </script>

@endsection
