<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>ログイン認証</title>
</head>
<body>
<?php

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

//入力データの受取
if(!empty($_POST["userName"]) && !empty($_POST["password"])){

    //POSTされた変数の受取
    $userName = $_POST["userName"];
    $password = $_POST["password"];


    //ユーザ名が既に使用されているかのチェック
    $sql = "select password,uid from users where userName = '$userName'"; //実行するSQLを文字列として記述

    $result = $mysqli->query($sql); //SQL文の実行
    if( $result->num_rows == 0){
        echo "ユーザ名「${userName}」は登録されていません。<br>";
		echo "<a href=user_reg_input.html>まだアカウントのない人はこちら</a>";
        exit();
    }
    $row = $result->fetch_assoc(); //結果から一行づつ読み込み
    $db_enc_passwd = $row["password"]; //データベースからパスワード読み込み
    $uid = $row["uid"]; //データベースからUIDを取得
    if(password_verify($password, $db_enc_passwd)) {
        echo "ユーザ「${userName}」が正しく認証されました。<br>";
        //セッション開始
        session_start(); //セッションを開始する
        $_SESSION['uid'] = $uid; //セッション変数uidにデータベースから取得したUIDを登録
    } else {
        echo "ユーザ「${userName}」を認証できませんでした。パスワードが一致しません。<br>";
        exit();
    }

    $result->close(); // 結果セットを閉じる
    $mysqli->close(); // 接続を閉じる
	echo "掲示板へ移動<br>
	<a href=message_auth.php>掲示板</a>";
		
	/*echo "掲示板へ移動
	<form action=message_auth.php method=post>
    <input type=hidden name=number value=1>
    <a href=message_auth.php>掲示板1</a>
</form><br>
	<form actionmessage_auth.php method=post>
    <input type=hidden name=number value=2>
    <a href=message_auth.php>掲示板2</a>
</form><br>";
*/
} else {
    echo "入力されていない項目があります。<br>";
}
?>
</body>
</html>