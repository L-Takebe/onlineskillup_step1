<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>パスワード変更</title>
</head>
<body>
	<div class="wrap">
<?php

session_start();
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    echo "ログイン済みです。あなたのユーザIDは $uid です";
} else {
    echo "ログインしていないので、アクセスできません。";
	echo "<a href=\"index.html\">TOPページへ</a><br>"
    exit();
}

$host = 'localhost'; 
$user = 'ltlabo_board'; 
$pass = '1201'; 
$dbname = 'ltlabo_board';


$mysqli = new mysqli($host,$user,$pass,$dbname);
    if ($mysqli->connect_error) { 
    echo $mysqli->connect_error; 
    exit();
	} else {
		$mysqli->set_charset("utf8"); 
	}


//================================================


if(!empty($_POST["password"]) && !empty($_POST["new_pass"]) && !empty($_POST["new_pass_k"])){
	
    
    $password = $_POST["password"];
	$npass = $_POST["new_pass"];
	$npassk = $_POST["new_pass_k"];


    $sql = "select password from users where uid = $uid"; 

    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc(); 
    $db_enc_passwd = $row["password"]; 

    if((password_verify($password, $db_enc_passwd)) && ($npass == $npassk)){
		$enc_passwd = password_hash($npass,PASSWORD_DEFAULT);
		$sql = "update users set password = '$enc_passwd' where uid = $uid";
		$result = $mysqli->query($sql); 
        echo "新しいパスワードに変更されました。<br>";
    } else {
        echo "認証できませんでした。パスワードを変更できません。<br>";
		echo "<a href=\"ch_password_exec.html\">戻る</a><br>";
        exit();
    }

    //$result->close(); 
    $mysqli->close(); 
} else {
    echo "入力されていない項目があります。<br>";
	echo "<a href=\"ch_password_input.html\">戻る</a><br>";
}
	
?>
		<div class="move">
	<br>
	掲示板へ移動<br>
	<a href="message_auth.php?number=掲示板1">掲示板1</a>
<br>
	
<a href="message_auth.php?number=掲示板2">掲示板2</a>
<br>
		</div>
	</div>
</body>
</html>