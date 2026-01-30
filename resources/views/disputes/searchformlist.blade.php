
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Search') }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-3">
                    <form method="POST" class="user" action="/search-order-dispute/search-list">
                        @csrf
                        <input type="hidden" id="status" name="status" value="{{$status}}">
                        <div class="form-group row">
                            <div class="col-sm-11 mb-3 mb-sm-0">
                                <input 
                                @if(Session::has('search_OrderNumList'))
                                    value="{{ Session::get('search_OrderNumList')}}"
                                @endif
                                type="text" class="form-control form-control-user" name="OrderNumList" id="OrderNumList" placeholder="{{ __('Order Number') }}">
                            </div>
                            <div style="margin-top: 8px;" class="col-sm-1">
                                <button id="searchButton" class="btn btn-primary " type="submit" data-dismiss="modal">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>

