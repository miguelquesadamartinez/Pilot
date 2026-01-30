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

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="p-5">
                    <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ __('New user') }}</h1>
                        </div>
                        <div class="text-center">
                            <form method="POST" action="/admin/create-user" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="name">{{ __('User Name') }}</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="title">{{ __('User Email') }}</label>
                                        <input value="{{ old('email') }}"type="text" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="title">{{ __('User Password') }}</label>
                                        <input value="{{ old('password') }}"type="text" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password">
                                    </div>
                                </div>

                                <label for="title">{{ __('User Language') }}</label>
                                <select name="language" id="language" class="form-control form-control-user @error('language') is-invalid @enderror">
                                    <option @if( old('languague') == 'en' ) selected @endif value="en">en</option>
                                    <option @if( old('languague') == 'es' ) selected @endif value="es">es</option>
                                    <option @if( old('languague') == 'fr' ) selected @endif value="fr">fr</option>
                                </select>
                                
                                <div class="text-center" style="margin-top: 15px;">
                                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

@endsection