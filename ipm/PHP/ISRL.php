<?php
require "../../fpdf182/fpdf.php";
include "connection.php";
session_start();

class myPDF extends FPDF {
  private $tableEnd;
  private $currency = 2;

  function getCurrencyVar() {
    return $this->currency;
  }

  function getTableEnd() {
    return $this->tableEnd;
  }

  function setTableEnd($y) {
    $this->tableEnd = $y;
  }

  function getCurrency($db, $id) {
    $result = $db->query("SELECT currency_Name FROM currency WHERE currency_ID = '$id'");
    $row = $result->fetch_assoc();
    return $row['currency_Name'];
  }

  function getID() {
    return $_SESSION['id'];
  }

  function getCommissions($db) {
    $result = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Domestic'");
    return mysqli_num_rows($result);
  }

  function myHeader($db){
    $this->SetFont('Arial','B', 14);
    $this->Cell(270, 10, "Individual Sales Report", 0, 1, "C");
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT currency_Rate FROM currency WHERE currency_ID = '$currency'");
    $row = $result->fetch_assoc();
    $this->SetFont('Arial','', 12);
    $this->Cell(270, 6, "(DOMESTIC)", 0, 1, "C");
    $id = $this->getID();
    $result = $db->query("SELECT staff_Name, staff_Surname FROM staff WHERE staff_ID = '$id'");
    $row = $result->fetch_assoc();
    $this->Cell(270, 6, $row['staff_Name']." ".$row['staff_Surname']." ".$id, 0, 1, "C");
  }

  function info() {
    $date = date("m/Y");
    $this->SetFont('Arial','', 12);
    $this->Cell(45,6,"AGENT", 0, 0, "L");
    $this->Cell(45,6, ": AIR LINK", 0, 1, "L");
    $this->Cell(45,6,"Number", 0, 0, "L");
    $this->Cell(45,6, ": /", 0, 1, "L");
    $this->Cell(45,6,"Sales Office Place", 0, 0, "L");
    $this->Cell(45,6, ": ", 0, 1, "L");
    $this->Cell(45,6,"Report Period", 0, 0, "L");
    $this->Cell(45,6, ": $date", 0, 1, "L");
  }

  function headerTable($db) {
    $this->SetFont('Times', 'B', 12);
    $this->setXY(10, 60);
    //First Row
    $this->Cell(10,30,'',1,0,'C');
    $this->Cell(60, 10, "Air Via Documents", 1, 0, "C");
    $this->Cell(120, 10, "Forms of Payments", 1, 0, "C");
    $this->Cell(90, 10, "Commissions", 1, 1, "C");
    //Second Row
    $this->Cell(10, 10, "N", 0, 0, 'C');
    $this->Cell(15, 20, "Blanks", 1, 0, 'C');
    $this->Cell(45, 10, "Fare Amount", 1, 0, 'C');
    $this->Cell(20, 20, "Cash", 1, 0, 'C');
    $this->Cell(80, 10, "Credit Cards", 1, 0, 'C');
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 20, "Total Paid", 1, 0, 'C');
    $this->SetFont('Times', 'B', 12);
    $this->Cell(90, 10, "Assessable Amounts", 1, 1, 'C');
    //Third Row
    $currency = $this->getCurrencyVar();
    $this->Cell(10, 10, "", 0, 0);
    $this->Cell(15, 10, "", 0, 0);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(10, 10, $this->getCurrency($db, 1), 1, 0, 'C');
    $this->Cell(17.5, 10, $this->getCurrency($db, 1).'/'.$this->getCurrency($db,$currency), 1, 0, 'C');
    $this->Cell(17.5, 10, $this->getCurrency($db, $currency), 1, 0, 'C');
    $this->Cell(20, 10, "", 0, 0);
    $this->Cell(40, 10, "Full CC Number", 1, 0, 'C');
    $this->Cell(20, 10, $this->getCurrency($db, 1), 1, 0, 'C');
    $this->Cell(20, 10, $this->getCurrency($db, $currency), 1, 0, 'C');
    $this->Cell(20, 10, "", 0, 0);
    $result = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Domestic'");
    $x = 90/mysqli_num_rows($result);
    while ($row = $result->fetch_assoc()) {
      $this->Cell($x, 10, $row['commission_Rate'].'%', 1, 0, 'C');
    }
    $this->Ln();
  }

  function originalBlanks($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $id = $this->getID();
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT blanks.blank_Type AS blanks FROM blanks
                          INNER JOIN coupons ON blanks.blank_ID = coupons.blank_ID
                          INNER JOIN tickets ON coupons.ticket_ID = tickets.ticket_ID
                          INNER JOIN sales ON tickets.ticket_ID = sales.ticket_ID
                          WHERE sales.staff_ID = '$id' AND sales.sales_Type='Domestic'");
    $y = 90;
    while ($row = $result->fetch_assoc()) {
      $blanks = $row['blanks'];
      $this->setXY(10, $y);
      $this->Cell(10, 10, "", 0, 0);
      $this->Cell(15,10,$blanks,1,0,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function fareAmount($db) {
    $totalUSD = 0;
    $totalLocal = 0;
    $currency = $this->getCurrencyVar();
    $id = $this->getID();
    $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
    $fetchRow = $fetchRate->fetch_assoc();
    $Rate = $fetchRow['currency_Rate'];
    $result = $db->query("SELECT sales.sales_Charge as Charge, sales.currency_ID as ID, sales.currency_Rate as Rate FROM sales INNER JOIN currency
                          ON currency.currency_ID = sales.currency_ID AND sales.sales_Type = 'Domestic' AND sales.staff_ID ='$id' AND (sales.currency_ID = '1' OR sales.currency_ID = '$currency')");
    $y = 90;
    while ($row = $result->fetch_assoc()) {
      $this->setXY(35, $y);
      $this->Cell(10, 10, number_format($row['Charge']/$Rate, 2), 1, 0, 'C');
      $this->Cell(17.5,10, $Rate, 1, 0,'C');
      $this->Cell(17.5, 10, $row['Charge'], 1, 0, 'C');
      $totalLocal += $row['Charge'];
      $totalUSD += $row['Charge']/$Rate;
      $y += 10;
    }
    $this->setXY(35, $y);
    $this->Cell(22.5, 10, number_format($totalUSD, 2), 1, 0, 'C');
    $this->Cell(22.5, 10, number_format($totalLocal, 2), 1, 0, 'C');
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function cash($db) {
    $this->SetFont('Times', '', 10);
    $currency = $this->getCurrencyVar();
    $id = $this->getID();
    $result = $db->query("SELECT sales_Charge AS Charge , payment_Type AS Type, currency_ID AS ID FROM sales WHERE sales_Type = 'Domestic' AND staff_ID='$id'");
    $y = 90;
    $total = 0;
    $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
    $fetchRow = $fetchRate->fetch_assoc();
    $Rate = $fetchRow['currency_Rate'];
    while ($row = $result->fetch_assoc()) {
      $this->setXY(80, $y);
      if ($row['Type'] != 'Cash') {
        $this->Cell(20, 10, "", 0, 0);
      } else {
        $this->Cell(20, 10, $row['Charge'], 1, 0, 'C');
        $total+=$row['Charge'];
      }
      $y += 10;
    }
    $this->setXY(80, $y);
    $this->Cell(20, 10, $total, 1, 0, 'C');
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function card($db) {
    $this->SetFont('Times', '', 10);
    $currency = $this->getCurrencyVar();
    $id = $this->getID();
    $result = $db->query("SELECT sales_Charge AS Charge , payment_Type AS Type, currency_ID AS ID, card_Digits AS Digits, currency_Rate AS Rate FROM sales WHERE sales_Type = 'Domestic' AND staff_ID='$id'");
    $y = 90;
    $totalUSD = 0;
    $totalLocal = 0;
    $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
    $fetchRow = $fetchRate->fetch_assoc();
    $Rate = $fetchRow['currency_Rate'];
    while ($row = $result->fetch_assoc()) {
      $this->setXY(100, $y);
      if ($row['Type'] != 'Card') {
        $this->Cell(40, 10, "", 0, 0);
        $this->Cell(20, 10, "", 0, 0);
        $this->Cell(20, 10, "", 0, 0);
      } else {
        $this->Cell(40, 10, $row['Digits'], 1, 0, 'C');
        $this->Cell(20, 10, number_format($row['Charge']/$Rate, 2), 1, 0, 'C');
        $this->Cell(20, 10, $row['Charge'], 1, 0, 'C');
        $totalUSD += $row['Charge']/$Rate;
        $totalLocal += $row['Charge'];
      }
      $y += 10;
    }
    $this->setXY(100, $y);
    $this->Cell(40, 10, "", 1, 0);
    $this->Cell(20, 10, number_format($totalUSD, 2), 1, 0, 'C');
    $this->Cell(20, 10, number_format($totalLocal, 2), 1, 0, 'C');
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function TotalPaid($db) {
    $this->SetFont('Times', '', 10);
    $currency = $this->getCurrencyVar();
    $id = $this->getID();
    $result = $db->query("SELECT sales_Charge AS Charge , payment_Type AS Type, currency_ID AS ID, card_Digits AS Digits, currency_Rate AS Rate FROM sales WHERE sales_Type = 'Domestic' AND staff_ID='$id'");
    $y = 90;
    $total = 0;
    while ($row = $result->fetch_assoc()) {
      $this->setXY(180, $y);
      $this->Cell(20, 10, $row['Charge'], 1, 0, 'C');
      $total += $row['Charge'];
      $y += 10;
    }
    $this->setXY(180, $y);
    $this->Cell(20, 10, number_format($total, 2), 1, 0, 'C');
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function commissions($db) {
    $this->SetFont('Times', '', 10);
    $y = 90;
    $currency = $this->getCurrencyVar();
    $id = $this->getID();
    $total0 = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;
    $CommissionTotal0 = 0; $CommissionTotal1 = 0; $CommissionTotal2 = 0; $CommissionTotal3 = 0;
    $CommissionTotal4 = 0; $CommissionTotal5 = 0;
    $result = $db->query("SELECT sales_Charge AS Charge, commission_Rate, currency_ID AS ID FROM sales WHERE sales_Type = 'Domestic' AND staff_ID='$id'");
    $commissions = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Domestic'");
    $columns = $this->getCommissions($db);
    $width = 90/$columns;
    $array = array(6);
    $i = 0;
    while ($i < 6 && $CommissionsRow = $commissions->fetch_assoc()) {
      if (isset($CommissionsRow['commission_Rate'])) {
        $array[$i] = $CommissionsRow['commission_Rate'];
      } else {
        $array[$i] = 'Null'.$i;
      }
      $i++;
    }
    while ($row = $result->fetch_assoc()) {
      $this->setY($y);
        $amount = $row['Charge'];
      switch ($row['commission_Rate']) { //check the rate
        case $array[0]:
          $this->setX(200);
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total0+=$amount;
          $CommissionTotal0 +=($amount*$array[0])/100;
          break;
        case $array[1]:
          $this->setX(200+($width*1));
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total1+=$amount;
          $CommissionTotal1 +=($amount*$array[1])/100;
          break;
        case $array[2]:
          $this->setX(200+($width*2));
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total2+=$amount;
          $CommissionTotal2 +=($amount*$array[2])/100;
          break;
        case $array[3]:
          $this->setX(200+($width*3));
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total3+=$amount;
          $CommissionTotal3 +=($amount*$array[3])/100;
          break;
        case $array[4]:
          $this->setX(200+($width*4));
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total4+=$amount;
          $CommissionTotal4 +=($amount*$array[4])/100;
          break;
        case $array[5]:
          $this->setX(200+($width*5));
          $this->Cell($width, 10, $amount, 1, 0, 'C');
          $total5+=$amount;
          $CommissionTotal5 +=($amount*$array[5])/100;
          break;
        default :
          break;
      }
      $y += 10;
    }
    $this->setXY(155,$y+10);
    $this->Cell(45, 10, "Total Commission Amount", 1, 0, 'C');
    $this->setXY(155,$y+20);
    $this->Cell(45, 10, "Net Amounts for Agent's Debit", 1, 0, 'C');
    $totalAmount = 0;
    for ($i=0; $i<$columns; $i++) {
      switch ($i) {
        case 0:
          $amount = $total0;
          $commissionAmount = $CommissionTotal0;
          $totalAmount += $amount;
          break;
        case 1:
          $amount = $total1;
          $commissionAmount = $CommissionTotal1;
          $totalAmount += $amount;
          break;
        case 2:
          $amount = $total2;
          $commissionAmount = $CommissionTotal2;
          $totalAmount += $amount;
          break;
        case 3:
          $amount = $total3;
          $commissionAmount = $CommissionTotal3;
          $totalAmount += $amount;
          break;
        case 4:
          $amount = $total4;
          $commissionAmount = $CommissionTotal4;
          $totalAmount += $amount;
          break;
        case 5:
          $amount = $total5;
          $commissionAmount = $CommissionTotal5;
          $totalAmount += $amount;
          break;
      }
      $this->setXY(200+($width*$i), $y);
      $this->Cell($width, 10, $amount, 1, 0, 'C');
      $this->setXY(200+($width*$i),$y+10);
      $this->Cell($width, 10, number_format($commissionAmount, 2), 1, 0, 'C');
      $this->setXY(200+($width*$i),$y+20);
      $this->Cell($width, 10, number_format($amount-$commissionAmount, 2), 1, 0, 'C');
    }

    $this->setXY(140,$y+30);
    $this->SetFont('Times', '', 10);
    $this->Cell(70, 5, "Total Net Amount for", 0, 2, 'C');
    $this->Cell(70, 5, "Bank remittence to Air Via", 0, 0, 'C');
    $this->setXY(190,$y+30);
    $this->Cell(30, 10, number_format($totalAmount-$CommissionTotal0-$CommissionTotal1-$CommissionTotal2-$CommissionTotal3-$CommissionTotal4-$CommissionTotal5), 0, 0, 'C');
    $this->setXY(210,$y+30);
    $this->Cell(70, 10, "Including the following payments", 0, 0, 'C');
  }

  function whiteSpace($db) {
    $amount = 1;
    for ($i = 90; $i < $this->getTableEnd(); $i+=10) {
      $this->setXY(10, $i);
      $this->Cell(10, 10, $amount, 1, 0);
      $this->Cell(15, 10, "", 1, 0);
      $this->Cell(10, 10, "", 1, 0, 'C');
      $this->Cell(17.5, 10, "", 1, 0, 'C');
      $this->Cell(17.5, 10, "", 1, 0, 'C');
      $this->Cell(20, 10, "", 1, 0);
      $this->Cell(40, 10, "", 1, 0, 'C');
      $this->Cell(20, 10, "", 1, 0, 'C');
      $this->Cell(20, 10, "", 1, 0, 'C');
      $this->Cell(20, 10, "", 1, 0);
      $result = $db->query("SELECT * FROM commissions WHERE commission_Type = 'Domestic'");
      $x = 90/mysqli_num_rows($result);
      while ($row = $result->fetch_assoc()) {
        $this->Cell($x, 10, "", 1, 0, 'C');
      }
      $amount++;
    }
  }

  function totals($db) {
    $id = $this->getID();
    $this->setXY(10, $this->getTableEnd());
    $result = $db->query("SELECT COUNT(sales_ID) AS blanks FROM sales
                          WHERE staff_ID = '$id' AND sales_Type='Domestic'");
    $row = $result->fetch_assoc();
    $this->Cell(25, 10, 'Nbr of Tkts: '.$row['blanks'], 1, 0, 'C');

  }

  function Populate($db) {
    $this->originalBlanks($db);
    $this->fareAmount($db);
    $this->cash($db);
    $this->card($db);
    $this->TotalPaid($db);
    $this->commissions($db);
    $this->whiteSpace($db);
    $this->totals($db);
  }

  function footer() {
    // Go to 1.5 cm from bottom
    $this->SetY(-35);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->Cell(90, 10, "Prepared By:", 0, 0, 'L');
    $this->Cell(90, 10, "Approved By:", 0, 1, 'L');
    $this->Cell(90, 10, "Checked By:", 0, 0, 'L');
    $this->Cell(90, 10, "Date: ".date('d/m/Y'), 0, 1, 'L');
    $this->Cell(270,10,'Page '.$this->PageNo(),0,0,'R');

  }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->myHeader($db);
$pdf->info();
$pdf->headerTable($db);
$pdf->Populate($db);
$pdf->output();
