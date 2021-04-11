@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Payments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments</li>
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
                                
                                <div class="table-responsive" style="overflow-x:hidden;">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Beneficiary</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>voucher</th>
                                                <th>Tax</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Beneficiary</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>voucher</th>
                                                <th>Tax</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </tfoot>
                                        @if ($payments)
                                            
                                        <tbody>
                                            @foreach ($payments as $payment)    
                                            <tr>
                                                <td><?php $beneficiary = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $payment->beneficiary_id)->get() ?>
                                                    <?php $voucher = \App\Voucher::find($payment->voucher_id) ?>
                                                    @if ($payment->tax_id == 0)
                                                        <?php $tax = "None" ?>
                                                    @else
                                                        <?php $tax = \App\Tax::find($payment->tax_id) ?>
                                                    @endif

                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> 
                                                        @foreach ($beneficiary as $item)
                                                        {{$item->name}}
                                                        @endforeach
                                                    </a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$payment->id}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_edit_payment', ['id'=>$payment->id])}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit Tax</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_payment', ['id'=>$payment->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$payment->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Tax</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>{{$payment->amount}}</td>
                                                <td>{{$payment->description}}</td>
                                                <td>{{$voucher->pvno}}</td>
                                                <td>{{$tax->type ?? 'Null'}}</td>
                                                <td>{{$payment->duedate}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        @else
                                        <tbody>
                                            <b>No payment</b>
                                        </tbody>
                                        @endif
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