<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>ログアウト</title>
</head>
  
<body>
<?php

session_start();
$_SESSION = array();
if (isset($_COOKIE["PHPSESSID"])) {
  setcookie("PHPSESSID", '', time() - 1800, '/');
}

session_destroy();
	?>
	ログアウトが完了しました。<br>
	<a href="index.html">TOPページへ</a>
</body>
</html>