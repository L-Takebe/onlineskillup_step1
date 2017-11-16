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
// ===================ログイン確認部分ここから==========================
//ログインしているかを認証
session_start();
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    print("ログイン済みです。あなたのユーザIDは $uid です<hr>");
} else {
    echo "ログインしていないので、アクセスできません。<br>";
	echo "<a href=index.html>TOPページへ</a>";
	//echo "<a href=session_login_input.html>ログインはこちら</a>";
    exit();
}
	if (!isset($_SESSION["date"])) {
  print("セッション変数を作成します");
  $_SESSION["date"] = date('c');
}
else{
  // セッション変数の取得
  $date = $_SESSION["date"];
  print "前回の訪問日時：$date";
  // セッション変数の日時更新 
  $_SESSION["date"] = date('c');
    }
// ===================ログイン確認部分ここまで==========================

	
	
//接続用パラメータの設定
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


$sql = "select userName from users where uid = $uid";
$result = $mysqli->query($sql); //SQL文の実行
$row = $result->fetch_assoc(); //結果から一行づつ読み込み
	$userName = $row["userName"]; //データベースからuser name読み込み

	
//=============================================
//メッセージ投稿
//=============================================

	$number = $_GET["number"];	//掲示板名test
//メッセージが入力されていたら登録
if(!empty($_POST["mainText"])){
    $mainText = nl2br(htmlspecialchars($_POST["mainText"]));
    //$sql = "insert into datas (message) values ('$userName : $mainText')"; //実行するSQLを文字列として記述
	$sql = "insert into datas (message, number) values ('$userName : $mainText', '$number')"; //test
    $result = $mysqli->query($sql); //SQL文の実行
    if ($result) { //SQL実行のエラーチェック
		//echo"これは掲示板 $number です。";//test
        //echo "データの登録に成功しました";
    } else {
        echo "データの登録に登録に失敗しました";
        echo "SQL文：$sql";
        echo "エラー番号：$mysqli->error";
        echo "エラーメッセージ：$mysqli->error";
        exit();
    }
} else {
    //echo "テキストが登録されていません<br>";
}


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

$sql = "select message, created from datas where number = '$number' order by created desc"; //実行するSQLを文字列として記述 where number = $number

$result = $mysqli->query($sql); //SQL文の実行
if ($result) { //実行結果が正しければ
    // 連想配列を取得
    while ($row = $result->fetch_assoc()) { //結果から一行づつ読み込み
    echo $row["created"] . " - " . $row["message"] . "<hr>"; //結果を整形して表示
    }
    // 結果セットを閉じる
    $result->close();
}

//=============================================
// DB接続を閉じる
//=============================================
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
	<br><br>
	掲示板の移動<br>
	<a href="message_auth.php?number=掲示板1">掲示板1</a>
<br>
	
<a href="message_auth.php?number=掲示板2">掲示板2</a>
<br>
	
</div>
</body>
</html>