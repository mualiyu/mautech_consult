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
                Reports Center
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
        @if ($budget_reports)
        <div class="card mb-4">
            <div class="card-header">
                Report for <b>All</b> Budgets from <b>{{date('j M, Y', strtotime($date_range[0]))}}</b> to <b>{{date('j M, Y', strtotime($date_range[1]))}}</b>.
            </div>
            <div class="card-body">
                <div class="table-responsive" style="">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Budget</th>
                                <th>Budget Amount</th>
                                <th>Expenditure Amount</th>
                                <th>Trial balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budget_reports as $b)    
                            <tr>
                                <td>{{$b[0]}}</td>
                                <td>NGN{{number_format($b[1]/100, 2)}}</td>
                                <td>NGN{{number_format($b[2]/100, 2)}}</td>
                                <td>NGN{{number_format($b[3]/100, 2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- <tbody>
                            <b>No payment</b>
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection

@section('script')
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
 <script src="js/datatables-demo.js"></script>   
@endsection
