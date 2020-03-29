<?php

require "../../fpdf182/fpdf.php";
include "connection.php";


class myPDF extends FPDF{
  private $tableEnd;

  function getTableEnd() {
    return $this->tableEnd;
  }

  function setTableEnd($y) {
    $this->tableEnd = $y;
  }

  function header(){
    $this->SetFont('Arial','B', 14);
    $this->Cell(270, 10, "Agent's Stock Status Report", 0, 1, "C");
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

  function headerTable() {
    $this->SetFont('Times', 'B', 12);
    $this->setXY(10, 45);
    $this->Cell(10,30,'',1,0,'C');
    $this->Cell(90,10,'Received Blanks',1,0,'C');
    $this->Cell(90,10,'Assigned/Used Blanks',1,0,'C');
    $this->Cell(90,10,'Final Amounts',1,1,'C');
    $this->Cell(10,10,'NN',0,0,'C');
    $this->Cell(45,10,"Agent's Stock",1,0,'C');
    $this->Cell(45,10,"Sub Agents'",1,0,'C');
    $this->Cell(90,10,"(Sub Agents')",1,0,'C');
    $this->Cell(45,10,"Agent's Amount",1,0,'C');
    $this->Cell(45,10,"Sub Agents' Amounts",1,1,'C');
    $this->SetFont('Times', '', 10);
    $this->Cell(10,10,'',0,0,'C');
    $this->Cell(35,10,'New Blanks',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Cell(10,10,'Code',1,0,'C');
    $this->Cell(25,10,'Blanks Assigned',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Cell(10,10,'Code',1,0,'C');
    $this->Cell(25,10,'Existing Assigned',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Cell(35,10,'Used Blanks',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Cell(35,10,'Blanks Available',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Cell(10,10,'Code',1,0,'C');
    $this->Cell(25,10,'Blanks',1,0,'C');
    $this->Cell(10,10,'Amnt',1,0,'C');
    $this->Ln();
  }

  function AgentsStock($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $result = $db->query("SELECT blank_Type, COUNT(blank_ID) AS second FROM blanks WHERE blank_Date LIKE '%$date' GROUP BY blank_Type");
    $y = 75;
    while ($row = $result->fetch_assoc()) {
      unset($type, $second);
      $type = $row['blank_Type'];
      $second = $row['second'];
      $this->setXY(10, $y);
      $this->Cell(10, 10, "", 1, 0);
      $this->Cell(35,10,$type,1,0,'C');
      $this->Cell(10,10,$second,1,1,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function subAgents($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $result = $db->query("SELECT blank_Advisor_ID, blank_Type, COUNT(blank_ID) AS second FROM blanks WHERE blank_Date LIKE '%$date' AND blank_Advisor_ID IS NOT NULL GROUP BY blank_Advisor_ID, blank_Type");
    $y=75;
    while ($row = $result->fetch_assoc()) {
      $advisor = $row['blank_Advisor_ID'];
      $type = $row['blank_Type'];
      $second = $row['second'];
      $this->setXY(65, $y);
      $this->Cell(10,10,$advisor,1,0,'C');
      $this->Cell(25,10,$type,1,0,'C');
      $this->Cell(10,10,$second,1,0,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function assignedBlanks($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY');
    $assigned = $db->query("SELECT blank_Advisor_ID, blank_Type, COUNT(blank_ID) AS count FROM blanks WHERE blank_Advisor_ID is not null AND blank_Date NOT LIKE '%$date' GROUP by blank_Advisor_ID, blank_Type");
    $y = 75;
    while ($result = $assigned->fetch_assoc()) {
      unset($advisor, $type, $count);
      $advisor = $result['blank_Advisor_ID'];
      $type = $result['blank_Type'];
      $count = $result['count'];
      $this->setXY(110, $y);
      $this->Cell(10,10,$advisor,1,0,'C');
      $this->Cell(25,10,$type,1,0,'C');
      $this->Cell(10,10,$count,1,0,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function usedBlanks($db) {
    $this->SetFont('Times', '', 10);
    $result = $db->query("SELECT blank_Type, COUNT(blank_ID) as count FROM blanks WHERE EXISTS (SELECT * FROM coupons WHERE blanks.blank_ID = coupons.blank_ID) GROUP BY blank_Type;");
    $y=75;
    while ($row = $result->fetch_assoc()) {
      $type = $row['blank_Type'];
      $count = $row['count'];
      $this->setXY(155, $y);
      $this->Cell(35,10,$type,1,0,'C');
      $this->Cell(10,10,$count,1,0,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function agentsAmount($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY', strtotime('+1 month'));
    $result = $db->query("SELECT blank_Type, COUNT(blank_ID) AS count FROM blanks WHERE blank_Date NOT LIKE '%$date' GROUP BY blank_Type");
    $y = 75;
    while ($row = $result->fetch_assoc()) {
      unset($type, $count);
      $type = $row['blank_Type'];
      $count = $row['count'];
      $this->setXY(200, $y);
      $this->Cell(35,10,$type,1,0,'C');
      $this->Cell(10,10,$count,1,1,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function subAgentsAmount($db) {
    $this->SetFont('Times', '', 10);
    $date = date('mY', strtotime('+1 month'));
    $assigned = $db->query("SELECT blank_Advisor_ID, blank_Type, COUNT(blank_ID) AS count FROM blanks WHERE blank_Advisor_ID is not null AND blank_Date NOT LIKE '%$date' GROUP by blank_Advisor_ID, blank_Type");
    $y = 75;
    while ($result = $assigned->fetch_assoc()) {
      unset($advisor, $type, $count);
      $advisor = $result['blank_Advisor_ID'];
      $type = $result['blank_Type'];
      $count = $result['count'];
      $this->setXY(245, $y);
      $this->Cell(10,10,$advisor,1,0,'C');
      $this->Cell(25,10,$type,1,0,'C');
      $this->Cell(10,10,$count,1,0,'C');
      $y += 10;
    }
    if ($this->getTableEnd() < $y) {
      $this->setTableEnd($y);
    }
  }

  function totals($db) {
    $this->setXY(10, $this->getTableEnd());
    $this->Cell(280, 10, "TOTALS", 1, 0, 'L');
    $date = date('mY');
    $y = $this->getTableEnd();
    $x = 55;
    //First Total
    $Total = $db->query("SELECT COUNT(blank_ID) AS count FROM blanks WHERE blank_Date LIKE '%$date'");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
    //Second Total
    $Total = $db->query("SELECT COUNT(blank_ID) AS count FROM blanks WHERE blank_Date LIKE '%$date' AND blank_Advisor_ID IS NOT NULL");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
    //Third total
    $Total = $db->query("SELECT COUNT(blank_ID) AS count FROM blanks WHERE blank_Advisor_ID is not null AND blank_Date NOT LIKE '%$date'");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
    //Fourth total
    $Total = $db->query("SELECT COUNT(blank_ID) as count FROM blanks WHERE EXISTS (SELECT * FROM coupons WHERE blanks.blank_ID = coupons.blank_ID)");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
    //Fifth total
    $date = date('mY', strtotime('+1 month'));
    $Total = $db->query("SELECT COUNT(blank_ID) AS count FROM blanks WHERE blank_Date NOT LIKE '%$date'");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
    //Sixth total
    $Total = $db->query("SELECT COUNT(blank_ID) AS count FROM blanks WHERE blank_Advisor_ID is not null AND blank_Date NOT LIKE '%$date'");
    $Result = $Total->fetch_assoc();
    $this->setXY($x, $y);
    $this->Cell(10, 10, $Result['count'], 1, 0, 'C');
    $x+= 45;
  }

  function whiteSpace() {
    $amount = 1;
    for ($i = 75; $i < $this->getTableEnd(); $i+=10) {
      $this->setXY(10, $i);
      $this->Cell(10,10,$amount,1,0,'C');
      $this->Cell(35,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(25,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(25,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(35,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(35,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $this->Cell(25,10,'',1,0,'C');
      $this->Cell(10,10,'',1,0,'C');
      $amount++;
    }
  }

  function Populate($db) {
    $this->AgentsStock($db);
    $this->subAgents($db);
    $this->assignedBlanks($db);
    $this->usedBlanks($db);
    $this->agentsAmount($db);
    $this->subAgentsAmount($db);
    $this->whiteSpace();
  }

  function footer(){
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
$pdf->info();
$pdf->headerTable();
$pdf->Populate($db);
$pdf->totals($db);
$pdf->output();
