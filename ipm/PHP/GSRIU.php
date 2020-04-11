<?php

require "../../fpdf182/fpdf.php";
include "connection.php";
session_start();

class myPDF extends FPDF {
  private $tableEnd;
  private $numRows = 0;
  private $totalUSD;
  private $totalARS;
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

  function getNumRows() {
    return $this->numRows;
  }

  function setNumRows($i) {
    $this->numRows=$i;
  }

  function getTotalUSD() {
    return $this->totalUSD;
  }

  function setTotalUSD($i) {
    $this->totalUSD=$i;
  }

  function getTotalARS() {
    return $this->totalARS;
  }

  function setTotalARS($i) {
    $this->totalARS=$i;
  }

  function myHeader($db){
    $this->SetFont('Arial','B', 14);
    $this->Cell(270, 10, "Global Sales Report", 0, 1, "C");
    $this->SetFont('Arial','', 12);
    $this->Cell(270, 6, "(INTERLINE - By USD Rate)", 0, 1, "C");
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
    $this->Cell(10, 20, "N", 1, 0, 'C');
    $this->Cell(20, 20, "Rate", 1, 0, 'C');
    $this->Cell(40, 20, "Tickets Sold", 1, 0, 'C');
    $this->Cell(20, 20, "Total Paid", 1, 0, 'C');
    $this->Cell(30, 20, "Current", 1, 0, 'C');
    $this->Cell(30, 20, "Current", 1, 0, 'C');
    $this->setXY(100, 70);
    $this->Cell(30, 10, "USD Amount", 0, 0, 'C');
    $this->Cell(30, 10, "ARS Amount", 0, 0, 'C');
    $this->setXY(170, 60);
    $this->Cell(115, 10, "Local Currency Payments", 1, 2, 'C');
    $this->Cell(35, 10, "Current USD Rate", 1, 0, 'C');
    $this->Cell(20, 10, "Tkts Sold", 1, 0, 'C');
    $this->Cell(30, 10, "USD Total", 1, 0, 'C');
    $this->Cell(30, 10, "ARS Total", 1, 0, 'C');
  }

  function rateSales($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $currency = $this->getCurrencyVar();
    $result = $db->query("SELECT currency_Rate AS Rate, COUNT(sales_ID) AS Amount, SUM(sales_Charge) AS Charge FROM sales WHERE sales_Type = 'Interline'  AND currency_ID = '1' GROUP BY currency_Rate");
    $sql = $db->query("SELECT currency_Rate AS Rate FROM currency WHERE currency_ID='2'");
    $currentARS = $sql->fetch_assoc();
    $sql = $db->query("SELECT currency_Rate AS Rate FROM currency WHERE currency_ID='1'");
    $currentUSD = $sql->fetch_assoc();
    $y = 80;
    $i = 0;
    $amount = 0;
    $totalUSD = 0;
    $totalARS = 0;
    while ($row = $result->fetch_assoc()) {
      $Rate = $row['Rate'];
      $this->setXY(10, $y);
      $this->Cell(10, 10, "", 0, 0);
      $this->Cell(20,10,$Rate,1,0,'C');
      $this->Cell(40,10,$row['Amount'],1,0,'C');
      $usd = $row['Charge']*$row['Rate'];
      $ars = $row['Charge']*$row['Rate']*$currentARS['Rate'];
      $this->Cell(20,10,$row['Charge'],1,0,'C');
      $this->Cell(30,10,$usd,1,0,'C');
      $this->Cell(30,10,number_format($ars, 2),1,0,'C');
      $y += 10;
      $amount += $row['Amount'];
      $totalUSD += $usd;
      $totalARS += $ars;
      $i++;
    }

    $this->setXY(10, $y);
    $this->Cell(30, 10, "TTLS: " . mysqli_num_rows($result), 1, 0, 'C');
    $this->setXY(40, $y);
    $this->Cell(40, 10, $amount, 1, 0, 'C');
    $this->setXY(100, $y);
    $this->Cell(30, 10, number_format($totalUSD), 1, 0, 'C');
    $this->setXY(130, $y);
    $this->Cell(30, 10, number_format($totalARS), 1, 0, 'C');

    $this->setTotalUSD($totalUSD);
    $this->setTotalARS($totalARS);

    $this->setNumRows($i);
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function localSales($db) {
    $this->SetFont('Times', '', 10);
    $sql = $db->query("SELECT currency_Rate AS Rate FROM currency WHERE currency_ID='2'");
    $currentARS = $sql->fetch_assoc();
    $sql = $db->query("SELECT currency_Rate AS Rate FROM currency WHERE currency_ID='1'");
    $currentUSD = $sql->fetch_assoc();
    $y = 80;
    $i = 0;
    $amount = 0;
    $totalUSD = 0;
    $totalARS = 0;

    $result = $db->query("SELECT COUNT(sales_ID) AS Amount, SUM(sales_Charge) AS Charge FROM sales WHERE sales_Type = 'Interline'  AND currency_ID = '2'");
    $today = $result->fetch_assoc();
    $this->setXY(170, $y);
    $this->Cell(35,10,$currentUSD['Rate'],1,0,'C');
    $this->Cell(20,10,$today['Amount'],1,0,'C');
    $this->Cell(30,10,number_format($today['Charge']*$currentUSD['Rate']),1,0,'C');
    $this->Cell(30,10,number_format($today['Charge']),1,0,'C');
    $this->setTotalUSD($this->getTotalUSD()+($today['Charge']*$currentUSD['Rate']));
    $this->setTotalARS($this->getTotalARS()+$today['Charge']);
    $y+=20;
    $this->setXY(170, $y);
    $this->Cell(35,10,"Total Sold in USD:",0,0,'C');
    $this->Cell(20,10,number_format($this->getTotalUSD()),0,0,'C');
    $y+=10;
    $this->setXY(170, $y);
    $this->Cell(35,10,"Total Sold in ARS",0,0,'C');
    $this->Cell(20,10,number_format($this->getTotalARS()),0,0,'C');
  }



  function whitespace($db) {
    $amount = 1;
    $result = $db->query("SELECT currency_Rate AS ID, COUNT(sales_ID) AS Amount FROM sales WHERE sales_Type = 'Interline'AND currency_ID = '1' GROUP BY currency_Rate");
    while ($row = $result->fetch_assoc()) {
      $this->setXY(10, 70+(10*$amount));
      $this->Cell(10, 10, $amount, 1, 0);
      $amount++;
    }
  }

  function Populate($db) {
    $this->rateSales($db);
    $this->localSales($db);
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
