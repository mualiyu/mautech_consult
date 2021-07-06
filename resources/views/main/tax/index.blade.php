 @extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Taxes</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tax</li>
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
                                        <a href="{{ route('show_add_tax') }}" class="btn btn-primary" ><i class="">+</i> Add Tax</a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Percentage(%)</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Type</th>
                                                <th>Percentage(%)</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($taxes as $tax)    
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$tax->type}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$tax->type}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_edit_tax', ['id'=>$tax->id])}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit Tax</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_tax', ['id'=>$tax->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$tax->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Tax</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td>{{$tax->percentage}}</td>
                                                <?php $due = explode(' ', $tax->created_at); $date = explode('-', $due[0]); $tax_t = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                                                <td>{{$tax_t}}</td>
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
