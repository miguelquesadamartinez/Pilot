
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
                            <h1 class="h4 text-gray-900 mb-4">{{ __('Edit Status') }}</h1>
                        </div>
                        <div class="text-center">

                        <form method="POST" action="/ticketing/update-status/">
                            
                            @csrf

                            <input type="hidden" id="status_id" name="status_id" value="{{$status->id}}">

                            <div class="form-group">
                                <label for="campo1">{{ __('English') }}:</label>
                                <input type="text" value="{{ $status->status_en }}" class="form-control @error('status_en') is-invalid @enderror" name="status_en" id="status_en" placeholder="{{ __('Status in english') }}">
                            </div>
                            <div class="form-group">
                                <label for="campo2">{{ __('Spanish') }}:</label>
                                <input type="text" value="{{ $status->status_es }}" class="form-control @error('status_es') is-invalid @enderror" name="status_es" id="status_es" placeholder="{{ __('Status in spanish') }}">
                            </div>
                            <div class="form-group">
                                <label for="campo3">{{ __('French') }}:</label>
                                <input type="text" value="{{ $status->status_fr }}" class="form-control @error('status_fr') is-invalid @enderror" name="status_fr" id="status_fr" placeholder="{{ __('Status in french') }}">
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="category">{{ __('Category') }}</label>
                                    <select name="category" id="category" class="form-control form-control-user @error('category') is-invalid @enderror">
                                    <option selected="true" value="">{{ __('Select category') }}</option>
                                    @foreach($categories_glb as $cat)
                                    <option @if(@old('category', $status->category_id) == $cat->id) selected @endif  value="{{$cat->id}}">
                                        @if($locale == 'en')
                                            {{$cat->category_en}}
                                        @elseif($locale == 'es')
                                            {{$cat->category_es}}
                                        @elseif($locale == 'fr')
                                            {{$cat->category_fr}}
                                        @endif
                                        </option>
                                    @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
