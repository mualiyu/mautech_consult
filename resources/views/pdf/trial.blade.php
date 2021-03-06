<!DOCTYPE >
<html>
<head>
	<meta http-equiv="content-type" content="text/html;"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TrialBlance(<?= Date('d/m/20y') ?>)</title>
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
        margin: 10;
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

    <thead>
    {{-- cash book detail (title) --}}
    
            <tr style="height:21.75pt;">
                <td colspan="3" style="width:1.7pt; vertical-align:bottom;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:'Liberation Serif'; margin-left:5px:">Trial Balance From <span id="small">{{$daterange[0] ." - ". $daterange[1]}}</span></span></p>
                </td>
                <td style="width:60.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
                <td style="width:60.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;</span></p>
                </td>
            </tr>
    
    {{-- Headers --}}
            <tr style="height:17.95pt;">
                <td style="width:30.9pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">DATE</span></p>
                </td>
                <td style="width:50.6pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">BUDGET</span></p>
                </td>
                <td style="width:50.6pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">ACCOUNT CODE</span></p>
                </td>
                <td style="width:70.8pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10.5pt;"><span style="font-family:'Liberation Serif';">DEBIT</span></p>
                </td>
                <td style="width:65.2pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:'Liberation Serif';">CREDIT</span></p>
                </td>
            </tr>
        </thead>

    <tbody>

{{-- data/informations rows --}}
        @foreach ($payments as $v)
	<tr>
	    <td style="width:30.9pt; vertical-align:top;">
		<?php $due = explode(' ', $v->created_at); $date = explode('-', $due[0]); $datet = $date[2].'/'.$date[1].'/'.$date[0]; ?>
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{$datet}}</span></p>
	    </td>
            <?php 
            $budget = Illuminate\Support\Facades\DB::table('budgets')->where('id', '=', $v->budget_id)->get();
            ?>

            <td style="width:100.8pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;
                    <?php if($v->budget_id){ foreach($budget as $b){ echo $b->description; } }else{ echo "No Budget";} ?>
                </span></p>
            </td>
            <td style="width:50.6pt; vertical-align:top;">
            <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;
                {{-- {{$budget->account_code}} --}}
                <?php if($v->budget_id){ foreach($budget as $b){ echo $b->account_code; } }else{ echo "No Code";} ?>
            </span></p>
            </td>

	    <td style="width:30.6pt; vertical-align:top;">
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{number_format($v->amount/100, 2)}}</span></p>
	    </td>
	    <td style="width:30.2pt; vertical-align:top;">
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{number_format($v->amount/100, 2)}}</span></p>
	    </td>
	    
	</tr>
	@endforeach

{{-- Totals row --}}
<?php 
$totalamount = 0;
foreach ($payments as $v) {
	$totalamount = $totalamount + $v->amount;
}
?>

        <tr style="height:21.95pt;">
            <td colspan="3" style="width:30.9pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;Total Amount</span></p>
            </td>
            <td style="width:70.6pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{number_format($totalamount/100, 2)}}</span></p>
            </td>
            <td style="width:75.2pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Liberation Serif';">&nbsp;{{number_format($totalamount/100, 2)}}</span></p>
            </td>
           
        </tr>


    </tbody>
</table>

</div>
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script>
    var start = <?php echo $daterange[0]; ?>;
    var end = <?php echo $daterange[1]; ?>;

    function cb1(start, end) {
        $('#small').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }
    cb1(start, end);
</script>
</body>

</html>
