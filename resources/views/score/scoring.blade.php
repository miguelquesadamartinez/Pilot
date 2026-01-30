
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
        <div id="error_div" style="margin-bottom:15px;" class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                @if($success == 'score edited')
                                    {{ __('Score updated successfully') }}
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
            <div class="row text-center">

                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ __('Scoring') }}</h1>
                        </div>
                        <div class="text-center">

                        <form method="POST" action="/scoring/update-score-manual">
                            
                            @csrf

                            <input type="hidden" id="score_id" name="score_id" @isset($score->id) value="{{$score->id}}" @endisset>
                            <input type="hidden" id="pharmacy_id" name="pharmacy_id" 
                            @isset($score->pharm_id) 
                                value="{{$score->pharm_id}}" 
                            @else
                                value="{{$score->pharmacy_id}}"
                            @endisset
                            >

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <div class="text-left" >
                                        {{ __('Pharmacy name') }}: 
                                        <b>
                                            @if(isset($score->pharmacy->name))
                                                {{ $score->pharmacy->name }}
                                            @else
                                                {{ $score->name }}
                                            @endif
                                        </b>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="score">{{ __('Final Score') }}</label>
                                <input disabled type="text" value="{{ number_format($score->score, 1) }}" class="form-control @error('score') is-invalid @enderror" name="score" id="score">
                            </div>
@php /* @endphp
                            <div class="form-group">
                                <label for="manual_enter">{{ __('Manual Score') }}</label>
                                <input type="text" value="{{ $score->manual }}" class="form-control @error('manual_enter') is-invalid @enderror" name="manual_enter" id="manual_enter">
                            </div>
@php */ @endphp
                            <div class="form-group">
                                <label for="manual_enter">{{ __('Manual Score') }}</label>
                                <select name="manual_enter" id="manual_enter" class="form-control">
                                    <option @if($score->manual == 10) selected  @endif value="10">10</option>
                                    <option @if($score->manual == 9) selected  @endif value="9">9</option>
                                    <option @if($score->manual == 8) selected  @endif value="8">8</option>
                                    <option @if($score->manual == 7) selected  @endif value="7">7</option>
                                    <option @if($score->manual == 6) selected  @endif value="6">6</option>
                                    <option @if($score->manual == 5) selected  @endif value="5">5</option>
                                    <option @if($score->manual == 4) selected  @endif value="4">4</option>
                                    <option @if($score->manual == 3) selected  @endif value="3">3</option>
                                    <option @if($score->manual == 2) selected  @endif value="2">2</option>
                                    <option @if($score->manual == 1) selected  @endif value="1">1</option>
                                    <option @if($score->manual == 0) selected  @endif value="0">0</option>
                                    <option @if($score->manual == -1) selected  @endif value="-1">-1</option>
                                    <option @if($score->manual == -2) selected  @endif value="-2">-2</option>
                                    <option @if($score->manual == -3) selected  @endif value="-3">-3</option>
                                    <option @if($score->manual == -4) selected  @endif value="-4">-4</option>
                                    <option @if($score->manual == -5) selected  @endif value="-5">-5</option>
                                    <option @if($score->manual == -6) selected  @endif value="-6">-6</option>
                                    <option @if($score->manual == -7) selected  @endif value="-7">-7</option>
                                    <option @if($score->manual == -8) selected  @endif value="-8">-8</option>
                                    <option @if($score->manual == -9) selected  @endif value="-9">-9</option>
                                    <option @if($score->manual == -10) selected  @endif value="-10">-10</option>
                                </select>
                            </div>

                            <div class="left">
                                <label><b>{{ __('Pharmacies scores') }}</label></b>
                            </div>

                            @foreach($scores as $sc)

                                @if($sc->enabled == "1")
                                    <div class="row">
                                        <div class="text-left col-lg-6" >
                                            {{$sc->getLaboratoryName()}}: <b>{{ $sc->score }}</b>

<input type="hidden" id="value_{{str_replace(" ", "", $sc->laboratory()[0]->name)}}" name="value_{{str_replace(" ", "", $sc->laboratory()[0]->name)}}" value="{{$sc->score}}">

                                        </div>
                                    </div>
                                @endif

                            @endforeach

                            <button style="margin-top: 15px;" type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        console.log('JuJú');

        if ($("#error_div").length > 0) {
            setTimeout(function() {
                $("#error_div").slideUp(1500);
            }, 2500);
        }

        //$("#manual_enter").keyup(function(){
        $("#manual_enter").change(function(){

            media = 0;
            cnt = 0;
            tempVal = 0;

            tmp = $("#manual_enter").val();
            //console.log(tmp);

            if( tmp != "" && !isNaN(tmp)){
                manual_value = parseInt($("#manual_enter").val());

                //ToDo: Calculation

                // Asi solo cogemos los hidden de los valore de los scores
                $.each($('[name^="value_"]'),function(i,val){
                    if($(this).attr("type")=="hidden"){
                        tempVal += parseInt($(this).val());
                        cnt++;
                    }
                });

                if(tempVal != 0) {
                    media = tempVal / cnt;
                    media = media +  manual_value ;
                } else {
                    media = manual_value;
                }

                console.log(media.toFixed(1));

                $("#score").val(media.toFixed(1));
                
            }
        });

    });

</script>
   
@endsection
