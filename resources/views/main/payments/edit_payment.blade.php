@extends('layouts.index')

@section('content')

<div class="container-fluid">
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
    
    <?php $ben = \Illuminate\Support\Facades\DB::table('beneficiaries')->where('id','=', $payment->beneficiary_id)->get() ?>
    <?php $voucher = \Illuminate\Support\Facades\DB::table('vouchers')->where('id','=', $payment->voucher_id)->get() ?> 
    @if ($payment->tax_id == 0)
        <?php $tax = "" ?>
    @else
        <?php $tax = \App\Tax::find($payment->tax_id) ?>
    @endif
    <br>
    <div class="row">
        <div class="col-3">
            <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
        </div>
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Payment</h3>
                    @foreach ($voucher as $item)
                        <h4 class="small mb-1" for="tin">Voucher-{{$item->pvno}}</h4>
                    @endforeach
                </div>
                <div class="card-body">    

                    <form method="post" action="{{route('update_payment', ['id'=>$payment->id])}}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="name">Beneficiary</label>
                            <select name="beneficiary" class="form-control" id="beneficiary" aria-describedby="nameHelp" placeholder="Select" >
                                @foreach ($ben as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                <hr>
                                <br>
                                @foreach ($beneficiaries as $beneficiary)
                                <option value="{{$beneficiary->id}}">{{$beneficiary->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="code">Amount</label>
                                    <input name="code" value="{{$payment->amount}}" class="form-control py-4" id="code" type="text" placeholder="Enter Code" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="account">Description</label>
                                    <input name="account" value="{{$payment->description}}" class="form-control py-4" id="account" type="text" placeholder="Enter Acount" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="bank">Tax</label>
                                    <select name="tax" class="form-control" id="tax" aria-describedby="nameHelp" placeholder="Select" >
                                        <option value="">{{$tax->type ?? 'none'}}</option>
                                        @foreach ($taxes as $item)
                                            <option value="{{$item->id}}">{{$item->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" name="submit">Edit Payment</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

</div>
@endsection
