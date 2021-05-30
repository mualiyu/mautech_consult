<head>
    <title>voucher_{{$voucher[0]->pvno}}</title>
    <style>
        td{
            border: 1px solid black;
        }
    </style>
</head>

<h2 style="text-align: center; margin:5px;"><strong>MAUTECH CONSULTANCY SERVICES</strong></h2>
<h4 style="text-align: center; margin:5px;"><strong>Modibbo adama university of technology, Yola</strong></h4>
<h3 style="text-align: center; margin:5px; margin-bottom:10px;"><span style="text-decoration: underline;">DOMESTIC PAYMENT VOUCHER</span></h3>
<p style="padding-left: ; text-align: center; margin:0;">P.V.No: <span style="text-decoration: underline">{{$voucher[0]->pvno}}</span> &nbsp;&nbsp;
    Date: <span style="text-decoration: underline">{{$voucher[0]->created_at}}</span></p>
    <?php $i=0; $payNo = $payments->count(); ?>
    <p style="padding-left: ; text-align: center; margin:5px">
        Payee: <span style="text-decoration: underline">
            @if ($payments->count() <= 3)
                @foreach ($payments as $payment)
                    <?php $beneficiary = Illuminate\Support\Facades\DB::table('beneficiaries')->where('id','=', $payment->beneficiary_id)->get(); ?>
                    {{$beneficiary[0]->name}}, 
                @endforeach
            @else
                @for($i=0; $i<3; $i++)
                    <?php $beneficiary = Illuminate\Support\Facades\DB::table('beneficiaries')->where('id','=', $payments[$i]->beneficiary_id)->get(); ?>
                 {{$beneficiary[0]->name}}, 
                @endfor
                    And Others
            @endif
        </span>
    </p>
    
<p style="padding-left: 30px; text-align: center; margin:5px;">Address: ________________________________&nbsp; Cheque No: ____________</p>
<p style="padding-left: 30px; text-align: center; margin:5px;">________________________________&nbsp; S.R.V/L.P.O No ________________</p>

<table style="width: 98%; height:; margin-left: 10px; border: solid black;" cellspacing="1">
<tbody>
<tr style="height: 33px;">
<td style="width: 25%; height: ; text-align: center;">&nbsp; DATE</td>
<td style="width: 50%; height: ; text-align: center;">&nbsp;Description of service</td>
<td style="width: 25%; text-align: left; height: ;">
<table style="height: ;" width="100%">
<tbody>
<tr>
<td style="width: 100%; text-align: center;">Amount</td>
</tr>
<tr>
<td style="width: 100%;">
<table style="height: 25px; width: 100%;">
<tbody>
<tr>
<td style="width: 65%; text-align: center;">N</td>
<td style="width: 35%; text-align: center;">k&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
@foreach ($payments as $payment)
<?php $beneficiary = Illuminate\Support\Facades\DB::table('beneficiaries')->where('id','=', $payment->beneficiary_id)->get(); ?>
<?php  $duedate = explode(' ', $payment->created_at)  ?>
<tr style="text-align: left; height: ;">
<td style="width: 25%; height:;">&nbsp; {{$duedate[0]}}</td>
<td style="width: 50%%; height: ;">
<p>&nbsp; {{$beneficiary[0]->name}}: {{$payment->description}}</p>
</td>
<td style="width: 50%; height: ;">
<table style="height: ; width: :">
<tbody>
<tr style="width: 100%;">
<td style="width: 65%;">&nbsp; {{$payment->amount}}</td>
<td style="width: 35%;">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>

@endforeach

<tr style="text-align: left; height: ;">
<td style="width: 74px; height:;" colspan="2">&nbsp; Total amount in words: 
    <span style="text-decoration: underline" id="txt"> {{$voucher[0]->totalamount}} </span>
    <input type="hidden" value="{{$voucher[0]->totalamount}}" name="" id="num">
</td>
<td style="width: 132.772px; height: ;">
&nbsp;&nbsp;&nbsp;<span style="font-size: 20px">N {{$voucher[0]->totalamount}}</span> 
</td>
</tr>
</tbody>
</table>

<h3 style="padding-left: 60px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;VOUCHER CERTIFICATE&nbsp;</h3>
<table style="height: 123px; margin-left: 30px;" width="442">
<tbody style="padding-left: 30px;">
<tr style="padding-left: 30px;">
<td style="width: 110.996px; padding-left: 30px; text-align: center;"><b>Details</b></td>
<td style="width: 110.996px; padding-left: 30px;"><b>Name</b></td>
<td style="width: 112.231px; padding-left: 30px;"><b>Signature &amp; Date</b></td>
</tr>
<tr style="padding-left: 30px;">
<td style="width: 110.996px; padding-left: 30px;">Prepared by</td>
<td style="width: 110.996px; padding-left: 30px;">&nbsp; {{Auth::user()->name}}</td>
<td style="width: 112.231px; padding-left: 30px;">&nbsp;</td>
</tr>
<tr style="padding-left: 30px;">
<td style="width: 110.996px; padding-left: 30px;">Checked by</td>
<td style="width: 110.996px; padding-left: 30px;">&nbsp;</td>
<td style="width: 112.231px; padding-left: 30px;">&nbsp;</td>
</tr>
<tr style="padding-left: 30px;">
<td style="width: 110.996px; padding-left: 30px;">Paid bay</td>
<td style="width: 110.996px; padding-left: 30px;">&nbsp;</td>
<td style="width: 112.231px; padding-left: 30px;">&nbsp;</td>
</tr>
</tbody>
</table>
<p style="padding-left: ; text-align: right; margin-bottom:10px;"><span style="text-decoration: underline;">__________________________</span></p>
<p style="padding-left: ; text-align: right; margin-bottom:10px;">Signature of Office Authorising Payment</p>
<p style="padding-left: ; text-align: right; margin-bottom:10px;">Date: __________________ And Designetion: _______________________</p>
<p style="padding-left: 30px; text-align: left; margin-bottom:10px;">ACKHNOLEDGEMENT</p>
<p style="padding-left: 30px; text-align: left; margin-bottom:10px;">Resceived the sum of&nbsp; ________________________________________Naira_________________________Kobo.</p>
<p style="padding-left: 30px; text-align: left; margin-bottom:10px;">&nbsp;</p>
<p style="padding-left: 30px; text-align: left; margin-bottom:10px;"><span style="text-decoration: underline;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="text-decoration: underline;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
<p style="padding-left: 30px; text-align: left; margin-bottom:10px;">&nbsp; &nbsp; Signature of receiver&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date</p>

<script>
    var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
    var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

    function inWords (num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        return str;
    }

    document.getElementById('num')value = function () {
        document.getElementById('txt').innerHTML = inWords(document.getElementById('num').value);
    };
</script>