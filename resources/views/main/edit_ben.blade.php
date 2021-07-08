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
    <br>
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
        </div>
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-3 col-sm-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-6 col-sm-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Beneficiary</h3></div>
                <div class="card-body">    
                    <form method="post" action="{{route('update_ben', ['id'=>$beneficiary->id])}}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="name">Name</label>
                            <input name="name" value="{{$beneficiary->name}}" class="form-control py-4" id="name" type="name" aria-describedby="nameHelp" placeholder="Enter Name" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="code">Code</label>
                                    <input name="code" value="{{$beneficiary->code}}" class="form-control py-4" id="code" type="text" placeholder="Enter Code" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="account">Account</label>
                                    <input name="account" value="{{$beneficiary->account}}" class="form-control py-4" id="account" type="text" placeholder="Enter Acount" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="bank">Bank</label>
                                    <input name="bank" value="{{$beneficiary->bank}}" class="form-control py-4" id="bank" type="text" placeholder="Enter Bank" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="tin">Tin</label>
                                    <input name="tin" value="{{$beneficiary->tin}}" class="form-control py-4" id="tin" type="text" placeholder="Enter Tin" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="small mb-1" for="tag">Tag</label>
                                    <input name="tag" value="{{$beneficiary->tag}}" class="form-control py-4" id="tag" type="text" placeholder="Enter Tag" />
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" name="submit">Edit Beneficiary</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3"></div>
    </div>

</div>
@endsection
