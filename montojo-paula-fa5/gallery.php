<html>
<title>Gallery</title>
<body>

<?php
session_start();
$_SESSION['email'] = $_POST['thisemail'];
$email = $_SESSION['email'];
echo "<h1>these are the pictures uploaded by user: ". $email. "</h1>";

require 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'region' => 'us-west-2'
));
$result = $client->describeDBInstances(array(
'DBInstanceIdentifier' => 'dbmyinstance',
));
$endpoint = "";

foreach ($result->getPath('DBInstances/*/Endpoint/Address') as $ep) {
// Do something with the message
//echo "============". $ep . "================";
$endpoint = $ep;
}

//echo "begin database";
$link = mysqli_connect($endpoint,"pmontojo","pmontojo","thisMyDb") or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}
//below line is unsafe - $email is not checked for SQL injection -- don't do this in real life or use an ORM instead
$link->real_query("SELECT * FROM items WHERE email = '$email'");
//$link->real_query("SELECT * FROM items");
$res = $link->use_result();
//echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
echo "<img src =\" " . $row['s3rawurl'] . "\" /><img src =\"" .$row['s3finishedurl'] . "\"/>";

}
$link->close();
?>
</body>
</html>
