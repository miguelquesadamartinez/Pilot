@extends("layouts.app")

@section('content')

    @if(isset($success) && $success != '')
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'documents_added')
                                    {{ __('Pharmacies added successfully') }}
                                @elseif($success == 'documents_deleted')
                                    {{ __('Pharmacies deleted successfully') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    @if(Session::has('success'))
        @php
            Session::forget('success');
        @endphp
    @endif
    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Blocked customers') }} - {{ $labName }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0px !important;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form enctype="multipart/form-data" method="POST" class="user" action="/recovery/add-file">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-7">
                                <input required name="add_file" id="add_file" type="file" accept=".xls,.xlsx" class="form-control form-control-user" >
                            </div>
                            <div class="col-sm-3">
                                <select multiple required name="used_lab[]" id="used_lab" class="form-control form-control-user">
                                    @foreach ($laboratories_glb as $lab)
                                        <option value="{{ $lab->id }}">{{ __($lab->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="margin-top: 8px;" class="col-sm-2">
                                <button id="submitButton" class="btn btn-primary" type="submit" data-dismiss="modal">{{ __('Add Customers') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form enctype="multipart/form-data" method="POST" class="user" action="/recovery/delete-file">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input required name="delete_file" id="delete_file" type="file" accept=".xls,.xlsx" class="form-control form-control-user" >
                            </div>
                            <div style="margin-top: 8px; font-size: 10px;" class="col-sm-2">
                                <button id="submitButton" class="btn btn-primary" type="submit" data-dismiss="modal">{{ __('Delete Customers') }}</button>
                            </div>
                        </div>
                    </form>

                    @if(isset($pharmacies) && $pharmacies->count() > 0 )

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="_tableResultsPharmacies_" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('CIP') }}</th>
                                        <th class="th-sm">{{ __('Pharmacy') }}</th>
                                        <th class="th-sm">{{ __('Laboratory') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($pharmacies as $farm)
                                    <tr>
                                        <td>{{ $farm->cip }}</td>
                                        <td>@isset($farm->pharmacy) {{ $farm->pharmacy->name }} @else <b>{{ __('Pharmacies not found') }} !! </b> @endisset</td>
                                        <td>@isset($farm->laboratory) {{ $farm->laboratory->name }} @endisset</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $pharmacies->links() }}
                        </div>
                    @endif
                    @if(isset($noResults) && $noResults == true)
                        <div class="text-center">
                            <b>{{ __('No results found ...') }}</b>
                        </div>   
                    @endif

                </div>
            </div>
        </div>  
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tableResultsPharmacies').DataTable( {
            "pageLength": 10,
            order: [[0, 'asc']],
                language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
        });
        if ($("#success_smg").length > 0) {
            setTimeout(function() {
                $("#success_smg").slideUp(1500);
            }, 2500);
        }
    });
</script>
@endsection
