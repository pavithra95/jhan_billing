<?php
use App\Models\SalesInvoiceCtrl;
use App\Models\PurchaseInvoiceCtrl;
use App\Models\CashBillInvoiceCtrl;
use App\Models\SalesReturnInvoiceCtrl;
use App\Models\PurchaseReturnInvoiceCtrl;

function getFinYear()
{
	if(date('m') >= 03) {
	   $d = date('Y-m-d', strtotime('+1 years'));
	   return   date('y') .'-'.date('y', strtotime($d));
	} else {
	  $d = date('Y-m-d', strtotime('-1 years'));
	  return   date('y', strtotime($d)).'-'.date('y');
	}

}

 function generateSalesInvoiceNo()
{
	$current = SalesInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	// $current->sequence = $new_sequence;
	// $current->save();
	$new_sequence = sprintf("%d", $new_sequence);
	$code = $current->prefix . getFinYear() . "/" . $new_sequence . $current->suffix;
	return $code;
}

 function updateSalesInvoiceNo()
{
	$current = SalesInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	 $current->sequence = $new_sequence;
	 $current->save();
}

function generateSalesReturnInvoiceNo()
{
	$current = SalesReturnInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	// $current->sequence = $new_sequence;
	// $current->save();
	$new_sequence = sprintf("%d", $new_sequence);
	$code = $current->prefix . getFinYear() . "/" . $new_sequence . $current->suffix;
	return $code;
}

function updateSalesReturnInvoiceNo()
{
	$current = SalesReturnInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	 $current->sequence = $new_sequence;
	 $current->save();
}

function generateCashBillInvoiceNo()
{
	$current = CashBillInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	// $current->sequence = $new_sequence;
	// $current->save();
	$new_sequence = sprintf("%d", $new_sequence);
	$code = $current->prefix . getFinYear() . "/" . $new_sequence . $current->suffix;
	return $code;
}

 function updateCashBillInvoiceNo()
{
	$current = CashBillInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	 $current->sequence = $new_sequence;
	 $current->save();
}

 function generatePurchaseInvoiceNo()
{
	$current = PurchaseInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	// $current->sequence = $new_sequence;
	// $current->save();
	$new_sequence = sprintf("%d", $new_sequence);
	$code = $current->prefix . getFinYear() . "/" . $new_sequence . $current->suffix;
	return $code;
}

 function updatePurchaseInvoiceNo()
{
	$current = PurchaseInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	 $current->sequence = $new_sequence;
	 $current->save();
}

function generatePurchaseReturnInvoiceNo()
{
	$current = PurchaseReturnInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	// $current->sequence = $new_sequence;
	// $current->save();
	$new_sequence = sprintf("%d", $new_sequence);
	$code = $current->prefix . getFinYear() . "/" . $new_sequence . $current->suffix;
	return $code;
}

function updatePurchaseReturnInvoiceNo()
{
	$current = PurchaseReturnInvoiceCtrl::where("financial_year_id", 1)->first();
	$new_sequence = $current->sequence + 1;
	 $current->sequence = $new_sequence;
	 $current->save();
}

function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? 'Rupees ' . $Rupees . ' Only' : '') . $paise;
}









?>