<!DOCTYPE >
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>Untitled Spreadsheet</title>
	{{-- <link rel="stylesheet" href="{{asset('css/styles.css')}}"> --}}
	<style type="text/css">
    body{
        text-align: center;
        margin: 20px;
    }
		
		td{
            border: 1px solid black;
        }
	</style>
</head>
<body>
    <div class="container">

        <div class="table-responsive" style="overflow-x:hidden;">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                @if ($payments)
                <tbody>
                    <tr style="height:26.8pt;">
                        <td colspan="9" style="width:726.45pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:15pt;"><span style="font-family:'Liberation Serif';">MODIBBO ADAMA UNIVERSITY OF TECHNOLOGY, YOLA</span></p>
                        </td>
                    </tr>
                    <tr style="height:22.6pt;">
                        <td colspan="9" style="width:726.45pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Liberation Serif';">CONSULTANCY SERVICE UNIT</span></p>
                        </td>
                    </tr>
                     <tr>
                        <th  colspan="2">CASH BOOK</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                     <tr>
                        <th>DATE</th>
                        <th>MANDATE</th>
                        <th>BENEFICIARY</th>
                        <th>DETAILS</th>
                        <th>PV</th>
                        <th>AMOUNT</th>
                    </tr>
                    @foreach ($payments as $payment)    
                    <tr>
                        <td><?php $beneficiary = Illuminate\Support\Facades\DB::table("beneficiaries")->where('id','=', $payment->beneficiary_id)->get() ?>
                            <?php $voucher = \App\Voucher::find($payment->voucher_id) ?>
                            @if ($payment->tax_id == 0)
                                <?php $tax = "None" ?>
                            @else
                                <?php $tax = \App\Tax::find($payment->tax_id) ?>
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> 
                                @foreach ($beneficiary as $item)
                                {{$item->name}}
                                @endforeach
                            </a>
                                <ul class="dropdown-menu">
                                    <li align="center"><b>{{$payment->id}}</b></li>
                                    <hr>
                                    <li style="margin-left: 6px;"><a href="{{route('show_edit_payment', ['id'=>$payment->id])}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit Payment</a></li>
                                    <li style="margin-left: 6px;">
                                        <form method="post" action="{{route('delete_payment', ['id'=>$payment->id])}}">
                                            @csrf
                                            <input type="hidden" name="tax_id" value="{{$payment->id}}">
                                        <button href="#" class="btn btn-warning">Delete Payment</button>
                                        </form>
                                      </li>
                                </ul>
                        </td>
                        <td>N{{$payment->amount}}</td>
                        <td>{{$payment->description}}</td>
                        <td>{{$voucher->pvno}}</td>
                        <td>{{$tax->type ?? 'Null'}}</td>
                        <?php $due = explode(' ', $payment->duedate); $date = explode('-', $due[0]); $duedate = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                        <td>{{$duedate}}</td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <tbody>
                    <b>No payment</b>
                </tbody>
                @endif
            </table>
        </div>
    </div>
</body>

</html>
