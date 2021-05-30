@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Mandate's</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">mandate</li>
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
                                    <div class="col-2"></div>
                                    <div class="col-3">
                                        <a href="{{ route('show_create_mandate') }}" class="btn btn-primary" ><i class="">+</i> Create Mandate</a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x:hidden;">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Mandate No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Mandate No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($mandates as $mandateno)  
                                            <?php 
                                                $mandate = \App\Mandate::where('mandateno', '=', $mandateno)->get();
                                                $amount_r = [];
                                                foreach ($mandate as $m) {
                                                    $p = $m->payment_id;
                                                    $payment = \App\Payment::where('id', '=', $p)->get();
                                                    // dd($payment[0]->amount);
                                                    array_push($amount_r, $payment[0]->amount);
                                                }
                                                $amount = 0; 
                                                for ($i=0; $i < count($amount_r); $i++) { 
                                                    $amount = $amount + $amount_r[$i];
                                                }

                                                $man_no = explode('/', $mandateno);
                                                
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$mandateno}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$mandateno}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_single_mandate', ['id'=>$man_no[2].'-'.$man_no[3]])}}" class="btn btn-success"><i class="fas fa-edit"></i> Open Mandate</a></li>
                                                </td>
                                                <td>N{{$amount}}</td>
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