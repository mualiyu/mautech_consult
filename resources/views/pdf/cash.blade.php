<!DOCTYPE >
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>Untitled Spreadsheet</title>
	{{-- <link rel="stylesheet" href="{{asset('css/styles.css')}}"> --}}
	<style type="text/css">
    body{
        text-align: center;
        margin-top: 30px;
    }
	td{
        border: 1px solid black;
    }
	</style>
</head>
<body>
    <div class="container">
<table cellpadding="0" cellspacing="0" style="width:; border-collapse:collapse; text-decoration:">
    <tbody>
<?php 
    $nm = count($accounts);
    $nm = $nm+7;
 ?>
{{-- heads row --}}
        <tr style="height:26.8pt;">
            <td colspan="{{$nm}}" style="width:; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:15pt;"><span style="font-family:'Liberation Serif';">MODIBBO ADAMA UNIVERSITY OF TECHNOLOGY, YOLA</span></p>
            </td>
        </tr>
        <tr style="height:22.6pt;">
            <td colspan="{{$nm}}" style="width:; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Liberation Serif';">CONSULTANCY SERVICES UNIT</span></p>
            </td>
        </tr>

{{-- cash book detail (title) --}}

        <tr style="height:21.75pt;">
            <td colspan="3" style="width:1.7pt; vertical-align:bottom;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:'Liberation Serif'; margin-left:5px:">CASH BOOK</span></p>
            </td>
            <td style="width:65.2pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:40pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:50.4pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            @foreach ($accounts as $account)
                <td style="width:50.4pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';"></span></p>
            </td>
            @endforeach
            @if ($accounts)
                <td style="width:50.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
            @endif
            
        </tr>

{{-- Headers --}}
        <tr style="height:17.95pt;">
            <td style="width:30.9pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">DATE</span></p>
            </td>
            <td style="width:50.6pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">MANDATE</span></p>
            </td>
            <td style="width:90.8pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10.5pt;"><span style="font-family:'Liberation Serif';">BENEFICIARY</span></p>
            </td>
            <td style="width:65.2pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">DETAILS</span></p>
            </td>
            <td style="width:40pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">PV</span></p>
            </td>
            <td style="width:50.4pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">AMOUNT</span></p>
            </td>
            @foreach ($accounts as $account)
                <td style="width:55.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">{{$account}}</span></p>
                </td>
            @endforeach
            @if ($accounts)
                <td style="width:60.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">TOTAL</span></p>
                </td>
            @endif
        </tr>

{{-- data/informations rows --}}
        @if ($payments)
        
            <?php 
                $amount_r = [];
            ?>
            @foreach ($payments as $payment)
            <?php $voucher = \App\Voucher::find($payment->voucher_id) ?>
            
            <?php $mandate = Illuminate\Support\Facades\DB::table('mandates')->where('payment_id','=', $payment->id)->get() ?>
            <?php $beneficiary = \App\Beneficiary::find($payment->beneficiary_id) ?>
            <?php array_push($amount_r, $payment->amount); ?>
            <tr>
                <td style="width:30.9pt; vertical-align:top;">
                    <?php $due = explode(' ', $payment->created_at); $date = explode('-', $due[0]); $duedate = $date[0].'/'.$date[1].'/'.$date[2]; ?>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$duedate}}</span></p>
                </td>
                <td style="width:50.8pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$mandate[0]->mandateno ?? 'No Mandate'}}</span></p>
                    {{-- @if ($mandate)
                    @else
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$mandate[0]->mandateno}}</span></p>
                    @endif --}}
                </td>
                <td style="width:90.6pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$beneficiary->name}}</p>
                </td>
                <td style="width:65.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$payment->description}}</p>
                </td>
                <td style="width:40pt; vertical-align:top;">
                    <?php $v = explode('/', $voucher->pvno); $pvno = $v[1]; ?>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$pvno}}</p>
                </td>
                <td style="width:50.4pt; vertical-align:top; text-align:right; padding-right:4px;">
                   <?php  $amount_ss = number_format($payment->amount, 0, '', ',') ?>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$amount_ss}}</p>
                </td>
                
                @foreach ($accounts as $account)
                <td style="width:50.4pt; vertical-align:top;">
                    @if ($account == $beneficiary->account)
                            <?php $amount_sa = number_format($payment->amount, 0, '', ',') ?>
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">{{$amount_sa}}</span></p>
                        @else
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';"></span></p>
                        @endif
                    </td>
                @endforeach

                 @if ($accounts)
                    <?php $amount_sr= []; ?>
                    @foreach ($accounts as $a)
                        @if ($a == $beneficiary->account)
                            <?php array_push($amount_sr, $payment->amount);?>
                        @endif
                    @endforeach
                    <?php
                        $amount_s = 0; 
                        for ($i=0; $i < count($amount_sr); $i++) { 
                            $amount_s = $amount_s + $amount_sr[$i];
                        }
                        $amount_s = number_format($amount_s, 0, '', ',')
                    ?>
                    <td style="width:50.4pt; vertical-align:top; text-align:right; padding-right:4px;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$amount_s}}</p>
                    </td>
                 @endif
                
            </tr>
            @endforeach
        @endif

{{-- Totals row --}}

        <tr style="height:21.95pt;">
            <td style="width:30.9pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:50.8pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';"></span></p>
            </td>
            <td style="width:90.6pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:81.2pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:40pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <?php
                $total_amount = 0; 
                for ($i=0; $i < count($amount_r); $i++) { 
                    $total_amount = $total_amount + $amount_r[$i];
                }
                 $format_total_amount = number_format($total_amount, 0, '', ',')
            ?>
            <td style="width:50pt; vertical-align:bottom;  text-align:right; padding-right:4px;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$format_total_amount}}</span></p>
            </td>
            
            @foreach ($accounts as $account)
            <?php $t_amount_s = [];?>
            <?php $ac_ben = Illuminate\Support\Facades\DB::table('beneficiaries')->where('account','=', $account)->get() ?>
                <?php $ac_pays = Illuminate\Support\Facades\DB::table('payments')->where('beneficiary_id','=', $ac_ben[0]->id)->get() ?>
                @foreach ($ac_pays as $pay)
                    <?php
                        array_push($t_amount_s, $pay->amount);
                    ?>
                @endforeach
                <?php
                    $total_single_a = 0;
                    for ($i=0; $i < count($t_amount_s); $i++) { 
                        $total_single_a = $total_single_a + $t_amount_s[$i];
                    }
                    $total_single_a = number_format($total_single_a, 0, '', ',')
                ?>
                <td style="width:50.4pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">{{$total_single_a}}</span></p>
                </td>
            @endforeach

            @if ($accounts)
            
                <td style="width:50.4pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:13pt;"><span style="font-family:'Liberation Serif'; margin-right:3px;">{{$format_total_amount}}</span></p>
                </td>
            @endif
            
        </tr>


    </tbody>
</table>

</div>
</body>

</html>
