@extends('layouts.index')

@section('style')
    <style type="text/css">
        #up_table
        {
            border: 1px solid black;
            border-collapse: collapse;
        }
        #up_table td
        {
            padding: 3px;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Incomes</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Incomes</li>
                        </ol>
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $message ?? '' }}
                        </div>
                        @endif
                        
                        @if (session('errors'))
                        <div class="alert alert-warning" role="alert">
                            {{ $errors }}
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
				</div>
				<div class="col-3">
					<button class="btn btn-success"  data-toggle="modal" data-target="#staticBackdrop"><i class="">^</i> Upload</button>
					&nbsp;&nbsp;
                                        <a href="{{ route('show_add_income') }}" class="btn btn-primary" ><i class="">+</i> Add Income</a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Name of Payer</th>
                                                <th>Reference No. <small>(RRR)</small></th>
						<th>Net Amount</th>
						<th>Purpose <small>(Service Type)</small></th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name of Payer</th>
                                                <th>Reference No. <small>(RRR)</small></th>
						<th>Net Amount</th>
						<th>Purpose <small>(Service Type)</small></th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($incomes as $income)    
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" data-toggle="dropdown">{{$income->payer}}</a>
                                                </td>
                                                <td>{{$income->ref_num}}</td>
						<td>{{number_format($income->amount/100, 2)}}</td>
						<td>{{$income->type}}</td>
                                                <?php $due = explode(' ', $income->created_at); $date = explode('-', $due[0]); $inc_d = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                                                <td>{{$inc_d}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                                 <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl modal-scrollable">
                                    <div class="modal-content">
                                      <div class="modal-header">Upload  <strong> CSV </strong>  file</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{route('upload_income_csv')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input name="file" class="form-control" required onchange="Upload()" accept=".csv" id="fileUpload" type="file" placeholder="choose file" />
                                                <div class="input-group-prepend">
                                                  <input name="submit" class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Upload" />
                                                </div>
                                            </div>
                                            <br><br>

                                            <div class="row">
                                                <div id="dvCSV" class="table-responsive">

                                                </div>
                                            </div>
                                            
                                        </form>
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
 
    <script type="text/javascript">
        function Upload() {
            var fileUpload = document.getElementById("fileUpload");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var table = document.createElement("table");
                        table.setAttribute("class", "table table-bordered");
                        var rows = e.target.result.split("\n");
                        for (var i = 3; i < rows.length; i++) {
                            var cells = rows[i].split(",");
                            if (cells.length > 1) {
                                var row = table.insertRow(-1);
                                for (var j = 0; j < cells.length; j++) {
                                    var cell = row.insertCell(-1);
                                    cell.innerHTML = cells[j];
                                }
                            }
                        }
                        var dvCSV = document.getElementById("dvCSV");
                        dvCSV.innerHTML = "";
                        dvCSV.appendChild(table);
                    }
                    reader.readAsText(fileUpload.files[0]);
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        }
    </script>
@endsection
