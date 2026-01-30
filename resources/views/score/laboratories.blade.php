@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Laboratories') }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" style="font-size: 14px;">

            <table class="table table-striped table-bordered" id="dataTableUsers" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 5%;" class="th-sm">{{ __('Id') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('Laboratory') }}</th>
                <th style="width: 20%;" class="th-sm">{{ __('Country') }}</th>
                <th style="width: 10%;" class="th-sm">{{ __('Active') }}</th>
            </tr>
        </thead>
        <tbody>

        @foreach($laboratories as $lab)
            <tr>
                <td>{{$lab->laboratory_id}}</td>
                <td>{{$lab->name}}</td>
                <td>{{$lab->country}}</td>
                <td align="center">

                    @if($lab->enabled == "1")
                        <a name="updateStatusLaboratory{{$lab->id}}" laboratory="{{$lab->name}}" href="/scoring/laboratory-change-status/{{ $lab->id }}">
                            <i style="color:green;" class="fas fa-info-circle"></i>
                        </a>
                    @else
                        <a name="updateStatusLaboratory{{$lab->id}}" laboratory="{{$lab->name}}" href="/scoring/laboratory-change-status/{{ $lab->id }}">
                            <i style="color:red;" class="fas fa-info-circle"></i>
                        </a>
                    @endif
                    
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
    
            </div>
        </div>
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
