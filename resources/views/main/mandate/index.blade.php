@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Mandate</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">mandate</li>
                        </ol>
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
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-2"></div>
                                    <div class="col-3">
                                        <a href="{{ route('show_add_beneficiary') }}" class="btn btn-primary" ><i class="">+</i> Create Mandate</a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x:hidden;">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Mandate No</th>
                                                <th>Code</th>
                                                <th>Account</th>
                                                <th>Bank</th>
                                                <th>Tin</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Code</th>
                                                <th>Account</th>
                                                <th>Bank</th>
                                                <th>Tin</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($beneficiaries as $beneficiary)    
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$beneficiary->name}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$beneficiary->name}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_edit_beneficiary', ['id'=>$beneficiary->id])}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit Beneficiary</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_ben', ['id'=>$beneficiary->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="Ben_id" value="{{$beneficiary->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Beneficiary</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>{{$beneficiary->code}}</td>
                                                <td>{{$beneficiary->account}}</td>
                                                <td>{{$beneficiary->bank}}</td>
                                                <td>{{$beneficiary->tin}}</td>
                                                <td>{{$beneficiary->created_at}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
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