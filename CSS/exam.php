<!DOCTYPE html>
<html>
<body>

<?php



?>

<h2>HTML Forms</h2>

<form action="action_page.php" method="POST">
  <label for="Cname">Customer name:</label><br>
  <input type="text" id="Cname" name="Cname"><br>
  <label for="ACNumber">Account Number:</label><br>
  <input type="text" id="ACNumber" name="ACNumber"><br><br>
  <label for="NetAccount">Domestic Solar Ower Plant:</label><br>
  <input type="radio" id="NetAccount" name="NetAccount" value="Net Metering">
  <label for="NetMetering">Net Metering</label><br>
  <input type="radio" id="NetAccount" name="NetAccount" value="Net Accounting">
  <label for="NetAccount">Net Accounting</label><br>
  <label for="lname">Unit Consumed per Month:</label><br>
  <input type="text" id="ConsumUnit" name="ConsumUnit"><br><br>
  <label for="lname">Unit Generated form Solar Power:</label><br>
  <input type="text" id="GenUnitSolar" name="GenUnitSolar"><br><br>
  <input type="submit" value="Calculate">
</form> 


</body>
</html>