@extends("layouts.app")

@section('content')

    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Proofs of delivery') }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-3">

                    @if(Session::has('success'))
                        <div class="alert alert-success" id="success_smg">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>    
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0px !important;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @isset ($orders)
                        <div class="alert alert-primary">
                        {{ __('Order numbers without proof of delivery') }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableResultsOrders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('Order number') }}</th>
                                        <th class="th-sm">{{ __('Upload file') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $ent)
                                    <tr>
                                        <td>{{$ent->OrderNum}}</td>
                                        <td>
                                            <form enctype="multipart/form-data" method="POST" class="user" action="/admin/dataloader/send-proof">
                                                @csrf

                                                <input type="hidden" id="order_id" name="order_id" @isset($ent->id) value="{{$ent->id}}" @endisset>

                                        
                                                <div class="col-sm-9 mb-3 mb-sm-0">

                                                    <input name="proof_file" id="proof_file" type="file" accept=".pdf" >

                                                    <button style="margin-left: 15px;" id="submitButton" class="btn btn-primary" type="submit" data-dismiss="modal">{{ __('Upload file') }}</button>
                                                </div>
                                                
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>    
                    @endisset

                </div>
            </div>
        </div>  
    </div>
</div>

<script type="text/javascript">
        $(document).ready(function () {
            $('#tableResultsOrders').DataTable( {
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
