<?php
session_start();
include('../includes/dbcon.php');

require_once "../package/TCPDF-main/tcpdf.php";
date_default_timezone_set('Asia/Kolkata');


if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
}
if (isset($_GET['cont'])) {
    $cont = $_GET['cont'];
}
$sql = "SELECT * from bill where id=$pid";
$run = sqlsrv_query($conn, $sql);

$sql1 = "SELECT * from emp_contractor where name='$cont'";
$run1 = sqlsrv_query($conn, $sql1);
$row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

if ($run) {
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    
    $email = $row['email'];
    $contractor = $row['contractor'];
    $mobile = $row['mobile'];
    $billNo = $row['billNo'];
    $date = $row['date']->format('d-m-Y');
    $qty = $row['qty'];
    $rate = $row['rate'];
    $bonus = $row['bonus'];
    $amt = $row['amt'];
    $hra = $row['hra'];
    $ot = $row['ot'];
    $wa = $row['wa'];
    $total = $row['total'];
    $esic = $row['esic'];
    $pf = $row['pf'];
    $sc = $row['sc'];
    $st = $row['st'];
    $sgst = $row['sgst'];
    $cgst = $row['cgst'];
    $invoiceTotal = $row['inTotal'];
    $inTotal = $row['inTotal'];

    $no = floor($inTotal);
    $point = round($inTotal - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $p = 0;
    $str = array();
    $words = array(
        '0' => '',
        '1' => 'One',
        '2' => 'Two',
        '3' => 'Three',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        '10' => 'Ten',
        '11' => 'Eleven',
        '12' => 'Twelve',
        '13' => 'Thirteen',
        '14' => 'Fourteen',
        '15' => 'Fifteen',
        '16' => 'Sixteen',
        '17' => 'Seventeen',
        '18' => 'Eighteen',
        '19' => 'Nineteen',
        '20' => 'Twenty',
        '30' => 'Thirty',
        '40' => 'Forty',
        '50' => 'Fifty',
        '60' => 'Sixty',
        '70' => 'Seventy',
        '80' => 'Eighty',
        '90' => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($p < $digits_1) {
        $divider = ($p == 2) ? 10 : 100;
        $inTotal = floor($no % $divider);
        $no = floor($no / $divider);
        $p += ($divider == 10) ? 1 : 2;
        if ($inTotal) {
            $plural = (($counter = count($str)) && $inTotal > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($inTotal < 21) ? $words[$inTotal] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($inTotal / 10) * 10]
                . " " . $words[$inTotal % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else
            $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF
    {
        //Page header
        public function Header()
        {
            /*$this->SetFont('times', 'B', 16);
            $this->SetY(13);
            $this->SetX(2);
            $this->Cell(0,10,'Travelling Voucher',0,0,'C');*/
        }

        // Page footer
        public function Footer()
        {
            $this->SetY(-10);
            // Set font
            $this->SetFont('helvetica', 'b', 9);
            $this->SetTextColor(153, 0, 0);
            /*$this->Cell(0, 10, '**This Is Computer Generated Report Signature Is Required**', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/
            // Page number
            $this->Cell(0, 8, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }
    // create new PDF document
    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Bill Copy');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(1, 5, 4);
    $pdf->SetHeaderMargin(3);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(true, 9);
    $pdf->AddPage();


    $pdf->SetFont('helvetica', 'A');
    $output = '
<table style="border:1px solid black; border-collapse:collapse; padding: 1px;">
<thead>
    <tr>
        <td colspan="5">
        </td>
    </tr>
    <tr>
        <th colspan="5" style="text-align:center;background-color:#d3d3d3;font-size:20px;">
            '.$contractor.'
        </th>
    </tr>
    <tr>
        <td colspan="5">
        </td>
    </tr>
    <tr>
        <th colspan="5" style="font-size:12px;text-align:center;">
        ' . $row1['address'] . '
        </th>
    </tr>
    <tr>
        <td colspan="2" style="font-size:12px; text-align:center;">
            E-mail: ' . $email . '     
        </td>
        <td colspan="3" style="font-size:12px; text-align:center;">
            Mob.No. :' . $mobile . '
        </td>
    </tr>
    <tr>
        <td colspan="5">
        </td>
    </tr>
    <tr>
        <td style="font-size:12px;border:1px solid black;width:50%;">
            <sup>M / S .</sup>
            Suyog Electricals Ltd
        </td>
        <td style="font-size:12px;text-align:center;border:1px solid black;background-color:#d3d3d3;width:50%;">
            GST TAX INVOICE
        </td>
    </tr>
    
    <tr style="font-size:10.5px;">
        <td style="border-right:1px solid black;height:20px; width:50%;">
            2204/2205,GIDC ESTATE - Halol,PMS-GJ-389350 </td>
        <td style="display:flex;text-align:center;border-bottom:1px solid black;width:50%;">
                Bill No : &nbsp;' . $billNo . '
        </td>
    </tr>
    <tr style="font-size:12px;border:1px solid black;">
        <td style="text-align:center;border:1px solid black;width:50%;">
            24AACCS9412R1ZV </td>
        <td style="text-align:center;width:50%;">
          Date :&nbsp;' . $date . '
        </td>
    </tr>
    <tr style="font-size:12px;text-align:center;">
        <th style="border:1px solid black;width:10%;">Sr.no</th>
        <th style="border:1px solid black;width:50%;">Particulars</th>
        <th style="border:1px solid black;width:10%;">Quantity</th>
        <th style="border:1px solid black;width:10%;">Rate</th>
        <th style="border:1px solid black;width:20%;">Amount</th>
    </tr>

</thead>
<tbody>
    <tr style="font-size:12px;">
        <td style="text-align:center;width:10%;">1</td>
        <td style="border-left: 1px solid black;font-size:12px;width:50%;text-align:left;">&nbsp;Labour supply work in the factory for the month of Aug
        </td>
        <td style="text-align:center;border-right:1px solid black;border-left: 1px solid black;width:10%;">' . $qty . '</td>
        <td style="border-right:1px solid black;border-left: 1px solid black;width:10%;">' . $rate . '</td>
        <td style="text-align:center;width:20%;">' . $amt . '</td>

    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
    </tr>
    <tr style="font-size:12px;">
        <td></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;text-align:left;">&nbsp;Att. Bonus</td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="text-align:center;">' . $bonus . '</td>
    </tr>
    <tr style="font-size:12px;">
        <td></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;text-align:left;">&nbsp;HRA</td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="text-align:center;">' . $hra . '</td>
    </tr>
    <tr style="font-size:12px;">
        <td></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;text-align:left;">&nbsp;Washing Allowance
        </td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="text-align:center;">' . $wa . '</td>
    </tr>
    <tr style="font-size:12px;">
        <td></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;text-align:left;">&nbsp;Over Time</td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
        <td style="text-align:center;">' . $ot . '</td>
    </tr>
    <tr rowspan="3">
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="text-align:center;"></td>
    </tr>

    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="border-left: 1px solid black;"></td>
        <td style="border:1px solid black;text-align:center;">Total</td>
        <td></td>
        <td style="text-align:center;border:1px solid black;">' . $total . '</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td></td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:right;border-right: 1px solid black;">ESIC Charges</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;text-align:center;">3.25%</td>
        <td style="text-align:center;">' . $esic . '</td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:right;border-right: 1px solid black;">PF Charges</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;text-align:center;">13%</td>
        <td style="text-align:center;">' . $pf . '</td>
    </tr>
    
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:right;border-right: 1px solid black;">Service Charges</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;text-align:center;">4%</td>
        <td style="text-align:center;">' . $sc . '</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td></td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border:1px solid black;text-align:center;">Sub Total</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:center;border:1px solid black;">' . $st . '</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td></td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:right;border-right: 1px solid black;">SGST</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;text-align:center;">9%</td>
        <td style="text-align:center;">' . $sgst . '</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td></td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border-right: 1px solid black;"></td>
        <td style="text-align:right;border-right: 1px solid black;">CGST</td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;text-align:center;">9%</td>
        <td style="text-align:center;">' . $cgst . '</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td style="border-right: 1px solid black;"></td>
        <td></td>
    </tr>
    <tr style="font-size:12px;">
        <td style="border: 1px solid black;"></td>
        <td style="text-align:right;border: 1px solid black;padding:5px;">Invoice Total</td>
        <td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
        <td
            style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">
        </td>
        <td style="text-align:center;border: 1px solid black;">' . $invoiceTotal . '</td>
    </tr>
    <tr style="font-size:12px;">
        <td colspan="5" style="text-align:left; border-bottom:1px solid black; height: 20px;"><b>Amount In Word:</b> ' . $result . '
        </td>
    </tr>
    
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black; width: 50%;">&nbsp;GST No : 24ATAPG6048D1Z6</td>
        <td style="width: 50%;"></td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black;">&nbsp;PAN NO : ATAPG6048D</td>
        <td style="width: 50%;"></td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black; width: 50%;">&nbsp;ESIC NO : 38000484020001019</td>
        <td style="text-align:center; width: 50%;">
        For , Shubham Recruitment Agency Business
        </td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black; width: 50%;">&nbsp;P F No : VDBRD2076807000</td>
        <td style="width: 50%;"></td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black; width: 50%;">&nbsp;Bank Detail : HDFC BANK -Halol.</td>
        <td style="width: 50%;"></td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black; width: 50%;">&nbsp;A/C NO : 50200049051242</td>
        <td style="width: 50%;"></td>
    </tr>
    <tr style="font-size:12px;text-align:left;">
        <td style="border-right:1px solid black;">&nbsp;E. & O. E. Subject to Halol Jurisdiction</td>
        <td style="text-align:center;">Authorised Signatory</td>
    </tr>
</tbody>
</table>
    ';

    $pdf->SetFont("times", "A", 9);
    $pdf->SetY(6);
    $pdf->SetX(4);
    $pdf->writeHTML($output, true, false, false, false, 'C');



    // Clean any content of the output buffer
    ob_end_clean();

    //Close and output PDF document
    $pdf->Output('bill-pdf.pdf', 'I');
} else {
    echo "Error in SQL query: " . sqlsrv_errors();
}