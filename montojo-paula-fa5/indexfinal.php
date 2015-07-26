
<head>
<title>Paula Montojo Torrente</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
</head>
<body>
<div id="page">
<div class="titre">
Paula's ITM 544 Page
</div>
<div class="element2">
<div class="form";">
<p><h3>Please enter your information before uploading your file</h3></p>
<form enctype="multipart/form-data" action="resultfinal.php" method="POST">
<input name="name" type="text" placeholder="Your Name" size="40"><p>
<input name="email" type="text" placeholder="Your Email" size="40"><p>
<input name="cellphone" type="text" placeholder="Your Cellphone" size="20"><p>
<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
<input name="userfile" type="file" />
<input type="submit" value="Send File" />
</form>
<hr />
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="gallery.php" method="POST">
Enter Email of user for gallery to browse: <input type="email" name="thisemail">
<input type="submit" value="Load Gallery" />
</form>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
</body>
</html>

