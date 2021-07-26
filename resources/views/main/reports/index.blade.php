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
                Budget's Report
            </div>
            <div class="card-body">
                <form action="{{route('generate_reports')}}" method="post">
                    @csrf
                    <input name="daterange"  type="hidden" value="0" />
                    <div class="input-group mb-3 col">
                        <div class="input-group-prepend">
                          <button class="btn btn-secondary" type="button" onclick="btn_color()" id="button-addon1 ch">Select Budget</button>
                        </div>
                        <select name="budget" class="form-control" id="inputGroupSelect01" aria-describedby="button-addon1">
                            <option value="all">All (Budgets)</option>
                            @foreach ($budgets as $budget)     
                            <option value="{{$budget->id}}">{{$budget->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3 col">
                        <button type="submit" id="ch" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        CashBook Report
                    </div>
                    <div class="card-body">
                        <form action="{{route('create_pdf_cashbook_range')}}" method="post">
                            @csrf
                            <div class="input-group mb-3 col">
                                {{-- <select name="budget" class="form-control" id="inputGroupSelect01" aria-describedby="button-addon1">
                                    <option value="all">All (Budgets)</option>
                                    @foreach ($budgets as $budget)     
                                    <option value="{{$budget->id}}">{{$budget->description}}</option>
                                    @endforeach
                                </select> --}}
                                <input name="daterange_c" class="form-control" id="range" type="text" placeholder="choose range" />
                            </div>
                            <div>
                                <p class="" id="small"></p>
                            </div>
                            <div class="input-group mb-3 col">
                                <button type="submit" id="ch" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Trial Report
                    </div>
                    <div class="card-body">
                        <form action="{{route('create_pdf_trial_range')}}" method="post">
                            @csrf
                            <div class="input-group mb-3 col">
                                {{-- <select name="budget" class="form-control" id="inputGroupSelect01" aria-describedby="button-addon1">
                                    <option value="all">All (Budgets)</option>
                                    @foreach ($budgets as $budget)     
                                    <option value="{{$budget->id}}">{{$budget->description}}</option>
                                    @endforeach
                                </select> --}}
                                <input name="daterange_r" class="form-control" id="range" type="text" placeholder="choose range" />
                            </div>
                            <div>
                                <p class="" id="small2"></p>
                            </div>
                            <div class="input-group mb-3 col">
                                <button type="submit" id="ch" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        

    </div>
@endsection

@section('script')
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
 <script src="js/datatables-demo.js"></script>   
<script>
// $(function() {
//   $('input[name="daterange"]').daterangepicker({
//     opens: ''
//   }, function(start, end, label) {
//     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
//   });
// });

$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb1(start, end) {
        $('#small').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }
    function cb2(start, end) {
        $('#small2').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }

    $('input[name="daterange_c"]' || ' ').daterangepicker({
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
    }, cb1);

    $('input[name="daterange_r"]' || ' ').daterangepicker({
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
    }, cb2);


    cb1(start, end);
    cb2(start, end);

});
</script>

@endsection

