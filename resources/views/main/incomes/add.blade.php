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
    <br>
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
        </div>
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-3 col-sm-3"></div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-6 col-sm-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Add Income</h3></div>
                <div class="card-body">
                    <form method="post" action="{{route('create_income')}}">
                        @csrf
			<div class="form-row">
			    <div class="col-md-12">
				    <div class="form-group">
					<label class="small mb-1" for="payer">Name of Payer</label>
					<input name="payer" class="form-control py-4" id="payer" type="text" placeholder="Enter Payer's Name" />
				    </div>
			    </div>
			</div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="ref_num">Reference No.</label>
                                    <input name="ref_num" class="form-control py-4" id="ref_num" type="text" placeholder="Enter Reference No." />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="amount">Amount</label>
                                    <input name="amount" class="form-control py-4" id="amount" type="number" step="any" placeholder="Enter Amount" />
                                </div>
                            </div>
                        </div>
			<div class="form-row">
			    <div class="col-md-12">
				    <div class="form-group">
					<label class="small mb-1" for="type">Purpose <small>(Service Type)</small></label>
					<input name="type" class="form-control py-4" id="type" type="text" placeholder="Enter Type" />
				    </div>
			    </div>
			</div>
                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" name="submit">Add to Income</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3"></div>
    </div>

</div>
@endsection

@section('script')

@endsection
