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

                    @isset ($ordersExists)
                        <div style="margin-top: 15px;" class="alert alert-primary">
                        {{ __('Order numbers with proof of delivery') }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableResultsProofs" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="th-sm">{{ __('Order number') }}</th>
                                        <th class="th-sm">{{ __('Delete file') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($ordersExists as $ent)
                                    <tr>
                                        <td>{{$ent->OrderNum}}</td>
                                        <td>
                                        <a name="deleteFileProof{{$ent->id}}" fileName="{{$ent->fileName}}" id="deleteFile" href="/admin/dataloader/delete-proof/{{$ent->deliveryFile->id}}" ><i style="color: red;" class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> 
                        <div class="d-flex justify-content-center">
                            {{ $ordersExists->links() }}
                        </div>

                    @endisset
                </div>
            </div>
        </div>  
    </div>
</div>

@endsection
