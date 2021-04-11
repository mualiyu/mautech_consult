@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Voucher</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vouchers</li>
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
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"><i class="">+</i> Create New voucher</button>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive" style="overflow-x:hidden;">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($vouchers as $voucher)    
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
                                                <td>{{$voucher->totalamount}}</td>
                                                <td>{{$voucher->created_at}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            
                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Add Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{route('create_payments')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="small mb-1" for="beneficiary">Beneficiary</label>
                                                <select name="beneficiary" class="form-control" id="beneficiary" aria-describedby="nameHelp" placeholder="Select" >
                                                    @foreach ($beneficiaries as $beneficiary)
                                                    <option value="{{$beneficiary->id}}">{{$beneficiary->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="amount">Amount</label>
                                                <input name="amount" class="form-control py-4" id="amount" type="number" aria-describedby="nameHelp" placeholder="Enter Amount" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="description">Description</label>
                                                <textarea name="description" class="form-control py-4" id="description" aria-describedby="nameHelp" placeholder="Enter Description" ></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="tax">Tax (Optional)</label>
                                                <select name="tax" class="form-control" id="tax" aria-describedby="nameHelp" placeholder="Select" >
                                                   <option value="">None</option>
                                                    @foreach ($taxes as $tax)
                                                    <option value="{{$tax->id}}">{{$tax->type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input name="submit" class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Add to cache" />
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
@endsection