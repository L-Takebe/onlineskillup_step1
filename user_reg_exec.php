<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">
<title>新規ユーザ登録</title>
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
if(!empty($_POST["userName"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])){

    //POSTされた変数の受取
    $userName = $_POST["userName"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    //ユーザ名が既に使用されているかのチェック
    $sql = "select * from users where userName = '$userName'"; //実行するSQLを文字列として記述

    $result = $mysqli->query($sql); //SQL文の実行
    if( $result->num_rows != 0){
        echo "ユーザ名「${userName}」はすでに登録されているため使用できません。<br>";
        exit();
    }

    //パスワードが一致するかのチェック
    if($password1 != $password2) {
        echo "パスワードが一致しません<br>";
        exit();
    }
    //パスワードの暗号化
    $enc_passwd = password_hash($password1,PASSWORD_DEFAULT); //ソルトを使ったパスワードの暗号化

    //ユーザの登録
    $sql = "insert into users (userName, password) values ('$userName','$enc_passwd')"; //実行するSQLを文字列として記述

    $result = $mysqli->query($sql); //SQL文の実行
    if ($result) { //SQL実行のエラーチェック
        echo "ユーザ「${userName}」の登録に成功しました <br>";
    } else {
        echo "データの登録に登録に失敗しました <br>";
        echo "SQL文：$sql <br>"; //本当は表示しないほうがいい
        echo "エラー番号：$mysqli->error <br>";
        echo "エラーメッセージ：$mysqli->error <br>";
        exit();
    }
	
	$sql = "select password,uid from users where userName = '$userName'"; //実行するSQLを文字列として記述

    $result = $mysqli->query($sql); //SQL文の実行
	
	 $row = $result->fetch_assoc(); //結果から一行づつ読み込み
    $db_enc_passwd = $row["password"]; //データベースからパスワード読み込み
    $uid = $row["uid"]; //データベースからUIDを取得
    if(password_verify($password1, $db_enc_passwd)) {
        //セッション開始
        session_start(); //セッションを開始する
        $_SESSION['uid'] = $uid; //セッション変数uidにデータベースから取得したUIDを登録
    }
    
	
    // DB接続を閉じる
    $mysqli->close();
} else {
    echo "入力されていない項目があります。<br>";
}
?>
	<a href="message_auth.php">掲示板へ</a>
</body>
</html>