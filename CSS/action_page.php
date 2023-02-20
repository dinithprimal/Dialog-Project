<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<?php
    $ConsumeUnit = $_POST['ConsumUnit'];
    $GeneratedUnit = $_POST['GenUnitSolar'];

    if($_POST['NetAccount'] == "Net Accounting"){

        $netTotGenerated = $GeneratedUnit*22;

        $netTotConsume = 0;

        if($ConsumeUnit>124){
            $netTotConsume = $netTotConsume + ($ConsumeUnit - 124)*32;
            $netTotConsume = $netTotConsume + 31*28;
            $netTotConsume = $netTotConsume + 31*10;
            $netTotConsume = $netTotConsume + 31*9;
            $netTotConsume = $netTotConsume + 31*8;
        }else if($ConsumeUnit>93){
            $netTotConsume = $netTotConsume + ($ConsumeUnit - 93)*28;
            $netTotConsume = $netTotConsume + 31*10;
            $netTotConsume = $netTotConsume + 31*9;
            $netTotConsume = $netTotConsume + 31*8;
        }else if($ConsumeUnit>62){
            $netTotConsume = $netTotConsume + ($ConsumeUnit - 62)*10;
            $netTotConsume = $netTotConsume + 31*9;
            $netTotConsume = $netTotConsume + 31*8;
        }else if($ConsumeUnit>31){
            $netTotConsume = $netTotConsume + ($ConsumeUnit - 31)*9;
            $netTotConsume = $netTotConsume + 31*8;
        }else{
            $netTotConsume = $ConsumeUnit*8;
        }

        $TotalPayable = $netTotConsume-$netTotGenerated;

    }else{
        if($ConsumeUnit>$GeneratedUnit){
            $netTotGenerated = "-";
            $netTotConsume = 0;
            $unit = $ConsumeUnit - $GeneratedUnit;
            if($unit>124){
                $netTotConsume = $unit + ($unit - 124)*32;
                $netTotConsume = $unit + 31*28;
                $netTotConsume = $unit + 31*10;
                $netTotConsume = $unit + 31*9;
                $netTotConsume = $unit + 31*8;
            }else if($ConsumeUnit>93){
                $netTotConsume = $unit + ($unit - 93)*28;
                $netTotConsume = $unit + 31*10;
                $netTotConsume = $unit + 31*9;
                $netTotConsume = $unit + 31*8;
            }else if($ConsumeUnit>62){
                $netTotConsume = $unit + ($ConsumeUnit - 62)*10;
                $netTotConsume = $unit + 31*9;
                $netTotConsume = $unit + 31*8;
            }else if($ConsumeUnit>31){
                $netTotConsume = $unit + ($ConsumeUnit - 31)*9;
                $netTotConsume = $unit + 31*8;
            }else{
                $netTotConsume = $unit*8;
            }

            $TotalPayable = $netTotConsume;
        }
    }
?>

Electricity bill of Account Number : <?php  echo $_POST['ACNumber']; ?><br><br>

Customer Name : <?php   echo $_POST['Cname']; ?><br>
Domestic Solar Power : <?php   echo $_POST['NetAccount']; ?><br><br>

<table>
  <tr>
    <th>Description</th>
    <th>Unit</th>
    <th>Amount</th>
  </tr>
  <tr>
    <td>Consumed Electricity</td>
    <td><?php echo  $_POST['ConsumUnit'];   ?></td>
    <td><?php echo  $netTotConsume;   ?></td>
  </tr>
  <tr>
    <td>Genrated Electricity</td>
    <td><?php echo  $_POST['GenUnitSolar'];   ?></td>
    <td><?php echo  $netTotGenerated;   ?></td>
  </tr>
  <tr>
    <td>Total Payable</td>
    <td></td>
    <td><?php echo  $netTotConsume;   ?></td>
  </tr>
</table>

</body>
</html>