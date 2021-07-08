@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Voucher</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vouchers</li>
                        </ol>
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $message ?? '' }}
                        </div>
                        @endif
                        
                        @if (session('errors'))
                        <div class="alert alert-warning" role="alert">
                            {{ $errors }}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <a href="{{route('show_create_voucher')}}" class="btn btn-primary" ><i class="">+</i> Create New voucher</a>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive" style="">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                                @if(Auth::user()->isDirector())
                                                <th>Action</th>
                                                @else
                                                <th>Status</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                                @if(Auth::user()->isDirector())
                                                <th>Action</th>
                                                @else
                                                <th>Status</th>
                                                @endif
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($vouchers as $voucher)   
                                                 <?php  $approve = App\Payment::where('voucher_id', '=', $voucher->id)->first();
                                                       if ($approve) {
                                                           $is_approved = $approve->approve;
                                                       }else{
                                                        $is_approved = 0;
                                                       }
                                                 ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$voucher->pvno}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$voucher->pvno}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_single_voucher', ['id'=>$voucher->id])}}" class="btn btn-success"> Open Voucher</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_voucher', ['id'=>$voucher->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$voucher->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Voucher</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td >NGN<span id="amount"> {{number_format($voucher->totalamount)}}</span></td>
                                                 <?php $due = explode(' ', $voucher->created_at); $date = explode('-', $due[0]); $vou_date = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                                                <td>{{$vou_date}}</td>
                                                @if(Auth::user()->isDirector())
                                                    @if ($is_approved)
                                                        <td><button class="btn btn-secondary" disabled>Approved</button></td>
                                                    @else
                                                    <td>
                                                        <form action="{{route('update_payment', ['id'=>$voucher->id])}}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-success" type="submit">Approve</button>
                                                        </form>
                                                    </td>
                                                    @endif
                                                @else 
                                                    @if ($is_approved)
                                                        <td><button class="btn btn-secondary" disabled>Approved</button></td>
                                                    @else
                                                        <td><button class="btn btn-danger" disabled>Not Approved</button></td>
                                                    @endif
                                                @endif
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
 
 <script>
 function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

$(document).ready( function () {
 document.getElementById('amount').innerHTML=numberWithCommas($("#amount").text());
});
 </script>
@endsection
