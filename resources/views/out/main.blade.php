
@extends("layouts.app")

@section('content')

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

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Products out of stock') }}</h1>
        <a href="/new-products-out-of-stock/" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> {{ __('New product out of stock') }}
        </a>
        
    </div>

<!--
    <div class="card shadow mb-4">
        <div class="card-header">
            {{ __('Search') }}
        </div>
        <div class="card-body">
            <form method="POST" action="/out-of-stock-search" enctype="multipart/form-data">
                @csrf
                        
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-9">
                            <label for="search">{{ __('Text to search') }}</label>
                            <input @isset($search) @if($search != "") value="{{$search}}" @endif @endisset type="text" class="form-control form-control-user" id="search" name="search">
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center">
                                <button style="margin-top: 30px;" type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
-->

    <div class="card shadow mb-4">
        <div class="card-body">

            @isset($out_of_stock)

            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsOutOFStock" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Product') }}</th>
                            <th class="th-sm">{{ __('Laboratory') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Re Stock Date') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Update') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($out_of_stock as $doc)
                        <tr>
                            <td>{{$doc->product->name}}</td>
                            <td>{{$doc->product->laboratory->name}}</td>
                            <td style="text-align:center;">{{ Carbon\Carbon::parse($doc->peremption_date)->format('d-m-Y') }}</td>
    
                            <td style="text-align:center;" align="center">
                                <a href="/edit-products-out-of-stock/{{$doc->id}}" ><i class="fas fa-edit"></i></a>
                            </td>
                            <td style="text-align:center;" align="center">
                                <a name="deleteProductOutOfStock{{$doc->id}}" product="{{$doc->product->name}}" href="/delete-products-out-of-stock/{{$doc->id}}" ><i class="fas fa-info-circle" style="color:red;"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                {{-- $out_of_stock->links() --}}
            </div>

            @else
                <div class="text-center">
                    <b>No Status info</b>
                </div>
                
            @endisset

        </div>
    </div>

<script type="text/javascript">

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#tableResultsOutOFStock').DataTable( {
        "pageLength": 10,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        order: [[0, 'desc']],
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
    });

    if ($("#error_div").length > 0) {
        setTimeout(function() {
            $("#error_div").slideUp(1500);
        }, 2500);
    }
    if ($("#msg_div").length > 0) {
        setTimeout(function() {
            $("#msg_div").slideUp(1500);
        }, 2500);
    }
});

</script>

@endsection
