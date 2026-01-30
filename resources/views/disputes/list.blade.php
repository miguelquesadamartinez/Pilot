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

    @include('disputes.searchformlist')

    @if($order_disputes != null)
        <div class="card shadow mb-4">
            <div class="card-header">
                @if($status == 'open')
                    {{ __('Open order disputes') }}
                @else
                    {{ __('Closed order disputes') }}
                @endif
            </div>
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-bordered" name="tableResults" id="tableResults" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-sm">{{ __('Order Reference') }}</th>
                                <th class="th-sm">{{ __('CIP') }}</th>
                                <th class="th-sm">{{ __('Pharmacy name') }}</th>
                                <th class="th-sm">{{ __('Validated') }}</th>
                                <th class="th-sm">{{ __('View dispute') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order_disputes as $item)
                            <tr>
                                <td>{{$item->orderNum}}</td>
                                <td>{{$item->CIP}}</td>
                                <td>{{$item->pharmacyName}}</td>
                                <td align="center">
                                    <input @if($item->validated == '1') checked @endif disabled style="height: 30px;" class="form-control form-control-user" type="checkbox">
                                </td>
                                <td align="center">
                                    <a href="/search-order-dispute/view/{{$item->orderNum}}"><i class="fas fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="d-flex justify-content-center">
                    {{ $order_disputes->links() }}
                </div>

            </div>
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
            });
    </script>

@endsection
