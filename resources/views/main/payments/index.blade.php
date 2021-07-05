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
                        
                        @if (session('errors'))
                        <div class="alert alert-warning" role="alert">
                            {{ $errors }}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body">
                               <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-success" style="float: left;" data-toggle="modal" data-target="#staticBackdrop"> Select Range</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('create_pdf_cashbook') }}" style="float: left" class="btn btn-primary" >Generate Cash book</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="">

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
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_payment', ['id'=>$payment->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$payment->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Payment</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>N{{$payment->amount}}</td>
                                                <td>{{$payment->description}}</td>
                                                <td>{{$voucher->pvno}}</td>
                                                <td>{{$tax->type ?? 'Null'}}</td>
                                                <?php $due = explode(' ', $payment->created_at); $date = explode('-', $due[0]); $duedate = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                                                <td>{{$duedate ?? "Null"}}</td>
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
                            
                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Generate Cashbook</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{route('create_pdf_cashbook_range')}}" method="POST">
                                            @csrf
                                            
                                            <div class="form-group" id="kk">
                                                {{-- <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <input type="text" id="range" name="range" value=""> <i class="fa fa-caret-down"></i>
                                                </div> --}}
                                                <label class="small mb-1" for="range">Date Range:</label><br>
                                                <input name="daterange" class="form-control" id="range" type="text" placeholder="choose range" />
                                                <small class=""></small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <input name="submit" class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Generate" />
                                            </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                      </div>
                                    </div>
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
</script>>

@endsection
