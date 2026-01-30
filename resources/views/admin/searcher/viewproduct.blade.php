
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
                            <h1 class="h4 text-gray-900 mb-4">{{ __('View product') }}</h1>
                        </div>
                        <div class="text-center">

                            <div class="form-group">
                                <label for="campo1">{{ __('Product') }}:</label>
                                <input disabled type="text" class="form-control" value="{{ $product->product_name }}" name="product_name" id="product_name">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
