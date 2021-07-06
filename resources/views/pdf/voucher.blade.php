<head>
    <title>voucher_{{$voucher[0]->pvno}}</title>
    <style>
        td{
            border: 0.1px solid black;
        }
    </style>
</head>

<h2 style="text-align: center; margin:5px;">
<img style="width:65px; height:60px;" src="{{ asset('img/logo-mautech.png') }}">&nbsp; &nbsp;&nbsp;
<strong>MAUTECH CONSULTANCY SERVICES</strong></h2>
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
<table style="height:; width:100%">
<tbody>
<tr>
<td style="width: 100%;  border: 1px solid white; text-align: center;">Amount</td>
</tr>
<tr>
<td style="width: 100%;  border: 1px solid white;">
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
<td style="width: 65%;  border: 0px solid black;">&nbsp; {{$payment->amount}}</td>
<td style="width: 35%; border: 0px solid black;">&nbsp; .00</td>
</tr>
</tbody>
</table>
</td>
</tr>

@endforeach

<tr style="text-align: left; height: ;">
<td style="width: 74px; height:;" colspan="2">&nbsp; Total amount in words: 
    <span style="text-decoration: underline" id="t_amount"> {{$voucher[0]->totalamount}} </span>
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
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
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
 document.getElementById('t_amount').innerHTML=convertNumberToWords($("#t_amount").text());
});
</script>
