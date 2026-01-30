
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

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row text-center">

                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ __('New category') }}</h1>
                        </div>
                        <div class="text-center">

                        <form method="POST" action="/ticketing/create-category/">
                            
                            @csrf

                            <div class="form-group">
                                <label for="campo1">{{ __('English') }}:</label>
                                <input type="text" value="{{ old('category_en') }}" class="form-control @error('category_en') is-invalid @enderror" name="category_en" id="category_en" placeholder="{{ __('Category in english') }}">
                            </div>
                            <div class="form-group">
                                <label for="campo2">{{ __('Spanish') }}:</label>
                                <input type="text" value="{{ old('category_es') }}" class="form-control @error('category_es') is-invalid @enderror" name="category_es" id="category_es" placeholder="{{ __('Category in spanish') }}">
                            </div>
                            <div class="form-group">
                                <label for="campo3">{{ __('French') }}:</label>
                                <input type="text" value="{{ old('category_fr') }}" class="form-control @error('category_fr') is-invalid @enderror" name="category_fr" id="category_fr" placeholder="{{ __('Category in french') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
