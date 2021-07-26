@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Budgets</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">budgets</li>
                        </ol>
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $message ?? ''}}
                        </div>
                        @endif
                        @if (session('erro'))
                        <div class="alert alert-warning" role="alert">
                            {{ $error}}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <a href="{{ route('show_add_budget') }}" class="btn btn-primary" ><i class="">+</i> Add Budget</a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Account Code</th>
                                                <th>Amount</th>
						                        <th>Date</th>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Type</th>
                                                <th>Account Code</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($budgets as $budget)    
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$budget->description}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$budget->description}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_edit_budget', ['id'=>$budget->id])}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit Budget</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_bud', ['id'=>$budget->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="Ben_id" value="{{$budget->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Budget</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>{{$budget->account_code}}</td>
                                                <td>NGN {{number_format($budget->amount/100, 2)}}</td>
                                                <?php $due = explode(' ', $budget->created_at); $date = explode('-', $due[0]); $bud_date = $date[1].'/'.$date[1].'/'.$date[0]; ?>
                                                <td>{{$bud_date}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
@endsection

@section('script')
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
 <script src="js/datatables-demo.js"></script>   
@endsection
