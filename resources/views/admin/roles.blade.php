@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Roles') }}</h1>
        <a href="#" data-toggle="modal" data-target="#rolModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> {{ __('New rol') }}</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Name') }}</th>
                            <th class="th-sm">{{ __('Edit') }}</th>
                            <th class="th-sm">{{ __('Users') }}</th>
                            <th class="th-sm">{{ __('Revoke Rol') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $rol)
                        <tr>
                            <td>{{$rol->name}}</td>
                            <td align="center">
                                <a href="/admin/view-rol/{{$rol->id}}" ><i class="fas fa-edit"></i></a>
                            </td>
                            <td align="center">
                                <a href="/admin/view-rol-users/{{$rol->id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td align="center">
                                <a rolname="{{$rol->name}}" name="linkRevokeRol{{$rol->name}}" href="/admin/revoke-rol/{{$rol->id}}" ><i style="color:red;" class="fas fa-trash"></i></a>
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
    $('#dataTable').DataTable( {
        "pageLength": 25,
        order: [[0, 'desc']],
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });
    });

</script>

@endsection
