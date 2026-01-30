
@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Tickets') }}</h1>
        <a href="/ticketing/new-ticket" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> {{ __('New ticket') }}
        </a>
    </div>

    <div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Search') }}
            </div>
            <div class="card-body">
                <form method="POST" action="/ticketing/search-admin-ticket" enctype="multipart/form-data">
                    @csrf
                         
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="department">{{ __('Department') }}</label>
                                <select name="department" id="department" class="form-control form-control-user @error('department') is-invalid @enderror">
                                <option @if($dept_var == "") selected @endif value="">{{ __('Select department') }}</option>

                                <option @if($dept_var == "AfterSales") selected @endif value="AfterSales">{{ __('After sales') }}</option>
                                <option @if($dept_var == "Logistics") selected @endif value="Logistics">{{ __('Logistics') }}</option>
                                <option @if($dept_var == "Production") selected @endif value="Production">{{ __('Production') }}</option>
                                <option @if($dept_var == "Legal") selected @endif value="Legal">{{ __('Legal') }}</option>
                                <option @if($dept_var == "TI") selected @endif value="TI">{{ __('IT Service') }}</option>
                                <option @if($dept_var == "Accounting") selected @endif value="Accounting">{{ __('Accounting') }}</option>
                                    
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label for="ticket_type">{{ __('Category') }}</label>
                                <select name="ticket_type" id="ticket_type" class="form-control form-control-user @error('ticket_type') is-invalid @enderror">
                                    <option selected="true" value="">{{ __('Select category') }}</option>
                                    <option @if(isset($ticket_type) && $ticket_type == '1') selected @endif value="1">{{ __('Order') }}</option>
                                    <option @if(isset($ticket_type) && $ticket_type == '2') selected @endif value="2">{{ __('Billing') }}</option>
                                    <option @if(isset($ticket_type) && $ticket_type == '3') selected @endif value="3">{{ __('Clubbiogyne') }}</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label for="category">{{ __('Status') }}</label>
                                <select name="category" id="category" class="form-control form-control-user @error('category') is-invalid @enderror">
                                <option selected="true" value="">{{ __('Select category') }}</option>
                                @foreach($categories_glb as $cat)
                                <option @isset($category) @if($category == $cat->id) selected @endif @endisset value="{{$cat->id}}">
                                    @if($locale == 'en')
                                        {{$cat->category_en}}
                                    @elseif($locale == 'es')
                                        {{$cat->category_es}}
                                    @elseif($locale == 'fr')
                                        {{$cat->category_fr}}
                                    @endif
                                    </option>
                                @endforeach
                                
                                <option @isset($category) @if($category == "9999") selected @endif @endisset value="9999">{{ __('Other Laboratories') }}</option>

                                <option @isset($category) @if($category == "1001") selected @endif @endisset value="1001">{{ __('Commercial problem Adare') }}</option>
                                <option @isset($category) @if($category == "1002") selected @endif @endisset value="1002">{{ __('Logistics problem Adare') }}</option>
                                <option @isset($category) @if($category == "1003") selected @endif @endisset value="1003">{{ __('Sales problem Theramex') }}</option>
                                <option @isset($category) @if($category == "1004") selected @endif @endisset value="1004">{{ __('Logistics problem Theramex') }}</option>
                                <option @isset($category) @if($category == "1005") selected @endif @endisset value="1005">{{ __('Sales problem AGINAX') }}</option>
                                <option @isset($category) @if($category == "1006") selected @endif @endisset value="1006">{{ __('Logistics problem AGINAX') }}</option>
                                <option @isset($category) @if($category == "1007") selected @endif @endisset value="1007">{{ __('Sales problem BNSANTE_GC') }}</option>
                                <option @isset($category) @if($category == "1008") selected @endif @endisset value="1008">{{ __('Logistics problem BNSANTE_GC') }}</option>
                                <option @isset($category) @if($category == "1009") selected @endif @endisset value="1009">{{ __('Sales problem LIFESTYLES') }}</option>
                                <option @isset($category) @if($category == "1010") selected @endif @endisset value="1010">{{ __('Logistics problem LIFESTYLES') }}</option>
                                <option @isset($category) @if($category == "1011") selected @endif @endisset value="1011">{{ __('Sales problem HAVEA_FR') }}</option>
                                <option @isset($category) @if($category == "1012") selected @endif @endisset value="1012">{{ __('Logistics problem HAVEA_FR') }}</option>
                                
                                </select>
                            </div>
                            {{--
                            <div class="col-lg-3">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control form-control-user @error('status') is-invalid @enderror">

                                    <option selected="true" value="">{{ __('Select status') }}</option>

                                    @if(isset($status_category) && ! empty($status_category))
                                        @foreach($status_category as $st)
                                            <option @isset($status_var) @if($status_var == $st->id) selected @endif @endisset value="{{$st->id}}">
                                            @if($locale == 'en')
                                                {{$st->status_en}}
                                            @elseif($locale == 'es')
                                                {{$st->status_es}}
                                            @elseif($locale == 'fr')
                                                {{$st->status_fr}}
                                            @endif
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach($status_glb as $st)
                                            <option @isset($status_var) @if($status_var == $st->id) selected @endif @endisset value="{{$st->id}}">
                                            @if($locale == 'en')
                                                {{$st->status_en}}
                                            @elseif($locale == 'es')
                                                {{$st->status_es}}
                                            @elseif($locale == 'fr')
                                                {{$st->status_fr}}
                                            @endif
                                            </option>
                                        @endforeach
                                    @endisset

                                    <option @if($status_var == "1000") selected @endif value="1000">{{ __('Open') }}</option>
                                    <option @if($status_var == "0") selected @endif value="0">{{ __('Closed') }}</option>
                                </select>
                            </div>
                            --}}
                            <div class="col-lg-3">
                                <div class="text-center">
                                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">

            @isset( $tickets )

            <div style="font-size: 12px;" class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsTickets" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Title') }}</th>
                            <th class="th-sm">{{ __('Order Number') }}</th>
                            <th class="th-sm">{{ __('Category') }}</th>
                            <th class="th-sm">{{ __('Status') }}</th>
                            <th class="th-sm">{{ __('Department') }}</th>
                            <th class="th-sm">{{ __('Edit ticket') }}</th>
                            <th class="th-sm">{{ __('View order') }}</th>
                            <th class="th-sm">{{ __('On time') }}</th>
                            <th class="th-sm">{{ __('Days') }}</th>
                            <th class="th-sm">{{ __('Opening Date') }}</th>
                            <th class="th-sm">{{ __('Closing Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{$ticket->title}}</td>
                            <td>{{$ticket->order_number}}</td>
                            <td>
                                @if($ticket->ticket_type == '1')
                                    {{ __('Order') }}
                                @elseif($ticket->ticket_type == '2')
                                    {{ __('Billing') }}
                                @elseif ($ticket->ticket_type == '3')
                                    {{ __('Clubbiogyne') }}
                                @endif
                            </td>
                            <td>
                            @if($ticket->categories_id == 1000)
                                {{ __('No category') }}
                            @elseif($ticket->categories_id == 1001)
                                {{ __('Commercial problem') }}
                            @elseif($ticket->categories_id == 1002)
                                {{ __('Logistics problem') }}
                            @elseif($ticket->categories_id == 1003 || $ticket->categories_id == 1005 || $ticket->categories_id == 1007 || $ticket->categories_id == 1009 || $ticket->categories_id == 1011 )
                                {{ __('Sales problem') }}
                            @elseif($ticket->categories_id == 1004 || $ticket->categories_id == 1006 || $ticket->categories_id == 1008 || $ticket->categories_id == 1010 || $ticket->categories_id == 1012 )
                                {{ __('Logistics problem') }}
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
                            {{--
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
                            --}}
                            <td>

                                @if($ticket->department == "AfterSales")
                                    {{ __('After sales') }}
                                @elseif ($ticket->department == "Logistics")
                                    {{ __('Logistics') }}
                                @elseif ($ticket->department == "Production")
                                    {{ __('Production') }}
                                @elseif ($ticket->department == "Legal")
                                    {{ __('Legal') }}
                                @elseif ($ticket->department == "TI")
                                    {{ __('TI') }}
                                @else
                                    {{ $ticket->department }}
                                @endif

                            </td>
                            <td align="center">
                                <a href="/ticketing/edit-ticket/{{$ticket->id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td align="center">
                                <a href="/order/view-order/{{$ticket->orders_id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td align="center">
                                @if( $ticket->date_diff >= $days_sla )
                                    <i style="color:red;" class="fas fa-info-circle"><span style="color: transparent;">1</span></i>
                                @else
                                    <i style="color:green;" class="fas fa-info-circle"><span style="color: transparent;">0</span></i>
                                @endif
                            </td>
                            <td align="center">
                                {{ $ticket->date_diff }}
                            </td>
                            <td align="center">
                                {{ Carbon\Carbon::parse($ticket->ticket_creation_date)->format('d-m-Y') }} 
                                {{ Carbon\Carbon::parse($ticket->ticket_creation_time)->format('H:i') }}
                            </td>
                            <td align="center">
                                @if($ticket->closingDate != "")   
                                    {{ Carbon\Carbon::parse($ticket->closingDate)->format('m-d H:i') }}
                                @else
                                    @php /* {{$ticket->date_temp}} */ @endphp
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            @php /*
            <div class="d-flex justify-content-center">
                {{ $tickets->links() }}
            </div>
            */ @endphp

            @else
                <div class="text-center">
                    <b>No Status info</b>
                </div>
                
            @endisset

        </div>
    </div>

<script type="text/javascript">

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var select = document.getElementById("ticket_type");

    select.addEventListener("change", function(){
        var selectedOptions = this.selectedOptions;

            $.ajax({
            url:"/get-category-for-type",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                type_id: this.value
            },
            success: function( data ) {

                $('#category option:not(:first)').remove();

                data.forEach( function(id) {
                    $('#category').append($('<option>', {
                        value: id.id,
                        text: id.category
                    }));
                });
            },
            error: function( data ) {
                console.log(data);
            }
        });
    });

    @if(isset($ticket_type) && $ticket_type != '' )
        $.ajax({
            url:"/get-category-for-type",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                type_id: {{ $ticket_type }}
            },
            success: function( data ) {
                $('#category option:not(:first)').remove();
                data.forEach( function(id) {
                    $('#category').append($('<option>', {
                        value: id.id,
                        text: id.category
                    }));
                });
                @if(isset($category) && $category != '' )
                    $('#category').val({{$category}});
                @endif

            },
            error: function( data ) {
                console.log(data);
            }
        });
    @endif
    

    var select = document.getElementById("category");

    select.addEventListener("change", function(){
        var selectedOptions = this.selectedOptions;
        console.log(this.value);
        if (this.value == "1001" || this.value == "1002" || this.value == "1003" || this.value == "1004" || this.value == "1005" || this.value == "1006" || 
        this.value == "1007" || this.value == "1008" || this.value == "1009" || this.value == "1010" || this.value == "1011" || this.value == "1012" ||
        this.value == "9999" ){
            $('#status option:not(:first)').remove();
            $('#status').append($('<option>', {
                value: 1000,
                text: "{{ __('Open') }}"
            }));
            $('#status').append($('<option>', {
                value: 0,
                text: "{{ __('Closed') }}"
            }));
        } else {
            $.ajax({
                url:"/get-status-for-category",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    category_id: this.value
                },
                success: function( data ) {
                    $('#status option:not(:first)').remove();
                    data.forEach( function(id) {
                        $('#status').append($('<option>', {
                            value: id.id,
                            text: id.status
                        }));
                    });
                    $('#status').append($('<option>', {
                        value: 0,
                        text: "{{ __('Closed') }}"
                    }));
                },
                error: function( data ) {
                    console.log(data);
                }
            });
        }
    });
    
    $('#tableResultsTickets').DataTable( {
        "pageLength": 25,
        order: [[8, 'desc']],
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
