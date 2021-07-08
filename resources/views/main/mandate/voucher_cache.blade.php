@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Create/Cache Mandate</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Mandate</li>
                        </ol>
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $messages ?? '' }}
                        </div>
                        @endif
                        
                        @if (session('errors'))
                        <div class="alert alert-warning" role="alert">
                            {{ $errors }}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body" style="width: 100%;">
                                <div class="row">
                                    <br>
                                    <div class="col-3">
                                        <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop"><i class="">+</i> Generate New Mandate</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive" style="">
                                    @if ($mandates)
                                        
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>PV</th>
                                                <th>BENEFICIARY</th>
                                                <th>DATE</th>
                                                <th>ACCOUNT</th>
                                                <th>DETAILS</th>
                                                <th>AMOUNT</th>
                                            </tr>
                                        </thead>
                                        
					<tbody>
					@if($mandates['voucher'])
                                        @foreach ($mandates["voucher"] as $id)
                                        <?php $voucher = Illuminate\Support\Facades\DB::table('vouchers')->where('id','=', (int)$id)->get();?>
                                        <?php $payments = Illuminate\Support\Facades\DB::table('payments')->where('voucher_id','=', (int)$id)->get(); ?>
                                            @foreach ($payments as $payment)
                                                <?php $beneficiary = Illuminate\Support\Facades\DB::table('beneficiaries')->where('id','=', $payment->beneficiary_id)->get();?>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle">{{$voucher[0]->pvno}}</a>

                                                </td>
                                                <td>{{$beneficiary[0]->name}}</td>
                                                <td>{{$payment->duedate}}</td>
                                                <td>{{$beneficiary[0]->account}}</td>
                                                <td>{{$payment->description}}</td>
                                                <td>NGN {{number_format($payment->amount)}}</td>
                                            </tr>
                                            @endforeach    
					    @endforeach
					    @endif
                                            
                                        </tbody>
                                    </table>
                                    <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <form action="{{route('store_mandate')}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary"> Apply & Create Mandate</button>
                                        </form>
                                    </div>
                                    <div class="col-3">
                                        <form action="{{route('delete_local_mandate')}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning"> Delete Mandate</button>
                                        </form>
                                    </div>
                                    
                                </div>
                                    @else
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4">
                                            <h3>No Mandate Record In Cache</h3>
                                        </div>
                                        <div class="col-4"></div>
                                    </div>
                                    @endif
                                </div>
                            
                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Select Voucher(s)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if (!count($vouchers) > 0)    
                                        <div class="alert alert-warning" role="alert">
                                              <span>{{!count($vouchers) > 0 ? 'Please make sure your Vouchers is registerd!' : ''}}</span>
                                        </div>
                                        @endif
                                        <form action="{{route('create_cache_mandate')}}" method="POST">
                                            @csrf
                                                @foreach ($vouchers as $voucher)
                                                <div class="form-check">
                                                  <input type="checkbox" class="form-check-input" name="voucher[]" value="{{$voucher->id}}" id="ii{{$voucher->id}}">
                                                  <label class="form-check-label" for="ii{{$voucher->id}}">{{$voucher->pvno}}</label>
                                                </div>
                                                @endforeach
                                            <div class="form-group">
                                                <input name="submit" {{!count($vouchers) > 0 ? 'disabled' : ''}} class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Add to cache" />
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
     function validateVoucher() {
         var checkboxes = document.getElementsByName('voucher');
         var numOfChecked = 0;

         for (let i = 0; i < checkboxes.length; i++) {
             if (checkBoxes[i].checked) {
                 numOfChecked++;
             }
             
         }
     }
 </script>
@endsection
