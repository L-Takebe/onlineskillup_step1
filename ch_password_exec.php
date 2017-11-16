<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>パスワード変更</title>
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

// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli($host,$user,$pass,$dbname);
    if ($mysqli->connect_error) { //接続エラーになった場合
    echo $mysqli->connect_error; //エラーの内容を表示
    exit();//終了
	} else {
		//echo "You are connected to the DB successfully.<br>"; //正しく接続できたことを確認
		$mysqli->set_charset("utf8"); //文字コードを設定
	}


//================================================


//入力データの受取
if(!empty($_POST["password"]) && !empty($_POST["new_pass"]) && !empty($_POST["new_pass_k"])){
	
    //POSTされた変数の受取
    $password = $_POST["password"];
	$npass = $_POST["new_pass"];
	$npassk = $_POST["new_pass_k"];


    //ユーザ名が既に使用されているかのチェック
    $sql = "select password from users where uid = $uid"; //実行するSQLを文字列として記述

    $result = $mysqli->query($sql); //SQL文の実行
    $row = $result->fetch_assoc(); //結果から一行づつ読み込み
    $db_enc_passwd = $row["password"]; //データベースからパスワード読み込み

    if((password_verify($password, $db_enc_passwd)) && ($npass == $npassk)){
		$enc_passwd = password_hash($npass,PASSWORD_DEFAULT);
		$sql = "update users set password = '$enc_passwd' where uid = $uid";
		$result = $mysqli->query($sql); //SQL文の実行
        echo "新しいパスワードに変更されました。<br>";
    } else {
        echo "認証できませんでした。パスワードを変更できません。<br>";
		echo "<a href=index.html>戻る</a><br>";
        exit();
    }

    //$result->close(); // 結果セットを閉じる
    $mysqli->close(); // 接続を閉じる
} else {
    echo "入力されていない項目があります。<br>";
	echo "<a href=ch_password_input.html>戻る</a><br>";
}
	
?>
	<br>
	<a href=message_auth.php>掲示板へ</a>
</body>
</html>