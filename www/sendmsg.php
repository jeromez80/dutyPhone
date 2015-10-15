<html>
<head>
<title>Send SMS Form</title>
</head>
<body>
<form method="POST" action="messageAPI.php">
<input type="radio" name="desttype" value="dutynum" checked>Current DutyNumber - WhatsApp Only</input>
<br>
<input type="radio" name="desttype" value="destsms">Specific destination by SMS</input>
<input type="radio" name="desttype" value="destwa">Specific destination by WhatsApp</input>
<br>
Specific Destination Number: <input type="text" name="destnumber" value="+65">
<br>
<input type="radio" name="desttype" value="destwagc">Whatsapp GroupChat</input>
<hr>
<input type="text" name="destMsg" value="text">
<input type="submit">
</form>
</body>
</html>
