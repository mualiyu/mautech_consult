@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Mandate No:- {{$mandateno}}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mandate No {{$mandateno}}</li>
                        </ol>
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $message ?? '' }}
                        </div>
                        @endif
                        
                        @if (session('error'))
                        <div class="alert alert-warning" role="alert">
                            {{ $error }}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body">
                                
                                <div class="table-responsive" style="">
                                    <div class="row">
                                    <div class="col-3">
                                        <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
                                        <br><br>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    </div>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>BENEFICIARY</th>
                                                <th>AMOUNT</th>
                                                <th>DUE DATE</th>
                                                <th>CODE</th>
                                                <th>ACCOUNT</th>
                                                <th>BANK</th>
                                                <th>PURPOSE</th>
                                            </tr>
                                        </thead>
                                        
                                        @if ($mandates)
                                            
                                        <tbody>
                                            @foreach ($mandates as $mandate)    
                                            <tr>
                                                <td>
                                                    {{-- {{ $beneficiary = \App\Beneficiary::find($payment->beneficiary_id) }} --}}
                                                    <?php $beneficiary = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $mandate->beneficiary_id)->get() ?>
                                                    <?php $voucher = \App\Voucher::find($mandate->voucher_id) ?>
                                                    <?php $payment = \App\Payment::find($mandate->payment_id) ?>
                                                    

                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                        @foreach ($beneficiary as $item)
                                                            {{$item->name}}
                                                        @endforeach
                                                    </a>
                                                        
                                                </td>
                                                <td>NGN {{number_format($payment->amount/100, 2)}}</td>
                                                <?php $due = explode(' ', $payment->duedate); $date = explode('-', $due[0]); $duedate = $date[2].'/'.$date[1].'/'.$date[0]; ?>
                                                <td>{{$duedate}}</td>
                                                <td>{{$beneficiary[0]->code}}</td>
                                                <td>{{$beneficiary[0]->account}}</td>
                                                <td>{{$beneficiary[0]->bank}}</td>
                                                <td>{{$payment->description}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        @else
                                        <tbody>
                                            <b>No payment</b>
                                        </tbody>
                                        @endif
                                    </table>
                                    <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <a href="{{route('create_pdf_mandate', ['id'=>$i_d])}}" target="_blank" class="btn btn-primary"> Print Mandate</a>
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
@endsection
