<!DOCTYPE >
<html>
<head>
	<meta http-equiv="content-type" content="text/html;"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CashBook-(<?= Date('d/m/20y') ?>)</title>
	{{-- <link rel="stylesheet" href="{{asset('css/styles.css')}}"> --}}
	<style type="text/css">
    html{
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }
    body{
        text-align: center;
        margin: 0;
        margin-top: 30px;
        font-size: 12px;
    }
     @page
    {
        size: auto; /* auto is the initial value */
        margin: 2mm 4mm 0mm 0mm; /* this affects the margin in the printer settings */
    }
    thead
    {
        display: table-header-group;
    }

	td{
        border: 0.3px solid black;
    }
	</style>
</head>
<body>
    <h2 style="text-align: center; margin:;">
        <img style="width:70px; height:65px;" src="{{ asset('img/logo-mautech.png') }}">
    </h2>
<h2 style="text-align: center; margin:5px;">
<strong>MODIBBO ADAMA UNIVERSITY, YOLA</strong></h2>
<h4 style="text-align: center; margin:5px;"><strong>CONSULTANCY SERVICES UNIT</strong></h4>
    <div class="container">
<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; text-decoration:">
<?php 
    $nm = count($accounts);
    $nm = $nm+7;
?>
    <thead>
    {{-- cash book detail (title) --}}
    
            <tr style="height:21.75pt;">
                <td colspan="3" style="width:1.7pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:'Liberation Serif'; margin-left:5px:">CASH BOOK</span></p>
                </td>
                <td style="width:60.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
                <td style="width:25pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
                <td style="width:40.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
                @foreach ($accounts as $account)
                    <td style="width:35.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';"></span></p>
                </td>
                @endforeach
                @if ($accounts)
                    <td style="width:35.4pt; vertical-align:top;">
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
                <td style="width:70.8pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10.5pt;"><span style="font-family:'Liberation Serif';">BENEFICIARY</span></p>
                </td>
                <td style="width:65.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">DETAILS</span></p>
                </td>
                <td style="width:20pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">PV</span></p>
                </td>
                <td style="width:40.4pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">AMOUNT</span></p>
                </td>
                @foreach ($accounts as $account)
                    <td style="width:35.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">{{$account}}</span></p>
                    </td>
                @endforeach
                @if ($accounts)
                    <td style="width:35.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">TOTAL</span></p>
                    </td>
                @endif
            </tr>
        </thead>

    <tbody>

{{-- data/informations rows --}}
        @if ($payments)
        
            <?php 
                $amount_r = [];
            ?>
            @foreach ($payments as $payment)
            <?php $voucher = \App\Voucher::find($payment->voucher_id) ?>
            
            <?php $mandate = Illuminate\Support\Facades\DB::table('mandates')->where('payment_id','=', $payment->id)->get() ?>
            <?php $beneficiary = \App\Beneficiary::find($payment->beneficiary_id) ?>
            <?php $budget = \App\Budget::find($payment->budget_id) ?>
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
                <td style="width:70.6pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$beneficiary->name}}</p>
                </td>
                <td style="width:65.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$payment->description}}</p>
                </td>
                <td style="width:20pt; vertical-align:top;">
                    <?php $v = explode('/', $voucher->pvno); $pvno = $v[1]; ?>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$pvno}}</p>
                </td>
                <td style="width:40.4pt; vertical-align:top; text-align:right; padding-right:4px;">
                   <?php  $amount_ss = number_format($payment->amount, 0, '', ',') ?>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span>{{$amount_ss}}</p>
                </td>
                
                @foreach ($accounts as $account)
                <td style="width:35.4pt; vertical-align:top;">
                    @if ($account == $budget->account_code)
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
                        @if ($a == $budget->account_code)
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
                    <td style="width:35.4pt; vertical-align:top; text-align:right; padding-right:4px;">
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
            <td style="width:70.6pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:75.2pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <td style="width:20pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
            </td>
            <?php
                $total_amount = 0; 
                for ($i=0; $i < count($amount_r); $i++) { 
                    $total_amount = $total_amount + $amount_r[$i];
                }
                 $format_total_amount = number_format($total_amount, 0, '', ',')
            ?>
            <td style="width:30pt; vertical-align:bottom;  text-align:right; padding-right:4px;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$format_total_amount}}</span></p>
            </td>
            
            @foreach ($accounts as $account)
            <?php $t_amount_s = [];?>
            <?php $ac_ben = Illuminate\Support\Facades\DB::table('budgets')->where('account_code','=', $account)->get() ?>
            <?php $ac_bn = Illuminate\Support\Facades\DB::table('beneficiaries')->where('account','=', $account)->get() ?>
                <?php $ac_pays = Illuminate\Support\Facades\DB::table('payments')->where('budget_id','=', $ac_ben[0]->id)->get() ?>
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
                <td style="width:35.4pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">{{$total_single_a}}</span></p>
                </td>
            @endforeach

            @if ($accounts)
            
                <td style="width:35.4pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:13pt;"><span style="font-family:'Liberation Serif'; margin-right:3px;">{{$format_total_amount}}</span></p>
                </td>
            @endif
            
        </tr>


    </tbody>
</table>

</div>
</body>

</html>
