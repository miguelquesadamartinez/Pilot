
@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$locale}} - {{ __('Tickets After Sales') }}</h1>
        <a href="/ticketing/new-ticket" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> {{ __('New ticket') }}
        </a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">

            @isset($tickets)

            <div style="font-size: 12px;" class="table-responsive">

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
                                @if($locale == 'en')
                                    {{$ticket->ticketCategory->category_en}}
                                @elseif($locale == 'es')
                                    {{$ticket->ticketCategory->category_es}}
                                @elseif($locale == 'fr')
                                    {{$ticket->ticketCategory->category_fr}}
                                @endif
                            </td>
                            <td>
                                @if($ticket->status_id == 0)
                                    {{ __('Closed') }}
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

            @else
                <div class="text-center">
                    <b>No Ticketing info</b>
                </div>
                
            @endisset

        </div>
    </div>


<script type="text/javascript">

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#tableResultsTickets').DataTable( {
        "pageLength": 25,
        order: [[0, 'desc']],
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
    });

    if ($("#error_div").length > 0) {
        setTimeout(function() {
            $("#error_div").slideUp(1500);
        }, 2500);
    }
});

</script>

@endsection
