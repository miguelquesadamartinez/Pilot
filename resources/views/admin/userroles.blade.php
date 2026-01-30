@extends("layouts.app")

@section('content')

    @isset($success)
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'rol added')
                                    {{ __('Rol added to user successfully') }}
                                @elseif($success == 'rol removed')
                                    {{ __('Rol removed to user successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

        <input type="hidden" id="hidUserId" name="hidUserId" value="{{$user->id}}" />

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Roles for') }}: {{$user->name}}</h1>
                            </div>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%;" class="th-sm">{{ __('Name') }}</th>

                                                    <th style="width: 50%;" align="center" class="th-sm">{{ __('Delete') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user_roles as $rol)
                                                <tr>
                                                    <td>{{$rol}}</td>
                                                    <td align="center">
                                                        <a username="{{$user->name}}" rolname="{{$rol}}" name="linkDeleteRole{{$rol}}" href="/admin/delete-user-rol/{{$user->id}}/rol/{{$rol}}"><i style="color:red;" class="fas fa-trash"></i></a>
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

                                            <select name="selRoles" id="selRoles">
                                                <option selected value="">{{ __('Choose rol') }}</option>
                                                @foreach($roles as $rol)

                                                    @if(!$user_roles->contains($rol->name)) 
                                                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <a id="addRolToUser" href="#" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">{{ __('Add rol to user') }}</span>
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