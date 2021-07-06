@extends('layouts.index')

@section('content')
    <div class="container-fluid">
                        <h1 class="mt-4">Voucher</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vouchers</li>
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
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <a href="{{route('show_create_voucher')}}" class="btn btn-primary" ><i class="">+</i> Create New voucher</a>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive" style="">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                                @if(Auth::user()->isDirector())
                                                <th>Action</th>
                                                @else
                                                <th>Status</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>PvNo</th>
                                                <th>Amount</th>
                                                <th>Created_at</th>
                                                @if(Auth::user()->isDirector())
                                                <th>Action</th>
                                                @else
                                                <th>Status</th>
                                                @endif
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($vouchers as $voucher)   
                                                 <?php  $approve = App\Payment::where('voucher_id', '=', $voucher->id)->first();
                                                        $is_approved = $approve->approve;
                                                 ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$voucher->pvno}}</a>
                                                        <ul class="dropdown-menu">
                                                            <li align="center"><b>{{$voucher->pvno}}</b></li>
                                                            <hr>
                                                            <li style="margin-left: 6px;"><a href="{{route('show_single_voucher', ['id'=>$voucher->id])}}" class="btn btn-success"> Open Voucher</a></li>
                                                            <li style="margin-left: 6px;">
                                                                <form method="post" action="{{route('delete_voucher', ['id'=>$voucher->id])}}">
                                                                    @csrf
                                                                    <input type="hidden" name="tax_id" value="{{$voucher->id}}">
                                                                <button href="#" class="btn btn-warning">Delete Voucher</button>
                                                                </form>
                                                              </li>
                                                        </ul>
                                                </td>
                                                <td id="amount">{{$voucher->totalamount}}</td>
                                                 <?php $due = explode(' ', $voucher->created_at); $date = explode('-', $due[0]); $vou_date = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                                                <td>{{$vou_date}}</td>
                                                @if(Auth::user()->isDirector())
                                                    @if ($is_approved)
                                                        <td><button class="btn btn-secondary" disabled>Approved</button></td>
                                                    @else
                                                    <td>
                                                        <form action="{{route('update_payment', ['id'=>$voucher->id])}}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-success" type="submit">Approve</button>
                                                        </form>
                                                    </td>
                                                    @endif
                                                @else 
                                                    @if ($is_approved)
                                                        <td><button class="btn btn-secondary" disabled>Approved</button></td>
                                                    @else
                                                        <td><button class="btn btn-danger" disabled>Not Approved</button></td>
                                                    @endif
                                                @endif
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
 
 {{-- <script>
     function convertNumberToWords(amount) {
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    return words_string;
}
$(document).ready( function () {
  document.getElementById('amount').innerHTML=convertNumberToWords($("#amount").text());
});
 </script> --}}
@endsection
