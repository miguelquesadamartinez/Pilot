
@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Documents') }}</h1>
        <a href="/documents-new-document/" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> {{ __('New Document') }}
        </a>
        
    </div>


    <div class="card shadow mb-4">
        <div class="card-header">
            {{ __('Search') }}
        </div>
        <div class="card-body">
            <form method="POST" action="/documents-search" enctype="multipart/form-data">
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


    <div class="card shadow mb-4">
        <div class="card-body">

            @isset($documents)

            <div class="table-responsive">

                <table class="table table-striped table-bordered" id="tableResultsDocuments" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Name') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Version') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Date') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Status') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Edit document') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Download document') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td>{{$doc->name}}</td>
                            <td style="text-align:center;">{{$doc->version}}</td>
                            <td style="text-align:center;">{{ Carbon\Carbon::parse($doc->date)->format('d-m-Y') }}</td>
                            <td 
                                @if($doc->active == 0)
                                    style="color:red; text-align:center;"
                                @elseif($doc->active == 1)
                                    style="color:green; text-align:center;"
                                @endif
                            >
                                @if($doc->active == 0)
                                    {{ __('Inative') }}
                                @elseif($doc->active == 1)
                                    {{ __('Active') }}
                                @endif
                            </td>
                            <td style="text-align:center;" align="center">
                                <a href="/documents-edit-document/{{$doc->id}}" ><i class="fas fa-edit"></i></a>
                            </td>
                            <td style="text-align:center;" align="center">
                                <a href="/download-document/{{$doc->id}}" ><i class="fas fa-download"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                {{ $documents->links() }}
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

    $('#tableResultsDocuments').DataTable( {
        "pageLength": 10,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        order: [[2, 'desc']],
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
