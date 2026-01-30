@extends("layouts.app")

@section('content')

<div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

    <div class="section mt-1">
        <form action="{{route('savePermission')}}" method="post" role="form">
            @csrf
            <table class="responsive-table card-panel" style="font-size: 11px;">
            
                <thead>
                <tr>
                    <th class="pl-4 fs-20 black-text"></th>
                    @foreach($roles as $role)
                        <th class="text-center fs-20 black-text">{!! ucwords(str_replace("_", " ", $role->name)) !!}-</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)

                    <tr>
                        <td class="pl-4">{!! ucwords(str_replace("_", " ", $permission->name)) !!}</td>
                        @foreach($roles as $role)
                            <td class="text-center">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                    <input id="checkbox" type="checkbox" 
                                           name="permission[ {!! $role->id !!} ][ {!! $permission->id !!} ]"
                                           value='1' {!! ( in_array($role->id.'-'.$permission->id, $permissionRole) ) ? 'checked' : '' !!} >
                                    <span></span>
                                </label>
                            </td>
                        @endforeach
                    </tr>

                    @if ($permission->name == 'Manage') <!-- Segun el orden va poniendo tr´s, estet seria el del proximo nivel -->
                        <tr><th class="pl-4 fs-20 black-text" colspan="8" >Next to Manage</th></tr>
                    @endif

                @endforeach
                </tbody>
            </table>
            <div class="text-center mb-2 put-it-down">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>

        </div>
    </div>
</div>
@endsection