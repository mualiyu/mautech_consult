@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">voucher-{{$voucher->pvno}} Payments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments of {{$voucher->pvno}}</li>
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
                                        <a href="{{route('vouchers')}}" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</a>
                                        <br><br>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    </div>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Beneficiary</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>voucher</th>
                                                <th>Tax Percent<small>(%)</small></th>
                                                <th>Budget</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        
                                        @if ($payments)
                                            
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($payments as $payment)    
                                            <tr>
                                                <td>
                                                    {{-- {{ $beneficiary = \App\Beneficiary::find($payment->beneficiary_id) }} --}}
                                                    <?php $beneficiary = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $payment->beneficiary_id)->get() ?>
                                                    <?php $voucher = \App\Voucher::find($payment->voucher_id) ?>
                                                    <?php $budget = \App\Budget::find($payment->budget_id) ?>
                                                    

                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                        @foreach ($beneficiary as $item)
                                                            {{$item->name}}
                                                        @endforeach
                                                    </a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$payment->id}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_payment', ['id'=>$payment->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$payment->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Payment</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>NGN <span id="amount[<?= $i; ?>]">{{number_format($payment->amount/100, 2)}}</span></td>
                                                <td>{{$payment->description}}</td>
                                                <td>{{$voucher->pvno}}</td>
                                                <td>{{$payment->tax_percent ?? '0'}}%</td>
                                                <td>{{$budget->description ?? 'none'}}</td>
                                                <?php $due = explode(' ', $payment->created_at); $date = explode('-', $due[0]); $duedate = $date[2].'/'.$date[1].'/'.$date[0]; ?>
                                                <td>{{$duedate}}</td>
                                            </tr>
                                            
                                            {{-- <script>
                                            //     function numberWithCommas'<?= $i?>'(x) {
                                            //        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            //        }
                                               
                                            //     document.getElementById('amount[<?= $i ?>]').innerHTML=numberWithCommas'<?= $i?>'($("#amount[<?= $i ?>]").text());
                                            // //    $(document).ready( function () {
                                            // //    });
                                                </script> --}}
                                                <?php $i++; ?>  
                                            @endforeach
                                            
                                        </tbody>
                                        @else
                                        <tbody>
                                            <b>No payment</b>
                                        </tbody>
                                        @endif
                                    </table><br>
                                    @if($is_approved)
                                    <div class="row">
                                        <div class="col-3"></div>
                                        <div class="col-3"></div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <a href="{{route('create_pdf_voucher', ['id'=> $voucher->id])}}" target="_blank" class="btn btn-primary"> Print Voucher</a>
                                        </div>
                                    </div>
                                    @endif
                            
                            </div>
                        </div>
                    </div>
@endsection

@section('script')
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
 <script src="js/datatables-demo.js"></script> 
 <script>
    // function numberWithCommas(x) {
    //    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //    }
   
//    $(document).ready( function () {
//        for (let i = 0; i < {<?= $i?>}; i++) {
//         //    const element = array[i];
//             document.getElementById('amount[i]').innerHTML=numberWithCommas($("#amount[i]").text());
//        }
//    });
    </script>  
@endsection
