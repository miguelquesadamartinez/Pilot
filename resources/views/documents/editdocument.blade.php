
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
                                @if($success == 'doc created')
                                    {{ __('Document created successfully') }}
                                @elseif($success == 'doc edited')
                                    {{ __('Document edited successfully') }}
                                @elseif($success == 'file deleted')
                                    {{ __('Document deleted successfully') }}
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
                            @isset($document->id)
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit Document') }}</h1>
                            @else
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Create Document') }}</h1>
                            @endisset    
                        </div>
                        <div class="text-center">

                        @isset($document->id)
                            <form method="POST" action="/documents-update-document" enctype="multipart/form-data">
                                <input type="hidden" id="document_id" name="document_id" value="{{$document->id}}">
                        @else
                            <form method="POST" action="/documents-create-document" enctype="multipart/form-data">
                        @endisset
                            
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}:</label>
                                @isset($document->name)
                                    <input required value="{{ old('name', $document->name) }}" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name">
                                @else
                                    <input required value="{{ old('name') }}" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="version">{{ __('Version') }}:</label>
                                @isset($document->version)
                                    <input required value="{{ old('version', $document->version) }}" type="text" class="form-control form-control-user @error('version') is-invalid @enderror" id="version" name="version">
                                @else
                                    <input required value="{{ old('version') }}" type="text" class="form-control form-control-user @error('version') is-invalid @enderror" id="version" name="version">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="active">{{ __('Active') }}:</label>

                                @isset($document->active)
                                    <input style="height: 30px;" class="form-control form-control-user" type="checkbox" name="active" id="active" @if($document->active == '1') checked @endif>
                                @else
                                    <input style="height: 30px;" class="form-control form-control-user" type="checkbox" name="active" id="active" checked="">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="date">{{ __('Date') }}:</label>
                                @isset($document->date)
                                    <input required value="{{ old('date', $document->date) }}" type="date" class="form-control form-control-user @error('date') is-invalid @enderror" id="date" name="date">
                                @else
                                    <input required value="{{ old('date', Carbon\Carbon::today()->format('Y-m-d') ) }}" type="date" class="form-control form-control-user @error('date') is-invalid @enderror" id="date" name="date">
                                @endif
                            </div>

                            @if( isset($document->filePath) && $document->filePath != '' )
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered" id="tableResultsTicketing" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">{{ __('File name') }}</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td>
                                            <a href="{{route('download.document', $document->id)}}" data-report_id="{{$document->id}}" >{{$document->fileName}}</a>
                                        </td>
                                        <td>
                                            <a name="linkDeleteDocument{{$document->id}}" style="color:red;" href="{{route('document.delete.file', $document->id)}}" permname="{{$document->fileName}}" >{{ __('Delete') }}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                </div>
                            @else

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="file">{{ __('Add File') }}</label>
                                        <input name="document_file" id="document_file" accept=".pdf" type="file" required class="form-control form-control-user" >
                                    </div>
                                </div>

                            @endisset
                            
                            @isset($document->id)
                                <button onclick="showLoading();" type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                            @else
                                <button onclick="showLoading();" type="submit" class="btn btn-primary">{{ __('Create') }}</button>
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

    var sppined = false;

    function showLoading() {
        //document.querySelector('#loading').classList.add('loading');
        //document.querySelector('#loading-content').classList.add('loading-content');

        sppined = true;
      }
      
    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
      }

    $(document).ready(function () {
/*
        $('body').click(function(){

            if ( sppined == true) {
                hideLoading();
                alert('JuJú');
            }
            //
        });
*/
        const input = document.getElementById('document_file');
        if(input) {
            input.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {

                /*Maximum allowed size in bytes
                    2MB Example
                    Change first operand(multiplier) for your needs*/
                const maxAllowedSize = 2 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                    alert("{{ __('Max size allowed') }}.");
                    target.value = ''
                }
            }
            })
        }

        if ($("#msg_div").length > 0) {
            setTimeout(function() {
                $("#msg_div").slideUp(1500);
            }, 2500);
        }

        $("input[id*='version']").keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || 
                (event.keyCode >= 96 && event.keyCode <= 105) || 
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault(); 
            //if a decimal has been added, disable the "."-button

        });

    });

</script>

@endsection
