@extends('layouts.index')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Reports</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">reports</li>
        </ol>
        @if (session('messages'))
        <div class="alert alert-success" role="alert">
            {{ $messages ?? ''}}
        </div>
        @endif
        @if (session('errors'))
        <div class="alert alert-warning" role="alert">
            {{ $errors}}
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                Generate All Budgets  {{$set}}
            </div>
            <div class="card-body">
                <form action="{{route('generate_reports')}}" method="post">
                    @csrf
                    @if ($set == "all")
                    <input type="hidden" name="budget" value="{{$set}}">
                    @else
                    <input type="hidden" name="budget" value="{{$set}}">
                    @endif
                    <div class="input-group mb-3 col">
                        <div class="input-group-prepend">
                          <button class="btn btn-secondary" disabled type="button" onclick="btn_color()" id="button-addon1 ch">Select Budget</button>
                        </div>
                        <select class="form-control" disabled >
                            @if ($set != "all")
                            <?php $bbb = App\Budget::find($set); ?>
                            <option value="{{$set}}">{{$bbb->description}}</option>
                            @else
                            <option value="all">All (Budgets)</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group mb-3 col">
                        <label class="small mb-1" for="range">Select Range <small>(By date)</small></label><br>
                        <input name="daterange" class="form-control" id="range" type="text" placeholder="choose range" />
                        <small class=""></small>
                    </div>
                    <div class="input-group mb-3 col">
                        <button type="submit" id="ch" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
        

    </div>
@endsection

@section('script')
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
 <script src="js/datatables-demo.js"></script> 
 
 <script>
$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#kk small').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}

$('input[name="daterange"]' || '#kk').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);

});
 </script>
@endsection
