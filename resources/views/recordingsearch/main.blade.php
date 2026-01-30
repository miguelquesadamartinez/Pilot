
@extends("layouts.app")

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header">
            {{ __('Search') }}
        </div>
        <div class="card-body">
            <form method="POST" action="/recording-search/search" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <input placeholder="{{ __('Operation') }}" id="search_opr" name="search_opr" @isset($search_opr) @if($search_opr != "") value="{{$search_opr}}" @endif @endisset type="text" class="form-control form-control-user">
                        </div>
                        <div class="col-lg-4">
                            <input placeholder="{{ __('CIP') }}" id="search_cip" name="search_cip" @isset($search_cip) @if($search_cip != "") value="{{$search_cip}}" @endif @endisset type="text" class="form-control form-control-user">
                        </div>
                        <div class="col-lg-4">
                            <input placeholder="{{ __('Teleoperator') }}" id="search_to" name="search_to" @isset($search_to) @if($search_to != "") value="{{$search_to}}" @endif @endisset type="text" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <input placeholder="{{ __('Date') }}" id="search_date" name="search_date" @isset($search_date) @if($search_date != "") value="{{$search_date}}" @endif @endisset type="date" class="form-control form-control-user">
                        </div>
                        <div class="col-lg-4">
                            <input placeholder="{{ __('Initial hour') }}" id="search_hour_from" name="search_hour_from" @isset($search_hour_from) @if($search_hour_from != "") value="{{$search_hour_from}}" @endif @endisset type="time" class="form-control form-control-user">
                        </div>
                        <div class="col-lg-4">
                            <input placeholder="{{ __('End hour') }}" id="search_hour_to" name="search_hour_to" @isset($search_hour_to) @if($search_hour_to != "") value="{{$search_hour_to}}" @endif @endisset type="time" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button style="margin-top: 30px;" type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @isset($recordings)
    <div class="card shadow mb-4">
        <div class="card-body">

            @if ($recordings->count() > 0)

            <div class="table-responsive" style="font-size: 14px;">

                <table class="table table-striped table-bordered" id="tableResultsRecordings" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">{{ __('Operation') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Teleoperator') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('CIP') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Date') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Hour') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Download recording') }}</th>
                            <th style="text-align:center;" class="th-sm">{{ __('Listen recording') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recordings as $rec)
                        <tr>
                            <td>{{$rec->operation}}</td>
                            <td style="text-align:center;">{{$rec->operator}}</td>
                            <td style="text-align:center;">{{$rec->cip}}</td>
                            <td style="text-align:center;">{{ Carbon\Carbon::parse($rec->date)->format('d-m-Y') }}</td>
                            <td style="text-align:center;">{{$rec->time}}</td>
                            
                            <td style="text-align:center;" align="center">
                                <a href="{{route('download.recording.search', $rec->id)}}" data-report_id="{{$rec->id}}" ><i class="fas fa-download"></i></a>
                            </td>
                            <td style="text-align:center;" align="center">
                                <audio controls>
                                    <source src="/download-recording-search/{{$rec->id}}" type="audio/x-wav">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                {{ $recordings->links() }}
            </div>

            @else
                <div class="text-center">
                    <b>{{ __('No recording info') }}</b>
                </div>
                
            @endisset

        </div>
    </div>
    @endisset

<script type="text/javascript">

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#tableResultsRecordings').DataTable( {
        "pageLength": 25,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        //order: [[0, 'desc']],
        language: {
                "url": "{{url('translations/datatable')}}/{{app()->getLocale()}}.json"
            }
    });

});

</script>

@endsection
