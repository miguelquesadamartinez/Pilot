
@extends("layouts.app")

@section('content')

@role('OrderController')
<div class="row">

    <div class="col-lg-12 mb-4">
    
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Controller</h6>
            </div>
            @isset($todos)
            <div class="card-body">
           
                <div class="Row">
                    <table id="tableResults" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Module</th>
                                <th class="th-sm">File</th>
                                <th class="th-sm">Error</th>
                                <th class="th-sm">Execute</th>
                                <th class="th-sm">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($todos as $todo)
                                <tr>
                                    <td>{{$todo->id}}</td>
                                    <td>{{$todo->module}}</td>
                                    <td>{{$todo->param_filename}}</td>
                                    <td>
                                        @if($todo->error == 1)
                                            <a target="_blank" href="{{ $controllerPath }}/error-report-todo/{{$todo->id}}" >Yes</a>
                                        @elseif($todo->error == 2)
                                            App Crash
                                        @elseif($todo->checked == 0)
                                            Not checked
                                        @else
                                            No error
                                        @endif
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ $controllerPath }}/manual/{{$todo->id}}" >--></a>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($todo->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="footer" style="text-align: center;">
                        Report generated at: {{ date('d-m-Y H:i:s') }}
                    </div>
                </div>
            
            </div>
            @endisset
        </div>
    </div>
</div>
@endrole

<script type="text/javascript">

$(document).ready(function () {
    $('#tableResults').DataTable( {
        "pageLength": 10,
        order: [[0, 'desc']],
        });
    });

</script>

@endsection
