@extends("layouts.app")

@section('content')

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
        <h1 class="h3 mb-0 text-gray-800">{{ __('Users') }}</h1>
        <a href="/ldapSynchronization" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> {{ __('Synchronize') }}
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTableUsers" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 30%;" class="th-sm">{{ __('Name') }}</th>
                            <th style="width: 30%;" class="th-sm">{{ __('e-mail') }}</th>
                            <th style="width: 20%;" class="th-sm">{{ __('User') }}</th>
                            <th style="width: 20%;" class="th-sm">{{ __('Roles') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $usr)
                        <tr>
                            <td>{{$usr->name}}</td>
                            <td>{{$usr->email}}</td>
                            <td>{{$usr->samaccountname}}</td>
                            <td align="center">
                                <a href="/admin/user-roles/{{ $usr->id }}">
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

    <script type="text/javascript">
        $(document).ready(function () {
            if ($("#error_div").length > 0) {
                setTimeout(function() {
                    $("#error_div").slideUp(1500);
                }, 2500);
            }
            $('#dataTableUsers').DataTable( {
                "pageLength": 25,
                order: [[0, 'asc']],
                language: {
                    "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
                }
            });
        });

    </script>

@endsection
