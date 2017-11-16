<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="test.css">
<meta charset="UTF-8">

<title> 掲示板</title>
</head>
<body>
<div class="wrap">
<?php
//ログイン確認
session_start();
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    print("ログイン済みです。あなたのユーザIDは $uid です<hr>");
} else {
    echo "ログインしていないので、アクセスできません。<br>";
	echo "<a href=index.html>TOPページへ</a>";
    exit();
}
	if (!isset($_SESSION["date"])) {
  //print("セッション変数を作成します");
  $_SESSION["date"] = date('c');
}
else{
  $date = $_SESSION["date"];
  print "前回の訪問日時：$date";
  $_SESSION["date"] = date('c');
    }

	
//接続用
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


$sql = "select userName from users where uid = $uid";
$result = $mysqli->query($sql); 
$row = $result->fetch_assoc(); 
	$userName = $row["userName"]; 

	
//=============================================
//メッセージ投稿
//=============================================

	$number = $_GET["number"];
	
//メッセージが入力されていたら登録
if(!empty($_POST["mainText"])){
    $mainText = nl2br(htmlspecialchars($_POST["mainText"]));
	$sql = "insert into datas (message, number) values ('$userName : $mainText', '$number')"; 
    $result = $mysqli->query($sql); //SQL文の実行
    if ($result) { 
    } else {
        echo "データの登録に登録に失敗しました";
    }
        echo "SQL文：$sql";
        echo "エラー番号：$mysqli->error";
        echo "エラーメッセージ：$mysqli->error";
	echo "<a href=\"message_auth.php?number=<?php echo $number ?>\">戻る</a><br>";
        exit();
} else {
    echo "<br><br>テキストが登録されていません<br>";
}

echo "<br>これは'$number'です。<br><br>";
//=============================================
//入力窓
//=============================================
?>

<form action="message_auth.php?number=<?php echo $number ?>" method="post">
<input type="hidden" name="number" value="<?php echo $number ?>">
メッセージ：<textarea name="mainText" row="2" cols="40"></textarea><br>
<input type="submit" value="投稿">

	<br><br>


	<?php
//=============================================
//メッセージ表示
//=============================================

$sql = "select message, created from datas where number = '$number' order by created desc";

$result = $mysqli->query($sql); 
if ($result) { 
    while ($row = $result->fetch_assoc()) { 
    echo $row["created"] . " - " . $row["message"] . "<hr>"; 
    }
    $result->close();
}
$mysqli->close();
?>
	
	<br>
	ログアウトはこちら<br>
	<a href="logout_exec.php">ログアウト</a><br>
	<br>
	ユーザー名の変更はこちら<br>
	<a href="ch_userName_input.html">ユーザー名変更へ</a><br>
	<br>
	パスワードの変更はこちら<br>
	<a href="ch_password_input.html">パスワード変更へ</a><br>
	
	<div class="move">
	<br>
	掲示板の移動<br>
	<a href="message_auth.php?number=掲示板1">掲示板1</a>
<br>
	
<a href="message_auth.php?number=掲示板2">掲示板2</a>
<br>
	</div>
</div>
</body>
</html>