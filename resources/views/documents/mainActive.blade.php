
@extends("layouts.app")

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Documents') }}</h1>
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
                            <th style="text-align:center;" class="th-sm">{{ __('Download document') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td>{{$doc->name}}</td>
                            <td style="text-align:center;">{{$doc->version}}</td>
                            <td style="text-align:center;">{{ Carbon\Carbon::parse($doc->date)->format('d-m-Y') }}</td>
                            <td align="center">
                                <a href="/download-document/{{$doc->id}}" ><i class="fas fa-download"></i></a>
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

<script type="text/javascript">

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#tableResultsDocuments').DataTable( {
        "pageLength": 25,
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
