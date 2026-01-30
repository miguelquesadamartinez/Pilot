@extends("layouts.app")

@section('content')

@include('score.searchform')

    @isset($success)
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'user created')
                                    {{ __('User created successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Search result') }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" style="font-size: 12px;">

            <table class="table table-striped table-bordered" id="dataTableUsers" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 20%;" class="th-sm">{{ __('Name') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('Pharmacy name') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('CIP') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('Phone') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('e-mail') }}</th>
                <th style="width: 10%;" class="th-sm">{{ __('Score') }}</th>
                <th style="width: 10%;" class="th-sm">{{ __('Data') }}</th>
            </tr>
        </thead>
        <tbody>

        @foreach($pharmacyExists as $pharm)
            <tr>
                <td>{{$pharm->name}}</td>
                <td>{{$pharm->business_name}}</td>
                <td>{{$pharm->cip}}</td>
                <td>{{$pharm->phone}}</td>
                <td>{{$pharm->email}}</td>

                <td>
                    @php //Por varios origenes de los datos  @endphp
                    @if(isset($pharm->scoreObj->score))
                        {{number_format($pharm->scoreObj->score, 1)}}
                    @else
                        {{ __('Without data') }}
                    @endif
                </td>
                
                <td align="center">
                    <a href="/scoring/pharmacy-scoring/{{ $pharm->id }}">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
    
            </div>
        </div>
    </div>

        <div class="d-flex justify-content-center">
            {{ $pharmacyExists->links() }}
        </div>

    <script type="text/javascript">

        $(document).ready(function () {

            if ($("#error_div").length > 0) {
                setTimeout(function() {
                    $("#error_div").slideUp(1500);
                }, 2500);
            }
        });

    </script>
<script type="text/javascript">

$(document).ready(function () {
    $('#dataTableUsers').DataTable( {
        "pageLength": 25,
        order: [[0, 'asc']],
        
        "paging":   false,
        "info":     false,
        "searching": false,
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });
    });

</script>
@endsection
