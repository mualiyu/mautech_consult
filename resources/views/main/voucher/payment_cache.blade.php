@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Create/Cache Voucher</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Voucher</li>
                        </ol>
                        @if (session('messages'))
                        <div class="alert alert-success" role="alert">
                            {{ $messages ?? '' }}
                        </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-warning">
                                <ul>
                                    <li>{{ $errors }}</li>
                                </ul>
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
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop"><i class="">+</i> Add Payment  to Voucher</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive" style="">
                                    @if ($payment)
                                        
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Beneficiary</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Tax percent<small>(%)</small></th>
                                                <th>Budget</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($payment->payments as $payment)    
                                            <tr>
                                                <?php $beneficiary = \App\Beneficiary::find($payment['data']['beneficiary']) ?>
                                                {{--  $tax = \App\Tax::find($payment['data']['tax']) ?--}}
                                                <?php $budget = \App\Budget::find($payment['data']['budget']) ?>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$beneficiary->name}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$beneficiary->name.'/'.$payment['data']['beneficiary']}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_payment_from_local', ['id'=>$payment['data']['beneficiary']])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$payment['data']['beneficiary']}}">
                                                                <button href="#" class="btn btn-warning">Delete beneficiary payment</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>NGN {{number_format($payment['data']['amount'], 2)}}</td>
                                                <td>{{$payment['data']['description']}}</td>
                                                <td>{{$payment['data']['tax_p'] ?? '0'}}%</td>
                                                <td>{{$budget->description}}</td>
                                                
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <form action="{{route('create_voucher_and_payments')}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary"> Apply & Create Voucher</button>
                                        </form>
                                    </div>
                                    
                                </div>
                                    @else
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4">
                                            <h3>No Payments Record saved</h3>
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
                                        <h5 class="modal-title" id="staticBackdropLabel">Add Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          @if (!count($beneficiaries) > 0)  
                                          <div class="alert alert-warning" role="alert">
                                              <span>{{!count($beneficiaries) > 0 ? 'Please make sure Beneficiary is registerd!' : ''}}</span>
                                          </div>
                                          @endif
                                        <form action="{{route('create_payments')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class=" mb-1" for="beneficiary">Beneficiary</label>
                                                <select name="beneficiary" required class="form-control" id="beneficiary" aria-describedby="nameHelp" placeholder="Select" >
                                                    @foreach ($beneficiaries as $beneficiary)
                                                    <option value="{{$beneficiary->id}}">{{$beneficiary->name}}</option>
                                                    @endforeach
                                                    @if (!count($beneficiaries) > 0)
                                                    <option>No data <small>(make sure you add beneficiary)</small></option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class=" mb-1" for="budget">Payment Type <small>Budget</small></label>
                                                <select name="budget" required class="form-control" id="budget" aria-describedby="nameHelp" placeholder="Select" >
                                                    @foreach ($budgets as $budget)
                                                    <option value="{{$budget->id}}">{{$budget->description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1" for="amount">Amount</label>
                                                <input name="amount" required class="form-control py-4" id="amount" type="number" step="any" aria-describedby="nameHelp" placeholder="Enter Amount" />
                                            </div>
                                            <div class="form-group">
                                                <label class=" mb-1" for="description">Description</label>
                                                <textarea name="description" required class="form-control py-4" id="description" aria-describedby="nameHelp" placeholder="Enter Description" ></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class=" mb-1" for="tax">Tax (Optional)</label>
                                                @foreach ($taxes as $tax)
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="tax[]" onchange="$('#nn_{{$tax->id}}').toggle()" type="checkbox" value="{{$tax->id}}" id="id_{{$tax->id}}">
                                                            <label class="form-check-label" style="font-size: 18px" for="id_{{$tax->id}}">
                                                            {{$tax->type}}<small>({{$tax->percentage}}%)</small>
                                                            </label>
                                                        </div>
                                                        <div class="form-group" id="nn_{{$tax->id}}" style="display: none; background:#d7d7d7;">
                                                            <label class=" mb-1" for="benTax"><small>Select Tax Beneficiary</small></label>
                                                            <select name="benTax[{{$tax->id}}]" class="input-group" id="benTax" placeholder="Select" >
                                                                {{-- <option value=''>None</option>
                                                                <hr> --}}
                                                                @foreach ($benTax as $ben)
                                                                <option value="{{$ben->id}}">{{$ben->name}}</option>
                                                                @endforeach
                                                                @if (!count($benTax) > 0)
                                                                <option>No data <small>(make sure you add a Tax beneficiary)</small></option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                @endforeach
                                            </div>

                                            <div class="form-group">
                                                <input name="submit"  {{!count($beneficiaries) > 0 ? 'disabled' : ''}} class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Add to cache" />
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
