<head>
    <title>voucher_{{$voucher[0]->pvno}}</title>
    <style>
        td{
            border: 0.1px solid black;
        }
    </style>
</head>
 <body>
     <h2 style="text-align: center; margin:;">
        <img style="width:70px; height:65px;" src="{{ asset('img/logo-mautech.png') }}">
    </h2>
<h2 style="text-align: center; margin:5px;">
<strong>MAU CONSULTANCY SERVICES</strong></h2>
<h4 style="text-align: center; margin:5px;"><strong>Modibbo adama university, Yola</strong></h4>
<h3 style="text-align: center; margin:5px; margin-bottom:10px;"><span style="text-decoration: underline;">DOMESTIC PAYMENT VOUCHER</span></h3>
<div style="display: block; text-align:center; margin:0;">
        <span style="left: 0%; float:left;">P.V.No: <span style="text-decoration: underline">{{$voucher[0]->pvno}}</span></span>
        <span style="right: 0%; float:right;">Date: <span style="text-decoration: underline">{{$voucher[0]->created_at}}</span>________</span>
</div><br>
    <?php $i=0; $payNo = $payments->count(); ?>
<div style="display: block; text-align:center; margin:0;">
        <span style="left:0%; float:left;">Payee: <span style="text-decoration: underline">
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
        </span> </span>
        <span style="right:0%; float:right;">Debit: <span style="text-decoration:;">________________________&nbsp;</span></span>
    
</div><br>

<div style="display: block; text-align:center; margin:0;">
    <span style=" left:0%; float:left;">Address: ________________________________&nbsp;</span>
    <span style="right:0%; float:right;"> Cheque No: ____________________</span>
</div><br>

<div style="display: block; text-align:center; margin:0;"">
    <span style="left:0%; float:left;">________________________________&nbsp;</span>
    <span style="left:0%; float:right;"> S.R.V/L.P.O No ________________</span>
</div><br>


<table style="width: 98%; height:; margin-left: 10px; border: solid black;" cellspacing="1">
<tbody>
<tr style="height: 33px;">
<td style="width: 25%; height: ; text-align: center;">&nbsp; DATE</td>
<td style="width: 55%; height: ; text-align: center;">&nbsp;Description of service</td>
<td style="width: 20%; text-align: center; height: ;">
<table style="height:; width:100%;">
<tbody>
<tr>
<td style="width: 100%;  border: 1px solid white; text-align: center;">Amount</td>
</tr>
<tr>
<td style="width: 100%;  border: 1px solid white;">
<table style="height: 25px; width: 100%;">
<tbody>
<tr>
<td style="width: ; text-align: center;">N</td>
<td style="width: ; text-align: center;">k&nbsp;</td>
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
<td style="width: 55%%; height: ;">
<p>&nbsp; {{$beneficiary[0]->name}}: {{$payment->description}}</p>
</td>
<td style="width: 20%; height: ;">
<table style="height: ; width: 100%;">
<tbody>
<tr style="width:;">
<td style="width: 65%;  border: 0px solid black;">&nbsp; {{number_format($payment->amount)}}</td>
<td style="width: 35%; border: 0px solid black;">&nbsp; .00</td>
</tr>
</tbody>
</table>
</td>
</tr>

@endforeach

<tr style="text-align: left; height: ;">
<td style="width: 80%; height:;" colspan="2">&nbsp; Total amount in words: 
    <span style="text-decoration:; text-transform: uppercase;" id="t_amount"><small> {{$amountInWords}}</small> </span>
    <input type="hidden" value="{{$voucher[0]->totalamount}}" name="" id="num">
</td>
<td style="width: 20%; height: ;">
&nbsp;&nbsp;&nbsp;<span style="font-size: 20px"><small>NGN <span id="t_amount_c">{{number_format($voucher[0]->totalamount)}}</span></small></span> 
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
    function numberToWords(number) {  
        var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];  
        var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];  
        var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];  
        var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];  
  
        number = number.toString(); number = number.replace(/[\, ]/g, ''); if (number != parseFloat(number)) return 'not a number'; var x = number.indexOf('.'); if (x == -1) x = number.length; if (x > 15) return 'too big'; var n = number.split(''); var str = ''; var sk = 0; for (var i = 0; i < x; i++) { if ((x - i) % 3 == 2) { if (n[i] == '1') { str += elevenSeries[Number(n[i + 1])] + ' '; i++; sk = 1; } else if (n[i] != 0) { str += countingByTens[n[i] - 2] + ' '; sk = 1; } } else if (n[i] != 0) { str += digit[n[i]] + ' '; if ((x - i) % 3 == 0) str += 'hundred '; sk = 1; } if ((x - i) % 3 == 1) { if (sk) str += shortScale[(x - i - 1) / 3] + ' '; sk = 0; } } if (x != number.length) { var y = number.length; str += 'point '; for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' '; } str = str.replace(/\number+/g, ' '); return str.trim() + ".";  
        
        return number;
    }

    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

$(document).ready( function () {
//  document.getElementById('t_amount').innerHTML=numberToWords($("#t_amount").text());
 document.getElementById('t_amount_c').innerHTML=numberWithCommas($("#t_amount_c").text());
//  document.getElementById('t_amount').innerHTML=convertNumberToWords($("#t_amount").text());
});
</script>
 </body>
