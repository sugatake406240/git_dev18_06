<?php
// 受け取り
// var_dump($_POST);
$tukihi = $_POST['tukihi'];
$jikan = $_POST['jikan'];
$asa_yoru = $_POST['asa_yoru'];
$pres_top = $_POST['pres_top'];
$pres_low = $_POST['pres_low'];

if( $pres_top<=135 && $pres_low<=85  ){
    $judg="good";
    echo "good";
} else{
    $judg="bad";
    echo "bad";
}

// ファイルに書き込み

$file = fopen('./data/data.txt','a');
fwrite($file,$tukihi.' '.$jikan.' '.$asa_yoru.' '.$pres_top.' '.$pres_low.' '.$judg."\n");
fclose($file);

//文字作成

?>


<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

<body>

    <h1>書き込みしました。</h1>
    <p>data/data.txt を確認しましょう！</p>

    <ul>
        <li><a href="input.php">戻る</a></li>
    </ul>

    <script>setTimeout("location.href = 'http://localhost/1220/input.php'",2000);</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>
