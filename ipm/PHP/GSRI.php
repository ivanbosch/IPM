<?php

require "../../fpdf182/fpdf.php";
include "connection.php";
session_start();

class myPDF extends FPDF {
  private $tableEnd;
  private $numRows = 0;
  private $total;
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
    $result = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Interline'");
    return mysqli_num_rows($result);
  }

  function getNumRows() {
    return $this->numRows;
  }

  function setNumRows($i) {
    $this->numRows=$i;
  }

  function getTotal() {
    return $this->total;
  }

  function setTotal($i) {
    $this->total=$i;
  }

  function myHeader($db){
    $this->SetFont('Arial','B', 14);
    $this->Cell(270, 10, "Global Sales Report", 0, 1, "C");
    $this->SetFont('Arial','', 12);
    $this->Cell(270, 6, "(INTERLINE - By advisor)", 0, 1, "C");
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
    $this->setXY(10, 50);
    //First Row
    $this->Cell(10,30,'',1,0,'C');
    $this->Cell(60, 10, "Air Via Documents", 1, 0, "C");
    $this->Cell(120, 10, "Forms of Payments", 1, 0, "C");
    $this->Cell(90, 10, "Commissions", 1, 1, "C");
    //Second Row
    $this->Cell(10, 10, "N", 0, 0, 'C');
    $this->Cell(20, 20, "Advisor", 1, 0, 'C');
    $this->Cell(18, 20, "Ticket", 1, 0, 'C');
    $this->Cell(22, 20, "Fare", 1, 0, 'C');
    $this->Cell(20, 20, "Cash", 1, 0, 'C');
    $this->Cell(80, 10, "Credit Cards", 1, 0, 'C');
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 20, "Total Paid", 1, 0, 'C');
    $this->SetFont('Times', 'B', 12);
    $this->Cell(90, 10, "Assessable Amounts", 1, 1, 'C');
    //Third Row
    $this->Cell(10, 10, "", 0, 0);
    $this->Cell(20, 10, "Number", 0, 0, 'C');
    $this->Cell(18, 10, "Amount", 0, 0, 'C');
    $this->Cell(22, 10, "Amount", 0, 0, 'C');
    $this->Cell(20, 10, "", 0, 0);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(40, 10, "Card Payments Received", 1, 0, 'C');
    $this->Cell(20, 10, $this->getCurrency($db, 1), 1, 0, 'C');
    $this->Cell(20, 10, $this->getCurrency($db, 2), 1, 0, 'C');
    $this->Cell(20, 10, "", 0, 0);
    $result = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Interline'");
    $x = 90/mysqli_num_rows($result);
    while ($row = $result->fetch_assoc()) {
      $this->Cell($x, 10, $row['commission_Rate'].'%', 1, 0, 'C');
    }
    $this->Ln();
  }

  function advisorSales($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT staff_ID AS ID, COUNT(sales_ID) AS Amount FROM sales WHERE sales_Type = 'Interline'  AND (currency_ID = '1' OR currency_ID='$currency') GROUP BY staff_ID");
    $y = 80;
    $i = 0;
    $amount = 0;
    //SELECT staff_ID AS ID, currency_ID AS c_ID, currency_Rate AS Rate, sales_Charge AS Charge FROM sales WHERE sales_Type = 'Interline'
    while ($row = $result->fetch_assoc()) {
      $id = $row['ID'];
      $this->setXY(10, $y);
      $this->Cell(10, 10, "", 0, 0);
      $this->Cell(20,10,$id,1,0,'C');
      $this->Cell(18,10,$row['Amount'],1,0,'C');
      $y += 10;
      $amount += $row['Amount'];
      $i++;
    }
    $this->setXY(10, $y);
    $this->Cell(30, 10, "TTLS: " . mysqli_num_rows($result), 1, 0, 'C');
    $this->setXY(40, $y);
    $this->Cell(18, 10, $amount, 1, 0, 'C');
    $this->setNumRows($i);
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function fareAmount($db) {
    $totalLocal = 0;
    $y = 80;
    $currency = $this->getCurrencyVar();
    $advisors = array();
    $result = $db->query("SELECT staff_ID AS ID, currency_ID AS c_ID, currency_Rate AS Rate, sales_Charge AS Charge FROM sales WHERE sales_Type = 'Interline' AND (currency_ID = '1' OR currency_ID='$currency')");
    while ($row = $result->fetch_assoc()) {
      if ($row['c_ID'] == 1) {
        $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
        $fetchRow = $fetchRate->fetch_assoc();
        if (isset($advisors[$row['ID']])){
          $advisors[$row['ID']] += $row['Charge']*$fetchRow['currency_Rate'];
        } else {
          $advisors[$row['ID']] = $row['Charge']*$fetchRow['currency_Rate'];
        }
      } else {
        if (isset($advisors[$row['ID']])){
          $advisors[$row['ID']] += $row['Charge'];
        } else {
          $advisors[$row['ID']] = $row['Charge'];
        }
      }
    }
    foreach ($advisors as $advisor) {
      $this->setXY(58, $y);
      $totalLocal += $advisor;
      $this->Cell(22, 10, $advisor, 1, 0, 'C');
      $y+=10;
    }
    $this->setXY(58, $y);
    $this->Cell(22, 10, $totalLocal, 1, 0, 'C');
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function cash($db) {
    $this->SetFont('Times', '', 10);
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT staff_ID AS ID, sales_Charge AS Charge , payment_Type AS Type, currency_ID AS c_ID FROM sales WHERE sales_Type = 'Interline'  AND (currency_ID = '1' OR currency_ID='$currency')");
    $y = 80;
    $total = 0;
    $advisors = array();
    while ($row = $result->fetch_assoc()) {
      $this->setXY(80, $y);
      if ($row['Type'] != 'Cash') {

      } else {
        if ($row['c_ID'] == 1) { //Was paid in dollars get the current conversion rate
          $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
          $fetchRow = $fetchRate->fetch_assoc();
          if (isset($advisors[$row['ID']])){
            $advisors[$row['ID']] += $row['Charge']*$fetchRow['currency_Rate'];
          } else {
            $advisors[$row['ID']] = $row['Charge']*$fetchRow['currency_Rate'];
          }
        } else { //Was paid in local currency
          if (isset($advisors[$row['ID']])){
            $advisors[$row['ID']] += $row['Charge'];
          } else {
            $advisors[$row['ID']] = $row['Charge'];
          }
        }
      }
    }
    foreach ($advisors as $advisor) {
      $total+=$advisor;
      $this->setXY(80, $y);
      $this->Cell(20, 10, $advisor, 1, 0, 'C');
      $y+=10;
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
      $result = $db->query("SELECT staff_ID AS ID, sales_Charge AS Charge, currency_Rate AS Rate, payment_Type AS Type, currency_ID AS c_ID FROM sales WHERE sales_Type = 'Interline'  AND (currency_ID = '1' OR currency_ID='$currency')");
      $y = 80;
      $x = 0;
      $total = array(3);
      $advisors = array();
      $advisor = array(2);
      while ($row = $result->fetch_assoc()) {
        if ($row['Type'] != 'Card') {

        } else {
          if ($row['c_ID'] == 1) { //Was paid in dollars get the current conversion rate
            $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
            $fetchRow = $fetchRate->fetch_assoc();
            if (isset($advisors[$row['ID']])){ //If it already exists just add
              $advisors[$row['ID']][0]++;
              $advisors[$row['ID']][1]+=$row['Charge'];
              $advisors[$row['ID']][2]+=$row['Charge']*$fetchRow['currency_Rate'];
            } else { //If it doesnt exists create a new one
              $advisor[0] = 1;
              $advisor[1] = $row['Charge'];
              $advisor[2] = $row['Charge']*$fetchRow['currency_Rate'];
              $advisors[$row['ID']] = $advisor;
            }
          } else { //Was paid in local currency
            if (isset($advisors[$row['ID']])){
              $advisors[$row['ID']][0]++;
              $advisors[$row['ID']][1]+=$row['Charge']/$row['Rate'];
              $advisors[$row['ID']][2]+=$row['Charge'];
            } else {
              $advisor[0] = 1;
              $advisor[1] = $row['Charge']/$row['Rate'];
              $advisor[2] = $row['Charge'];
              $advisors[$row['ID']] = $advisor;
            }
          }
        }
      }

      foreach ($advisors as $agent) {
        $x+=$agent[0];
        if(isset($total[1])) {
          $total[1]+=$agent[1];
        } else {
          $total[1]=$agent[1];
        }
        if(isset($total[2])) {
          $total[2]+=$agent[2];
        } else {
          $total[2]=$agent[2];
        }
        $this->setXY(100, $y);
        $this->Cell(40, 10, $agent[0], 1, 0, 'C');
        $this->Cell(20, 10, number_format($agent[1], 2), 1, 0, 'C');
        $this->Cell(20, 10, number_format($agent[2], 2), 1, 0, 'C');
        $y+=10;
      }
      $this->setXY(100, $y);
      $this->Cell(40, 10, $x, 1, 0, 'C');
      $this->Cell(20, 10, number_format($total[1], 2), 1, 0, 'C');
      $this->Cell(20, 10, number_format($total[2], 2), 1, 0, 'C');
      if ($this->getTableEnd() < $y) {
        $this->setTableEnd($y);
      }
  }

  function TotalPaid($db) {
    $this->SetFont('Times', '', 10);
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT staff_ID AS ID, sales_Charge AS Charge , payment_Type AS Type, currency_ID AS c_ID FROM sales WHERE sales_Type = 'Interline' AND (currency_ID = '1' OR currency_ID='$currency')");
    $y = 80;
    $total = 0;
    $advisors = array();
    while ($row = $result->fetch_assoc()) {
      if ($row['c_ID'] == 1) { //Was paid in dollars get the current conversion rate
        $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
        $fetchRow = $fetchRate->fetch_assoc();
        if (isset($advisors[$row['ID']])){
          $advisors[$row['ID']] += $row['Charge']*$fetchRow['currency_Rate'];
        } else {
          $advisors[$row['ID']] = $row['Charge']*$fetchRow['currency_Rate'];
        }
      } else { //Was paid in local currency
          if (isset($advisors[$row['ID']])){
            $advisors[$row['ID']] += $row['Charge'];
          } else {
            $advisors[$row['ID']] = $row['Charge'];
          }
        }
      }
    foreach ($advisors as $advisor) {
      $total+=$advisor;
      $this->setXY(180, $y);
      $this->Cell(20, 10, $advisor, 1, 0, 'C');
      $y+=10;
    }
    $this->setXY(180, $y);
    $this->Cell(20, 10, $total, 1, 0, 'C');
    $this->setTotal($total);
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function commissions($db) {
    $this->SetFont('Times', '', 10);
    $y = 80;
    $currency = $this->getCurrencyVar();
    $advisors=array();
    $fetchRate = $db->query("SELECT currency_Rate from currency WHERE currency_ID = $currency");
    $fetchRow = $fetchRate->fetch_assoc();
    $usdRate = $fetchRow['currency_Rate'];
    $result = $db->query("SELECT staff_ID AS ID, sales_Charge AS Charge, commission_Rate AS Rate, currency_ID AS c_ID FROM sales WHERE sales_Type = 'Interline'");
    $commissions = $db->query("SELECT commission_Rate FROM commissions WHERE commission_Type = 'Interline'");
    $commissionTotal= array();
    while ($com = $commissions->fetch_assoc()) {
      $commissionTotal[$com['commission_Rate']] = 0;
    }
    $columns = $this->getCommissions($db);
    $width = 90/$columns;
    while ($row = $result->fetch_assoc()) {
      if (isset($advisors[$row['ID']])) { //no Need to create one
        if ($row['c_ID'] == 1) { //Was paid in dollars get the current conversion rate
          $commissionTotal[$row['Rate']]=$row['Charge']*$usdRate;
        } else { //Was paid in local currency
          $commissionTotal[$row['Rate']]=$row['Charge'];
        }
        if (isset($advisors[$row['ID']][$row['Rate']])){
          $advisors[$row['ID']][$row['Rate']] += $commissionTotal[$row['Rate']];
        } else {
          $advisors[$row['ID']][$row['Rate']] = $commissionTotal[$row['Rate']];
        }
      } else { //Create a advisor in the advisors array
        if ($row['c_ID'] == 1) { //Was paid in dollars get the current conversion rate
          $commissionTotal[$row['Rate']]=$row['Charge']*$usdRate;
        } else { //Was paid in local currency
          $commissionTotal[$row['Rate']]=$row['Charge'];
        }
        $advisors[$row['ID']][$row['Rate']] = $commissionTotal[$row['Rate']];
      }
    }
    $keys = array_keys($commissionTotal);
    $total = array();
    foreach ($advisors as &$agent) {
      $j = 0;
      foreach ($keys as $key) {
        $this->setXY(200+($width*$j), $y);
        if (isset($agent[$key])) {
          $this->Cell($width, 10, $agent[$key], 1, 0, 'C');
          if (isset($total[$key])) {
            $total[$key] += $agent[$key];
          } else {
            $total[$key] = $agent[$key];
          }
        } else {
          $this->Cell($width, 10, "", 1, 0);
        }
        $j++;
      }
      $y+=10;
    }
    $n = 0;
    $this->setXY(155,$y+10);
    $this->Cell(45, 10, "Total Commission Amount", 1, 0, 'C');
    $this->setXY(155,$y+20);
    $this->Cell(45, 10, "Net Amounts for Agent's Debit", 1, 0, 'C');
    foreach ($keys as $key => $c) {
      if (isset($total[$c])) {
        $this->setXY(200+($width*$n), $y);
        $this->Cell($width, 10, $total[$c], 1, 0, 'C');
        $this->setXY(200+($width*$n), $y+10);
        $this->Cell($width, 10, number_format($total[$c]*$c/100, 2), 1, 0, 'C');
        $this->setXY(200+($width*$n), $y+20);
        $this->Cell($width, 10, number_format($total[$c]-($total[$c]*$c/100), 2), 1, 0, 'C');
        $this->setTotal($this->getTotal()-(($total[$c]*$c/100)));
      } else {
        $this->setXY(200+($width*$n), $y);
        $this->Cell($width, 10, "", 1, 0, 'C');
        $this->setXY(200+($width*$n), $y+10);
        $this->Cell($width, 10, "", 1, 0, 'C');
        $this->setXY(200+($width*$n), $y+20);
        $this->Cell($width, 10, "", 1, 0, 'C');
      }
      $n++;
    }
    $y+=35;
    $this->setXY(140,$y);
    $this->SetFont('Times', '', 10);
    $this->Cell(70, 5, "Total Net Amount for", 0, 2, 'C');
    $this->Cell(70, 5, "Bank remittence to Air Via", 0, 0, 'C');
    $this->setXY(190,$y);
    $this->Cell(30, 10, number_format($this->getTotal()), 0, 0, 'C');
    $this->setXY(210,$y);
    $this->Cell(70, 10, "Including the following payments", 0, 0, 'C');

  }

  function whitespace($db) {
    $amount = 1;
    $result = $db->query("SELECT staff_ID AS ID, COUNT(sales_ID) AS Amount FROM sales WHERE sales_Type = 'Interline' GROUP BY staff_ID");
    while ($row = $result->fetch_assoc()) {
      $this->setXY(10, 70+(10*$amount));
      $this->Cell(10, 10, $amount, 1, 0);
      $amount++;
    }
  }

  function Populate($db) {
    $this->advisorSales($db);
    $this->fareAmount($db);
    $this->cash($db);
    $this->card($db);
    $this->TotalPaid($db);
    $this->commissions($db);
    $this->whitespace($db);
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
