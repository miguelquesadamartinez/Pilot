
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Search') }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-3">
                    <form class="user" action="/admin/searcher/search">
                        <div class="form-group row">
                            <div class="col-sm-11 mb-3 mb-sm-0">

                                <input 
                                @if(Session::has('search_string'))
                                    value="{{ Session::get('search_string')}}"
                                @endif
                                type="text" class="form-control form-control-user" name="searchText" id="searchText" 
                                @role('TeleOperator')
                                    placeholder="{{ __('Order Number or CIP') }}"
                                @else 
                                    placeholder="{{ __('Order Number, CIP or Ticket') }}"
                                @endrole
                                > 

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

