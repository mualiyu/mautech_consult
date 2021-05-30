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
        <div class="col-3">
            <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
        </div>
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-3"></div>
    </div><br>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Tax</h3></div>
                <div class="card-body">
                    <form method="post" action="{{route('create_tax')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="type">Type</label>
                                    <input name="type" class="form-control py-4" id="type" type="text" placeholder="Enter Type of Tax" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="pacentage">Percentage(%)</label>
                                    <input name="percentage" class="form-control py-4" id="percentage" type="number" step="any" placeholder="Enter Percentage" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" name="submit">Create Tax</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

</div>
@endsection

@section('script')

@endsection