<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>ユーザー名変更</title>
</head>
<body>
<?php

session_start();
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    echo "ログイン済みです。あなたのユーザIDは $uid です";
} else {
    echo "ログインしていないので、アクセスできません。";
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


if(!empty($_POST["userName"]) && !empty($_POST["userName1"]) && !empty($_POST["userName2"])){

    $userName = $_POST["userName"];
	$userName1 = $_POST["userName1"];
	$userName2 = $_POST["userName2"];


    $sql = "select userName from users where uid = $uid"; 

    $result = $mysqli->query($sql); 
    /* if( $result->num_rows == 0){
        echo "ユーザ名「${userName}」は登録されていません。<br>";
        exit();
    }*/
    $row = $result->fetch_assoc(); 
    $db_enc_uname = $row["userName"]; 
	$result->close(); 
	
    if(($db_enc_uname == $userName) && ($userName1 == $userName2)){
		$sql = "update users set userName = '$userName1' where uid = $uid";
		$result = $mysqli->query($sql); 
		if ($result) { 
			 echo "新しいユーザー名に変更されました。<br>";
		} else {
			echo "データの登録に登録に失敗しました";
			echo "SQL文：$sql";
			echo "エラー番号：$mysqli->error";
			echo "エラーメッセージ：$mysqli->error";
			exit();
		}
    } else {
        echo "認証できませんでした。ユーザー名を変更できません。<br>";
        exit();
    }

    //$result->close(); 
    $mysqli->close(); 
} else {
    echo "入力されていない項目があります。<br>";
	echo "<a href=\"ch_userName_input.html\">戻る</a><br>";
}
?>
	<br>
	<a href="message_auth.php">掲示板へ</a>
</body>
</html>