@extends('layouts.index')

@section('content')
<div class="container-fluid">
    @if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ $message}}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-warning" role="alert">
        {{ $error}}
    </div>
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
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-6 col-sm-3">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Budgets</h3></div>
                <div class="card-body">
                    <form method="post" action="{{route('create_bud')}}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="name">Type<small>(Of budget)</small></label>
                            <input name="description" class="form-control py-4" id="name" type="text" aria-describedby="nameHelp" placeholder="Enter Name" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="code">Account Code</label>
                                    <input name="account_code" class="form-control py-4" id="code" type="text" placeholder="Enter Account Code" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="amount">Amount</label>
                                    <input name="amount" class="form-control py-4" id="amount" type="text" placeholder="Enter amount" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" name="submit">Create Budget</button></div>
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