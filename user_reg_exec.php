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

// mysqli
$mysqli = new mysqli($host,$user,$pass,$dbname);
    if ($mysqli->connect_error) { 
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}


if(!empty($_POST["userName"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])){

    
    $userName = $_POST["userName"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    
    $sql = "select * from users where userName = '$userName'"; 

    $result = $mysqli->query($sql); 
    if( $result->num_rows != 0){
        echo "ユーザ名「${userName}」はすでに登録されているため使用できません。<br>";
        exit();
    }

    
    if($password1 != $password2) {
        echo "パスワードが一致しません<br>";
        exit();
    }
    
    $enc_passwd = password_hash($password1,PASSWORD_DEFAULT); 

    
    $sql = "insert into users (userName, password) values ('$userName','$enc_passwd')"; 

    $result = $mysqli->query($sql); 
    if ($result) { 
        echo "ユーザ「${userName}」の登録に成功しました <br>";
    } else {
        echo "データの登録に登録に失敗しました <br>";
        echo "SQL文：$sql <br>"; 
        echo "エラー番号：$mysqli->error <br>";
        echo "エラーメッセージ：$mysqli->error <br>";
        exit();
    }
	
	$sql = "select password,uid from users where userName = '$userName'"; 

    $result = $mysqli->query($sql); 
	
	 $row = $result->fetch_assoc();
    $db_enc_passwd = $row["password"]; 
    $uid = $row["uid"]; 
    if(password_verify($password1, $db_enc_passwd)) {
        session_start(); 
        $_SESSION['uid'] = $uid; 
    }
    
	
    $mysqli->close();
} else {
    echo "入力されていない項目があります。<br>";
}
?>
	<a href="message_auth.php">掲示板へ</a>
</body>
</html>