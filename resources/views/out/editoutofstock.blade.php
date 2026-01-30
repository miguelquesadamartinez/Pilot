
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
        <div id="msg_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'out created')
                                    {{ __('Product created successfully') }}
                                @elseif($success == 'out edited')
                                    {{ __('Product edited successfully') }}
                                @elseif($success == 'out deleted')
                                    {{ __('Product deleted successfully') }}
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
            <div class="row text-center">

                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            @isset($out_of_stock->id)
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit product out of stock') }}</h1>
                            @else
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Create product out of stock') }}</h1>
                            @endisset    
                        </div>
                        <div class="text-center">

                        @isset($out_of_stock->id)
                            <form method="POST" action="/update-products-out-of-stock" enctype="multipart/form-data">
                                <input type="hidden" id="product_id" name="product_id" value="{{$out_of_stock->product_id}}">
                                <input type="hidden" id="stock_id" name="stock_id" value="{{$out_of_stock->id}}">
                        @else
                            <form method="POST" action="/create-products-out-of-stock" enctype="multipart/form-data">
                                <input type="hidden" id="product_id" name="product_id" value="">
                        @endisset
                            
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}:</label>
                                @isset($out_of_stock->product->name)
                                    <input disabled value="{{ old('name', $out_of_stock->product->name) }}" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name">
                                @else
                                    <input onkeyup="Product.search(this.value)" autocomplete="off" required value="{{ old('name') }}" type="search" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name">
                                    <ul id="product-list" class="navbar-nav ml-auto text-left">
                                    </ul>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="date">{{ __('Date') }}:</label>
                                @isset($out_of_stock->peremption_date)
                                    <input required value="{{ old('peremption_date', $out_of_stock->peremption_date) }}" type="date" class="form-control form-control-user @error('peremption_date') is-invalid @enderror" id="peremption_date" name="peremption_date">
                                @else
                                    <input required value="{{ old('peremption_date', Carbon\Carbon::today()->format('Y-m-d') ) }}" type="date" class="form-control form-control-user @error('peremption_date') is-invalid @enderror" id="peremption_date" name="peremption_date">
                                @endif
                            </div>

                            
                            @isset($out_of_stock->id)
                                <button type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            @endisset
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="loading">
    <div id="loading-content"></div>
</section>

<script type="text/javascript">

      const Product = {
        search(query) {
            
            if (query && query.length >= 3)
                $.ajax({
                    url: "{{ url('/product-list') }}/" + query,
                    beforeSend: function(xhr) {
                        //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                    }
                })
                .done(function(response) {

                    

                    $("#search").removeClass('is-invalid');
                    let productList = $("#product-list");

                    productList.html("");

                    let products = response.products.data;
                    if (products) {
                        products.forEach(function(product, index) {

                            let text = product.name;

                            console.log(text);

                            let row = '<li><a class="nav-item dropdown no-arrow" data-id="' + product.id +
                                '" onclick="Product.select2(' +
                                product.id + ',\'' + text.replace("'", "") + '\')">' +
                                product.name + "</a></li>";
                            productList.append(row);
                        });
                    }
                    productList.show();

                });
        },
        select2(id, name) {
            $("#name").val(name);
            $("#product_id").val(id);
            $("#product-list").hide();
        }
    };

    $(document).ready(function () {

        if ($("#msg_div").length > 0) {
            setTimeout(function() {
                $("#msg_div").slideUp(1500);
            }, 2500);
        }

    });

</script>

@endsection
