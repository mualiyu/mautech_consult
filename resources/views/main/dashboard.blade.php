@extends('layouts.index')

@section('content')
<div class="container-fluid">
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ $message}}
        </div>
    @endif
    @if (session('erro'))
        <div class="alert alert-warning" role="alert">
            {{ $error}}
        </div>
    @endif
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active"></li>
    </ol>
<div class="row">
  <div class="col-md-6 col-sm-6">
    <div class="card mb-4">
	<div class="card-body">
	    <h2>Mandates Record</h2>
		<ul> 
		<li><b>Date, Mandate, Pvno, Amount: </b></li><br>
		@foreach($mandates as $mandate)
 			<?php $beneficiary = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $mandate->beneficiary_id)->get() ?>
                        <?php $voucher = \App\Voucher::find($mandate->voucher_id) ?>
                        <?php $payment = \App\Payment::find($mandate->payment_id) ?>
 			<?php $due = explode(' ', $payment->duedate); $date = explode('-', $due[0]); $duedate = $date[2].'/'.$date[1].'/'.$date[0]; ?>

			<li>{{$duedate}}, {{$mandate->mandateno}}, {{$voucher->pvno}}, NGN{{number_format($voucher->totalamount)}}  </li>
		@endforeach
		</ul>

	</div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6">
    <div class="card md-4">
	<div class="card-body">
	        <h2>Payment History</h2>
		<ul>
		<li><b>Date, Voucher, Beneficiary, Description, Payment Amount: </b></li><br>
		@foreach($payments as $payment)
			<?php $beneficiaries = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $payment->beneficiary_id)->get() ?>
			<?php $beneficiary = App\Beneficiary::find($payment->baneficiary_id); ?>
			<?php $due = explode(' ', $payment->duedate); $date = explode('-', $due[0]); $duedate = $date[2].'/'.$date[1].'/'.$date[0]; ?>
			<?php $voucher = \App\Voucher::find($payment->voucher_id) ?>

			<li>{{$duedate}}, {{$voucher->pvno}}, 
                @foreach($beneficiaries as $ben)
                {{$ben->name}},
                @endforeach
            {{$payment->description}}, NGN{{number_format($payment->amount)}} </li>
		@endforeach
		</ul>
	</div>
    </div>
  </div>
    <div style="height: 100vh;"></div>
   
</div>
@endsection
