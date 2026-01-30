
@extends("layouts.app")

@section('content')

<div class="container" style="max-width: 700px !important;">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @isset($success)
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'ticket created')
                                    {{ __('Ticket created successfully') }}
                                @elseif($success == 'new cat')
                                    {{ __('Category created successfully') }}
                                @elseif($success == 'ticket edited')
                                    {{ __('Ticket edited successfully') }}
                                @elseif($success == 'ticket file deleted')
                                    {{ __('Ticket file deleted successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row text-center">

                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            @isset($ticket->id)
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit ticket') }} - {{ $laboratory }} - {{$ticket->department}}</h1>
                            @else
                                <h1 class="h4 text-gray-900 mb-4">{{ __('New ticket') }} - {{ $laboratory }}</h1>
                            @endif
                        </div>
                        <div class="text-center">

                        @isset($ticket->id)
                            <form method="POST" action="/ticketing/update-ticket" enctype="multipart/form-data">

                            <input type="hidden" id="ticket_id" name="ticket_id" value="{{$ticket->id}}">
                        @else
                            <form method="POST" action="/ticketing/create-ticket" enctype="multipart/form-data">
                        @endif

                        <input type="hidden" id="laboratory" name="laboratory" value="{{$laboratory}}">

                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="title">{{ __('Title') }}</label>
                                    @isset($ticket->title)
                                        <input value="{{ old('title', $ticket->title) }}" type="text" class="form-control form-control-user @error('title') is-invalid @enderror" id="title" name="title">
                                    @else
                                        <input value="{{ old('title') }}" type="text" class="form-control form-control-user @error('title') is-invalid @enderror" id="title" name="title">
                                    @endif
                                </div>
                            </div>
                            
                            <input type="hidden" id="order_id" name="order_id" @isset($order->id) value="{{$order->id}}" @endisset>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="order">{{ __('Order Number') }}</label>

<!-- ToDo: What todo with the relation between ticket and order/cip -->

@isset($order->OrderNum)
<input readonly value="{{ $order->OrderNum }}" type="text" class="form-control form-control-user @error('order') is-invalid @enderror" id="order" name="order">
@else
<input value="{{ old('order' ) }}" type="text" class="form-control form-control-user @error('order') is-invalid @enderror" id="order" name="order">
@endisset
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="cip">{{ __('CIP') }}</label>

@isset($order->CIP)
<input readonly value="{{ $order->CIP }}" type="text" class="form-control form-control-user @error('cip') is-invalid @enderror" id="cip" name="cip">
@else
<input value="{{ old('cip') }}" type="text" class="form-control form-control-user @error('cip') is-invalid @enderror" id="cip" name="cip">
@endisset
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="category">{{ __('Description') }}</label>
                                    @isset($ticket->description)
                                        <textarea id="description" name="description" rows="10" cols="50" class="form-control form-control-user"> {{ $ticket->description }}</textarea>
                                    @else
                                        <textarea id="description" name="description" rows="10" cols="50" class="form-control form-control-user"> {{ old('description') }}</textarea>
                                    @endif
                                </div>
                            </div>

                            @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')
                                <div class="form-group row" id="select_ticket_type">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="ticket_type">{{ __('Category') }}</label>
                                        <select name="ticket_type" id="ticket_type" class="form-control form-control-user @error('ticket_type') is-invalid @enderror">
                                            <option selected="true" value="">{{ __('Select category') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '1') selected @endif value="1">{{ __('Order') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '2') selected @endif value="2">{{ __('Logistics') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '3') selected @endif value="3">{{ __('Invoicing') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '4') selected @endif value="4">{{ __('Clubbiogyne') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '5') selected @endif value="5">{{ __('Expired product') }}</option>
                                            <option @if(isset($ticket) && $ticket->ticket_type == '6') selected @endif value="6">{{ __('Other service') }}</option>
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row" id="select_category">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="category">{{ __('Status') }}</label>
                                    <select name="category" id="category" class="form-control form-control-user @error('category') is-invalid @enderror">
                                        <option value="">{{ __('Select status') }}</option>
                                        @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')
                                            @if(isset($categories_type))
                                                @foreach($categories_type as $cat)
                                                    <option @if(@old('category', $ticket->categories_id) == $cat->id) selected @endif  value="{{$cat->id}}">
                                                    @if($locale == 'en')
                                                        {{$cat->category_en}}
                                                    @elseif($locale == 'es')
                                                        {{$cat->category_es}}
                                                    @elseif($locale == 'fr')
                                                        {{$cat->category_fr}}
                                                    @endif
                                                    </option>
                                                @endforeach
                                            @else
                                            {{--
                                                @foreach($categories_glb as $cat)
                                                    <option @if(@old('category', $ticket->categories_id) == $cat->id) selected @endif  value="{{$cat->id}}">
                                                    @if($locale == 'en')
                                                        {{$cat->category_en}}
                                                    @elseif($locale == 'es')
                                                        {{$cat->category_es}}
                                                    @elseif($locale == 'fr')
                                                        {{$cat->category_fr}}
                                                    @endif
                                                    </option>
                                                @endforeach
                                            --}}
                                            @endif
                                        @elseif($laboratory == 'ADARE' || $laboratory == 'DSM')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1001') selected @endif value="1001">{{ __('Commercial problem Adare') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1002') selected @endif value="1002">{{ __('Logistics problem Adare') }}</option>
                                        @elseif($laboratory == 'THERAMEX1' || $laboratory == 'THERAMEX')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1003') selected @endif value="1003">{{ __('Sales problem Theramex') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1004') selected @endif value="1004">{{ __('Logistics problem Theramex') }}</option>
                                        @elseif($laboratory == 'AGINAX')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1005') selected @endif value="1005">{{ __('Sales problem AGINAX') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1006') selected @endif value="1006">{{ __('Logistics problem AGINAX') }}</option>
                                        @elseif($laboratory == 'BNSANTE_GC')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1007') selected @endif value="1007">{{ __('Sales problem BNSANTE_GC') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1008') selected @endif value="1008">{{ __('Logistics problem BNSANTE_GC') }}</option>
                                        @elseif($laboratory == 'LIFESTYLES')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1009') selected @endif value="1009">{{ __('Sales problem LIFESTYLES') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1010') selected @endif value="1010">{{ __('Logistics problem LIFESTYLES') }}</option>
                                        @elseif($laboratory == 'HAVEA_FR')
                                            <option @if(isset($ticket) && $ticket->categories_id == '1011') selected @endif value="1011">{{ __('Sales problem HAVEA_FR') }}</option>
                                            <option @if(isset($ticket) && $ticket->categories_id == '1012') selected @endif value="1012">{{ __('Logistics problem HAVEA_FR') }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_status">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="status">{{ __('Level') }} 0</label>
                                    <select name="status" id="status" class="form-control form-control-user @error('status') is-invalid @enderror">
                                        <option value="">{{ __('Select Level') }} 0</option>
                                            @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')
                                                @isset($ticket->id)
                                                    @foreach($status as $st)
                                                        <option @if(@old('status', $ticket->status_id) == $st->id) selected @endif value="{{$st->id}}">
                                                            @if($locale == 'en')
                                                                {{$st->status_en}}
                                                            @elseif($locale == 'es')
                                                                {{$st->status_es}}
                                                            @elseif($locale == 'fr')
                                                                {{$st->status_fr}}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                @endif
                                                @if(isset($canCloseTheTicket))
                                                    <option @if( isset( $ticket->status_id ) && $ticket->status_id == "0") selected @endif value="0">{{ __('Closed') }}</option>
                                                @endif
                                            @else
                                                <option @if( isset( $ticket ) && $ticket->status_id == "1000") selected @endif value="1000">{{ __('Open') }}</option>
                                                <option @if( isset( $ticket ) && $ticket->status_id == "0") selected @endif value="0">{{ __('Closed') }}</option>
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_level_a">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label id="label_level_a" for="status">{{ __('Level') }} 1</label>
                                    <select name="level_a" id="level_a" class="form-control form-control-user @error('level_a') is-invalid @enderror">
                                        <option selected="true" value="">{{ __('Select Level') }} 1</option>
                                            @if(isset($ticket->level_a_id) && $ticket->level_a_id != "")
                                                @foreach($db_level_a as $st)
                                                    <option @if($ticket->level_a_id == $st->id) selected @endif value="{{$st->id}}">
                                                        @if($locale == 'en')
                                                            {{$st->level_a_en}}
                                                        @elseif($locale == 'es')
                                                            {{$st->level_a_es}}
                                                        @elseif($locale == 'fr')
                                                            {{$st->level_a_fr}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_level_b">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label id="label_level_b" for="status">{{ __('Level') }} 2</label>
                                    <select name="level_b" id="level_b" class="form-control form-control-user @error('level_b') is-invalid @enderror">
                                        <option selected="true" value="">{{ __('Select Level') }} 2</option>
                                            @if(isset($ticket->level_b_id) && $ticket->level_b_id != "")
                                                @foreach($db_level_b as $st)
                                                    <option @if($ticket->level_b_id == $st->id) selected @endif value="{{$st->id}}">
                                                        @if($locale == 'en')
                                                            {{$st->level_b_en}}
                                                        @elseif($locale == 'es')
                                                            {{$st->level_b_es}}
                                                        @elseif($locale == 'fr')
                                                            {{$st->level_b_fr}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_level_c">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label id="label_level_c" for="status">{{ __('Level') }} 3</label>
                                    <select name="level_c" id="level_c" class="form-control form-control-user @error('level_c') is-invalid @enderror">
                                        <option selected="true" value="">{{ __('Select Level') }} 3</option>
                                            @if(isset($ticket->level_c_id) && $ticket->level_c_id != "")
                                                @foreach($db_level_c as $st)
                                                    <option @if($ticket->level_c_id == $st->id) selected @endif value="{{$st->id}}">
                                                        @if($locale == 'en')
                                                            {{$st->level_c_en}}
                                                        @elseif($locale == 'es')
                                                            {{$st->level_c_es}}
                                                        @elseif($locale == 'fr')
                                                            {{$st->level_c_fr}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_level_d">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label id="label_level_d" for="status">{{ __('Level') }} 4</label>
                                    <select name="level_d" id="level_d" class="form-control form-control-user @error('level_d') is-invalid @enderror">
                                        <option selected="true" value="">{{ __('Select Level') }} 4</option>
                                            @if(isset($ticket->level_d_id) && $ticket->level_d_id != "")
                                                @foreach($db_level_d as $st)
                                                    <option @if($ticket->level_d_id == $st->id) selected @endif value="{{$st->id}}">
                                                        @if($locale == 'en')
                                                            {{$st->level_d_en}}
                                                        @elseif($locale == 'es')
                                                            {{$st->level_d_es}}
                                                        @elseif($locale == 'fr')
                                                            {{$st->level_d_fr}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="select_level_e">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label id="label_level_e" for="status">{{ __('Level') }} 5</label>
                                    <select name="level_e" id="level_e" class="form-control form-control-user @error('level_e') is-invalid @enderror">
                                        <option selected="true" value="">{{ __('Select Level') }} 5</option>
                                            @if(isset($ticket->level_e_id) && $ticket->level_e_id != "")
                                                @foreach($db_level_e as $st)
                                                    <option @if($ticket->level_e_id == $st->id) selected @endif value="{{$st->id}}">
                                                        @if($locale == 'en')
                                                            {{$st->level_e_en}}
                                                        @elseif($locale == 'es')
                                                            {{$st->level_e_es}}
                                                        @elseif($locale == 'fr')
                                                            {{$st->level_e_fr}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="file">{{ __('Add File') }}</label>
                                    <input name="ticket_file" id="ticket_file" type="file" class="form-control form-control-user" >
                                </div>
                            </div>

                            @if( isset($ticket->ticketFiles) && count($ticket->ticketFiles) > 0 )
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">{{ __('File name') }}</th>
                                            <th class="th-sm">{{ __('Delete file') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ticket->ticketFiles as $file)
                                        <tr>
                                            <td>
                                            <a href="{{route('download.ticket', $file->id)}}" data-report_id="{{$file->id}}" >{{$file->name}}</a>
                                            </td>
                                            <td align="center">
                                                <a file="{{$file->name}}"  name="linkDeleteTicketFile" href="/ticketing/delete-file/{{$file->id}}" ><i class="fas fa-info-circle" style="color:red;"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            @endisset

                            <div class="text-center" style="margin-bottom: 15px;">
                                @if($locale == 'en')
                                    <img src="{{ asset('/img/en.png') }}" width="32">
                                @elseif($locale == 'es')
                                    <img src="{{ asset('/img/es.png') }}" width="32">
                                @elseif($locale == 'fr')
                                    <img src="{{ asset('/img/fr.png') }}" width="32">
                                @endif
                            </div>

                            @isset($ticket->id)
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            @endif

                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   <!-- Script -->
<script type="text/javascript">

$(document).ready(function(){ 

    const input = document.getElementById('ticket_file');
    if(input) {
        input.addEventListener('change', (event) => {
        const target = event.target
            if (target.files && target.files[0]) {
                const maxAllowedSize = 2 * 1024 * 1024; // 2MB
                if (target.files[0].size > maxAllowedSize) {
                    alert("{{ __('Max size allowed') }}.");
                    target.value = ''
                }
            }
        })
    }

    @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')
        @if(isset($ticket->status_id) && 
            ( $ticket->status_id == "2" || 
              $ticket->status_id == "5" ||
              $ticket->status_id == "6" ||
              $ticket->status_id == "11" ||
              $ticket->status_id == "15" ||
              $ticket->status_id == "16" ||
              $ticket->status_id == "17" ||
              $ticket->status_id == "19" ||
              $ticket->status_id == "20" ||
              $ticket->status_id == "21" ||
              $ticket->status_id == "25"
            )
        )
            $('#select_level_a').show();

            @if(isset($ticket->level_a_id))
                @if($ticket->level_a_id == 1 || $ticket->level_a_id == 2 || $ticket->level_a_id == 3 || $ticket->level_a_id == 4 )
                    $('#select_level_b').show();
                    $('#select_level_c').show();
                    $('#select_level_d').show();
                    $('#select_level_e').show();
                @else
                    $('#select_level_b').hide();
                    $('#select_level_c').hide();
                    $('#select_level_d').hide();
                    $('#select_level_e').hide();
                @endif
            @endif
        @else
            //$('#select_category').hide();
            //$('#select_status').hide();
            $('#select_level_a').hide();
            $('#select_level_b').hide();
            $('#select_level_c').hide();
            $('#select_level_d').hide();
            $('#select_level_e').hide();
        @endif
    @else
        $('#select_level_a').hide();
        $('#select_level_b').hide();
        $('#select_level_c').hide();
        $('#select_level_d').hide();
        $('#select_level_e').hide();
        $("#level_a").prop("selectedIndex", 0);
        $("#level_b").prop("selectedIndex", 0);
        $("#level_c").prop("selectedIndex", 0);
        $("#level_d").prop("selectedIndex", 0);
        $("#level_e").prop("selectedIndex", 0);
    @endif

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var ticket_type_select = document.getElementById("ticket_type");
    ticket_type_select.addEventListener("change", function(){

        $('#category option:not(:first)').remove();

        $('#status option:not(:first)').remove();
        $('#level_a option:not(:first)').remove();
        $('#level_b option:not(:first)').remove();
        $('#level_c option:not(:first)').remove();
        $('#level_d option:not(:first)').remove();
        $('#level_e option:not(:first)').remove();

        $('#select_status').hide();
        $('#select_level_a').hide();
        $('#select_level_b').hide();
        $('#select_level_c').hide();
        $('#select_level_d').hide();
        $('#select_level_e').hide();

        $("#category").prop("selectedIndex", 0);
        $("#status").prop("selectedIndex", 0);

        $("#level_a").prop("selectedIndex", 0);
        $("#level_b").prop("selectedIndex", 0);
        $("#level_c").prop("selectedIndex", 0);
        $("#level_d").prop("selectedIndex", 0);
        $("#level_e").prop("selectedIndex", 0);

        @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')

            $('#select_category').show();
            if (this.value != ''){
                $.ajax({
                    url:"/get-category-for-type",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        type_id: this.value
                    },
                    success: function( data ) {
                        data.forEach( function(id) {
                            $('#category').append($('<option>', {
                                value: id.id,
                                text: id.category
                            }));
                        });
                    },
                    error: function( data ) {
                        console.log('peto');
                    }
                });
            }
        @else

            if ( this.value == "1" ) {
                @if($laboratory == 'ADARE')
                    $('#category').append($('<option>', { value: 1001, text: "{{ __('Commercial problem Adare') }}" }));
                    $('#category').append($('<option>', { value: 1002, text: "{{ __('Logistics problem Adare') }}" }));
                @elseif($laboratory == 'THERAMEX1' || $laboratory == 'THERAMEX')
                    $('#category').append($('<option>', { value: 1003, text: "{{ __('Sales problem Theramex') }}" }));
                    $('#category').append($('<option>', { value: 1004, text: "{{ __('Logistics problem Theramex') }}" }));
                @elseif($laboratory == 'AGINAX')
                    $('#category').append($('<option>', { value: 1005, text: "{{ __('Sales problem AGINAX') }}" }));
                    $('#category').append($('<option>', { value: 1006, text: "{{ __('Logistics problem AGINAX') }}" }));
                @elseif($laboratory == 'BNSANTE_GC')
                    $('#category').append($('<option>', { value: 1007, text: "{{ __('Sales problem BNSANTE_GC') }}" }));
                    $('#category').append($('<option>', { value: 1008, text: "{{ __('Logistics problem BNSANTE_GC') }}" }));
                @elseif($laboratory == 'LIFESTYLES')
                    $('#category').append($('<option>', { value: 1009, text: "{{ __('Sales problem LIFESTYLES') }}" }));
                    $('#category').append($('<option>', { value: 1010, text: "{{ __('Logistics problem LIFESTYLES') }}" }));
                @elseif($laboratory == 'HAVEA_FR')
                    $('#category').append($('<option>', { value: 1011, text: "{{ __('Sales problem HAVEA_FR') }}" }));
                    $('#category').append($('<option>', { value: 1012, text: "{{ __('Logistics problem HAVEA_FR') }}" }));
                @endif
            }

            $('#status option:not(:first)').remove();

            if ( this.value == "1" ) {
                $('#status').append($('<option>', { value: 1000, text: "{{ __('Open') }}" }));

                $('#status').append($('<option>', { value: 0, text: "{{ __('Closed') }}" }));
            }
        @endif
    });


    var select = document.getElementById("category");
    select.addEventListener("change", function(){

        $('#select_status').show();
        $('#select_level_a').hide();
        $('#level_a option:not(:first)').remove();

        $('#status option:not(:first)').remove();

        if ( this.value != '1001' && this.value != '1002' && this.value != '1003' && this.value != '1004' && 
             this.value != '1005' && this.value != '1006' && this.value != '1007' && this.value != '1008' && 
             this.value != '1009' && this.value != '1010' && this.value != '1011' && this.value != '1012' 
         ) {
            if (this.value != ''){
                $.ajax({
                    url:"/get-status-for-category",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        category_id: this.value
                    },
                    success: function( data ) {
                        
                        data.forEach( function(id) {
                            $('#status').append($('<option>', {
                                value: id.id,
                                text: id.status
                            }));
                        });
                        @if(isset($canCloseTheTicket))
                            $('#status').append($('<option>', {
                                    value: 0,
                                    text: "{{ __('Closed') }}"
                                }));
                        @endif

                    },
                    error: function( data ) {
                        console.log('peto');
                    }
                });
            }
        }
    });

    @if(isset($ticket) && $ticket->categories_id != '' && $ticket->status_id == '')
        $('#select_level_a').hide();
        $('#select_level_b').hide();
        $('#select_level_c').hide();
        $('#select_level_d').hide();
        $('#select_level_e').hide();
        $('#status option:not(:first)').remove();
        $.ajax({
            url:"/get-status-for-category",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                category_id: {{ $ticket->categories_id }}
            },
            success: function( data ) {
                $('#status option:not(:first)').remove();
                if(data.length > 0){
                    $('#select_status').hide();
                    data.forEach( function(id) {
                        $('#status').append($('<option>', {
                            value: id.id,
                            text: id.status
                        }));
                    });
                } else {
                    $('#select_status').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
            }
        });
    @endif

    var selectStatus = document.getElementById("status");
    selectStatus.addEventListener("change", function(){

        @if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE')
            if(this.value == 2 || this.value == 5 || this.value == 6 || this.value == 11 || this.value == 15 || this.value == 16
            || this.value == 17 || this.value == 19 || this.value == 20 || this.value == 21 || this.value == 25
            ){
                
                //$('#select_level_b').show();
                //$('#select_level_c').show();
                //$('#select_level_d').show();

                $('#level_b option:not(:first)').remove();
                $('#level_c option:not(:first)').remove();
                $('#level_d option:not(:first)').remove();
                $('#level_e option:not(:first)').remove();

                $("#level_a").prop("selectedIndex", 0);
                $("#level_b").prop("selectedIndex", 0);
                $("#level_c").prop("selectedIndex", 0);
                $("#level_d").prop("selectedIndex", 0);
                $("#level_e").prop("selectedIndex", 0);

            } else {
                $('#select_level_a').hide();
                $('#select_level_b').hide();
                $('#select_level_c').hide();
                $('#select_level_d').hide();
                $('#select_level_e').hide();

                $("#level_a").prop("selectedIndex", 0);
                $("#level_b").prop("selectedIndex", 0);
                $("#level_c").prop("selectedIndex", 0);
                $("#level_d").prop("selectedIndex", 0);
                $("#level_e").prop("selectedIndex", 0);
            }
        @else

            $('#select_level_a').hide();
            $('#select_level_b').hide();
            $('#select_level_c').hide();
            $('#select_level_d').hide();
            $('#select_level_e').hide();

            $("#level_a").prop("selectedIndex", 0);
            $("#level_b").prop("selectedIndex", 0);
            $("#level_c").prop("selectedIndex", 0);
            $("#level_d").prop("selectedIndex", 0);
            $("#level_e").prop("selectedIndex", 0);

        @endif

        $('#level_a option:not(:first)').remove();
        
        if (this.value != ''){
            $.ajax({
                url:"/get-level-1-for-status",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    status_id: this.value
                },
                success: function( data ) {
                    $('#level_a option:not(:first)').remove();
                    if(data.length > 0){
                        $('#select_level_a').show();
                        data.forEach( function(id) {
                            $('#level_a').append($('<option>', {
                                value: id.id,
                                text: id.level_a
                            }));
                        });
                    } else {
                        console.log('unsseting');
                        $('#select_level_a').hide();
                    }
                },
                error: function( data ) {
                    console.log('peto');
                }
            });
        }
    });

    @if(isset($ticket) && $ticket->status_id != '' && $ticket->level_a_id == '')
        $('#select_level_b').hide();
        $('#select_level_c').hide();
        $('#select_level_d').hide();
        $('#select_level_e').hide();
        $('#level_a option:not(:first)').remove();
        $.ajax({
            url:"/get-level-1-for-status",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                status_id: {{ $ticket->status_id }}
            },
            success: function( data ) {
                $('#level_a option:not(:first)').remove();
                if(data.length > 0){
                    data.forEach( function(id) {
                        $('#level_a').append($('<option>', {
                            value: id.id,
                            text: id.level_a
                        }));
                    });
                } else {
                    $('#select_level_a').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
            }
        });
    @endif

    var selectLevelA = document.getElementById("level_a");
    selectLevelA.addEventListener("change", function(){

        if(this.value == 1 || this.value == 2 || this.value == 3 || this.value == 4 ){
            $('#select_level_b').show();
            $('#select_level_c').show();
            $('#select_level_d').show();
            $('#select_level_e').show();

            $("#level_b").prop("selectedIndex", 0);
            $("#level_c").prop("selectedIndex", 0);
            $("#level_d").prop("selectedIndex", 0);
            $("#level_e").prop("selectedIndex", 0);
        }

        $('#level_b option:not(:first)').remove();
        $('#level_c option:not(:first)').remove();
        $('#level_d option:not(:first)').remove();
        $('#level_e option:not(:first)').remove();

        $("#level_b").prop("selectedIndex", 0);
        $("#level_c").prop("selectedIndex", 0);
        $("#level_d").prop("selectedIndex", 0);
        $("#level_e").prop("selectedIndex", 0);

        if (this.value != ''){
            $.ajax({
                url:"/get-level-2-for-level-1",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    level_a_id: this.value
                },
                success: function( data ) {
                    $('#level_b option:not(:first)').remove();
                    if(data.length > 0){
                        $('#select_level_b').show();
                        data.forEach( function(id) {
                            $('#level_b').append($('<option>', {
                                value: id.id,
                                text: id.level_b
                            }));
                        });
                    } else {
                        console.log('sale');
                        $('#select_level_b').hide();
                    }
                },
                error: function( data ) {
                    console.log('peto');
                }
            });
        }
    });

    @if(isset($ticket) && $ticket->level_a_id != '' && $ticket->level_b_id == '')
        $('#select_level_c').hide();
        $('#select_level_d').hide();
        $('#select_level_e').hide();
        $('#level_b option:not(:first)').remove();
        $.ajax({
             url:"/get-level-2-for-level-1",
             type: 'get',
             dataType: "json",
             data: {
                _token: CSRF_TOKEN,
                level_a_id: {{ $ticket->level_a_id }}
             },
             success: function( data ) {
                $('#level_b option:not(:first)').remove();
                if(data.length > 0){
                    data.forEach( function(id) {
                        $('#level_b').append($('<option>', {
                            value: id.id,
                            text: id.level_b
                        }));
                    });
                } else {
                    $('#select_level_b').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
             }
           });
    @endif

    var selectLevelB = document.getElementById("level_b");
    selectLevelB.addEventListener("change", function(){
/*
        if(this.value == '1'){
            $('#label_level_c').html("{{ __('Paid LCR verification') }} - {{ __('Can close the ticket') }}");
        } else if(this.value == '1'){
            $('#label_level_c').html("{{ __('Ask the customer to make a transfer with the order number as the reason for the recipient') }}");
        } else {
            $('#label_level_c').html("{{ __('Level') }} 3");
        }
*/

        $('#level_c option:not(:first)').remove();
        $('#level_d option:not(:first)').remove();
        $('#level_e option:not(:first)').remove();

        $("#level_c").prop("selectedIndex", 0);
        $("#level_d").prop("selectedIndex", 0);
        $("#level_e").prop("selectedIndex", 0);

        if (this.value != ''){
            $.ajax({
                url:"/get-level-3-for-level-2",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    level_b_id: this.value
                },
                success: function( data ) {
                    $('#level_c option:not(:first)').remove();
                    data.forEach( function(id) {
                        if(data.length > 0){
                            $('#select_level_c').show();
                            $('#level_c').append($('<option>', {
                                value: id.id,
                                text: id.level_c
                            }));
                        } else {
                            $('#select_level_c').hide();
                        }
                    });
                },
                error: function( data ) {
                    console.log('peto');
                }
            });
        }
    });

    @if(isset($ticket) && $ticket->level_b_id != '' && $ticket->level_c_id == '')
        $('#select_level_d').hide();
        $('#select_level_e').hide();
        $('#level_c option:not(:first)').remove();
        $.ajax({
            url:"/get-level-3-for-level-2",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                level_b_id: {{ $ticket->level_b_id }}
            },
            success: function( data ) {
                $('#level_c option:not(:first)').remove();
                if(data.length > 0){
                    data.forEach( function(id) {
                        $('#level_c').append($('<option>', {
                            value: id.id,
                            text: id.level_c
                        }));
                    });
                } else {
                    $('#select_level_c').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
            }
        });
    @endif

    var selectLevelC = document.getElementById("level_c");
    selectLevelC.addEventListener("change", function(){

        $('#level_d option:not(:first)').remove();
        $('#level_e option:not(:first)').remove();

        $("#level_d").prop("selectedIndex", 0);
        $("#level_e").prop("selectedIndex", 0);

        
        if (this.value != ''){
            $.ajax({
                url:"/get-level-4-for-level-3",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    level_c_id: this.value
                },
                success: function( data ) {
                    $('#level_d option:not(:first)').remove();
                    if(data.length > 0){
                        $('#select_level_d').show();
                        data.forEach( function(id) {
                            $('#level_d').append($('<option>', {
                                value: id.id,
                                text: id.level_d
                            }));
                        });
                    } else {
                        $('#select_level_d').hide();
                    }
                },
                error: function( data ) {
                    console.log('peto');
                }
            });
        }
    });

    @if(isset($ticket) && $ticket->level_c_id != '' && $ticket->level_d_id == '')
        $.ajax({
            url:"/get-level-4-for-level-3",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                level_c_id: {{ $ticket->level_c_id }}
            },
            success: function( data ) {
                $('#level_d option:not(:first)').remove();
                if(data.length > 0){
                    data.forEach( function(id) {
                        $('#level_d').append($('<option>', {
                            value: id.id,
                            text: id.level_d
                        }));
                    });
                } else {
                    $('#select_level_d').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
            }
        });
    @endif

    var selectLevelD = document.getElementById("level_d");
    selectLevelD.addEventListener("change", function(){

        $('#level_e option:not(:first)').remove();

        $("#level_e").prop("selectedIndex", 0);

        if (this.value != ''){
            $.ajax({
                url:"/get-level-5-for-level-4",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    level_d_id: this.value
                },
                success: function( data ) {
                    $('#level_e option:not(:first)').remove();
                    if(data.length > 0){
                        $('#select_level_e').show();
                        data.forEach( function(id) {
                            $('#level_e').append($('<option>', {
                                value: id.id,
                                text: id.level_e
                            }));
                        });
                    } else {
                        $('#select_level_e').hide();
                    }
                },
                error: function( data ) {
                    console.log('peto');
                }
            });
        }
    });

    @if(isset($ticket) && $ticket->level_d_id != '' && $ticket->level_e_id == '')
        $.ajax({
            url:"/get-level-5-for-level-4",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                level_d_id: {{ $ticket->level_d_id }}
            },
            success: function( data ) {
                $('#level_e option:not(:first)').remove();
                if(data.length > 0){
                    data.forEach( function(id) {
                        $('#level_e').append($('<option>', {
                            value: id.id,
                            text: id.level_d
                        }));
                    });
                } else {
                    $('#select_level_e').hide();
                }
            },
            error: function( data ) {
                console.log('peto');
            }
        });
    @endif


     $( "#order" ).autocomplete({
        source: function( request, response ) {
           $.ajax({
             url:"/autocomplete-ordernum",
             type: 'get',
             dataType: "json",
             data: {
                _token: CSRF_TOKEN,
                search: request.term
             },
             success: function( data ) {
                response($.map(data, function (el) {
                    return {
                        label: el.OrderNum, 
                        value: el.id, 
                    };
                }));
            },
             error: function( data ) {
                console.log('peto');
             }
           });
        },
        select: function (event, ui) {

          // Set selection
          $('#order').val(ui.item.label); // display the selected text
          $('#order_id').val(ui.item.value); // save selected id to input

          $.ajax({
             url:"/get-cip-from-order-id",
             type: 'get',
             dataType: "json",
             data: {
                _token: CSRF_TOKEN,
                order_id: ui.item.value
             },
             success: function( data ) {

                $('#cip').val(data[0].CIP);

            },
            error: function( data ) {
                console.log('peto');
             }
           });

          return false;
        }
     });


     $( "#cip" ).autocomplete({
        source: function( request, response ) {
           $.ajax({
             url:"/autocomplete-cip",
             type: 'get',
             dataType: "json",
             data: {
                _token: CSRF_TOKEN,
                search: request.term
             },
             success: function( data ) {
                response($.map(data, function (el) {
                    return {
                        label: el.CIP, 
                        value: el.id, 
                    };
                }));
            },
             error: function( data ) {
                console.log('peto');
             }
           });
        },
        select: function (event, ui) {
          // Set selection
          $('#cip').val(ui.item.label); // display the selected text
          $('#order_id').val(ui.item.value); // save selected id to input


          $.ajax({
             url:"/get-order-num",
             type: 'get',
             dataType: "json",
             data: {
                _token: CSRF_TOKEN,
                order_id: ui.item.value
             },
             success: function( data ) {

                console.log(data.OrderNum);

            },
            error: function( data ) {
                console.log('peto');
             }
           });

          return false;
        }
     });
   });

   </script>  

@endsection
