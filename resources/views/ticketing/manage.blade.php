
@extends("layouts.app")

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Categories') }}</h1>

        <a href="/ticketing/new-category" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> {{ __('New category') }}
        </a>

    </div>

    @isset($success)
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'cat edited')
                                    {{ __('Category updated successfully') }}
                                @elseif($success == 'new cat')
                                    {{ __('Category created successfully') }}
                                @elseif($success == 'new stat')
                                    {{ __('Status created successfully') }}
                                @elseif($success == 'status edited')
                                    {{ __('Status updated successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    <div class="card shadow mb-4">
        <div class="card-body">

            @isset($categories_glb)

            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsCategories" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Category in english') }}</th>
                            <th class="th-sm">{{ __('Category Name') }}</th>
                            <th class="th-sm">{{ __('Category Name') }}</th>
                            <th class="th-sm">{{ __('Edit category') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories_glb as $cat)
                        <tr>
                            <td>{{$cat->category_en}}</td>
                            <td>{{$cat->category_es}}</td>
                            <td>{{$cat->category_fr}}</td>
                            <td align="center">
                                <a href="/ticketing/edit-category/{{$cat->id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            @else
                <div class="text-center">
                    <b>No ticketing info</b>
                </div>
                
            @endisset

        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Statuses') }}</h1>

        <a href="/ticketing/new-status" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> {{ __('New Status') }}
        </a>

    </div>

    <div class="card shadow mb-4">
        <div class="card-body">

            @isset($status_glb)

            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsStatuses" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Status Name') }}</th>
                            <th class="th-sm">{{ __('Status Name') }}</th>
                            <th class="th-sm">{{ __('Status Name') }}</th>
                            <th class="th-sm">{{ __('Category') }}</th>
                            <th class="th-sm">{{ __('Edit status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($status_glb as $st)
                        <tr>
                            <td>{{$st->status_en}}</td>
                            <td>{{$st->status_es}}</td>
                            <td>{{$st->status_fr}}</td>
                            <td>{{$st->category->category_en}}</td>
                            <td align="center">
                                <a href="/ticketing/edit-status/{{$st->id}}" ><i class="fas fa-info-circle"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            @else
                <div class="text-center">
                    <b>No Status info</b>
                </div>
                
            @endisset

        </div>
    </div>

<!-- Category Modal-->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Creating Category') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <form class="user">
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="category_en" placeholder="{{ __('English Category Name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="category_es" placeholder="{{ __('Spanish Category Name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="category_fr" placeholder="{{ __('French Category Name') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="createCategory" class="btn btn-success" type="button">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">

    $(document).ready(function () {

        $('#tableResultsCategories').DataTable( {
            "pageLength": 5,
            order: [[0, 'asc']],
            language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });

        $('#tableResultsStatuses').DataTable( {
            "pageLength": 5,
            order: [[0, 'asc']],
            language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });

        if ($("#error_div").length > 0) {
            setTimeout(function() {
                $("#error_div").slideUp(1500);
            }, 2500);
        }
    });

</script>

@endsection
