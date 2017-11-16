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

// mysqli
$mysqli = new mysqli($host,$user,$pass,$dbname);
    if ($mysqli->connect_error) { 
    echo $mysqli->connect_error; 
    exit();
} else {
    $mysqli->set_charset("utf8");
}
	
if(!empty($_POST["userName"]) && !empty($_POST["password"])){

    
    $userName = $_POST["userName"];
    $password = $_POST["password"];


    
    $sql = "select password,uid from users where userName = '$userName'"; 

    $result = $mysqli->query($sql); 
    if( $result->num_rows == 0){
        echo "ユーザ名「${userName}」は登録されていません。<br>";
		echo "<a href=user_reg_input.html>まだアカウントのない人はこちら</a>";
        exit();
    }
    $row = $result->fetch_assoc(); 
    $db_enc_passwd = $row["password"]; 
    $uid = $row["uid"]; 
    if(password_verify($password, $db_enc_passwd)) {
        echo "ユーザ「${userName}」が正しく認証されました。<br>";
       
		
        session_start(); 
        $_SESSION['uid'] = $uid; 
    } else {
        echo "ユーザ「${userName}」を認証できませんでした。パスワードが一致しません。<br>";
        exit();
    }

    $result->close(); 
    $mysqli->close();
	echo "掲示板へ移動<br>
	<a href=message_auth.php?number=掲示板1>掲示板1</a><br>
	<a href=message_auth.php?number=掲示板2>掲示板2</a>";
		
	
} else {
    echo "入力されていない項目があります。<br>";
}
?>
</body>
</html>