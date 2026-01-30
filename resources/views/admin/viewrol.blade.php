@extends("layouts.app")

@section('content')

<input type="hidden" id="hidRolId" name="hidRolId" value="{{$rol->id}}" />

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Permissions for rol') }}: {{$rol->name}}</h1>
                            </div>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">{{ __('Name') }}</th>

                                                    <th align="center" class="th-sm">{{ __('Delete') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($permission_roles as $perm)
                                                    <tr>
                                                        <td>{{$perm->name}}</td>
                                                        <td align="center">
<a permname="{{$perm->name}}" name="linkDeletePerm{{$perm->name}}" href="/admin/delete-rol-perm/{{$perm->id}}/rol/{{$rol->id}}" ><i style="color:red;" class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <form class="user">
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="roles">{{ __('Roles') }}: </label>

                                            <select name="selPerm" id="selPerm">
                                                <option selected value="">{{ __('Choose Permission') }}</option>
                                                @foreach($permissions as $perm)
                                                    @if (!in_array($perm->name, $arr))
                                                        <option value="{{$perm->id}}">{{$perm->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <a id="addPErmissionToRol" href="#" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">{{ __('Add Permission to Rol') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
