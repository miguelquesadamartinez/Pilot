@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Rol Users for') }}: {{$roleName}}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($vble as $var)
                        <tr>
                            <td>{{$var->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

<script type="text/javascript">

$(document).ready(function () {
    $('#dataTable').DataTable( {
        "pageLength": 10,
        order: [[0, 'desc']],
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });
    });

</script>

@endsection
