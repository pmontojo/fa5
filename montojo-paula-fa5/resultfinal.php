
<html>
<title>Paula's Result Page</title>
<head>
<?php   
echo"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>".PHP_EOL;
echo"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>".PHP_EOL;
?>
</head>
<body>
<a href='indexfinal.php'>Go to index page</a>
<?php
$ip = $_SERVER['SERVER_ADDR'];
echo "$ip"
?>
<?php
session_start ();

$_SESSION['email'] = $_POST['email'];
$_SESSION['cellphone'] = $_POST['cellphone'];
$uploaddir = '';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
echo "File is valid, and was successfully uploaded.\n";
} else {
echo "Possible file upload attack!\n";
}
//echo 'Here is some more debugging info:';
//print_r($_FILES);
print "</pre>";
// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';
use Aws\S3\S3Client;
$client = S3Client::factory();
$bucket = uniqid("paulamontojobucket", true);
echo "Creating bucket named {$bucket}\n";
$result = $client->createBucket(array(
'Bucket' => $bucket
));
// Wait until the bucket is created
$client->waitUntilBucketExists(array('Bucket' => $bucket));
$key = $uploadfile;
//print "Creating a new object with key $key";
echo "<br />";
$result = $client->putObject(array(
'ACL' => 'public-read',
'Bucket' => $bucket,
'Key' => $key,
'SourceFile' => $uploadfile
));
//echo $result['ObjectURL'] . "<br />";
//echo "<br />";
$url = $result['ObjectURL'];
//echo "Your Name is {$_SESSION['name']}";
//echo "<br />";
echo "<b>Your Email is {$_SESSION['email']}";
echo "</b><br />";
echo "<b>Your phone number is {$_SESSION['cellphone']}";
echo "</b><br />";
echo "<h3> This is the url of your file:".$url."</h3>";

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
//echo "Hello world";

$link = mysqli_connect($endpoint,"pmontojo","pmontojo","thisMyDb") or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}
$create_table = 'CREATE TABLE IF NOT EXISTS items
        (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(200) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        s3rawurl VARCHAR(255) NOT NULL,
        s3finishedurl VARCHAR(255) NOT NULL,
        status INT NOT NULL,
        issubscribed INT NOT NULL,
        PRIMARY KEY(id)
        )';



        $create_tbl = $link->query($create_table);
        if ($create_table) {
        echo "<h3>Table is created or No error returned.</h3>";
        }
        else {
        echo "error!!";
        }
/* Prepared statement, stage 1: prepare */
if (!($stmt = $link->prepare("INSERT INTO items (id, email,phone,filename,s3rawurl,s3finishedurl,status,issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {
echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
$email = $_SESSION['email'];
$phone = $_SESSION['cellphone'];
$s3rawurl = $url; // $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status =0;
$issubscribed=0;
$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);
if (!$stmt->execute()) {
echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
//printf("%d Row inserted.\n", $stmt->affected_rows);
/* explicit close recommended */
$stmt->close();
$link->real_query("SELECT * FROM items");
$res = $link->use_result();
//echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
echo "<b>Element:".$row['id']."</b> \n";
echo "<p>".$row['id'] . " " . $row['email']. " " . $row['phone']."</p>";
}

echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>".PHP_EOL;
echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>".PHP_EOL;
$link->close();
?>
<br>
<h1>This is your image</h1>
<img src="<?php echo $url; ?>" alt="picture">
</body>
</html>


