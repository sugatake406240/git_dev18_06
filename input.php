<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>１２月２０日　課題テンプレート</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
<section style="font-size: 1.5rem;">

<!-- データ入力欄 -->
    <h1 >血圧測定</h1>
    <form action="write.php" method="post">
    <label >　月日:     <input type="text" name="tukihi" class="char12" size="10" ></label>
    <label >　測定時間: <input type="text" name="jikan"  class="char12" size="10" ></label>
    <label>　朝・夜： <select name="asa_yoru">
                        <option value="朝">朝</option>
                        <option value="夜">夜</option>
                     </select></label>
    <label>　血圧（上）:<input type="number" name="pres_top"   class="char3"  size="3" 　></label>
    <label>　血圧（下）:<input type="number" name="pres_low"  class="char3"  size="3"　></label>  

        <input type="submit" value="送信">
    </form>
</section>


<!-- 　　　　 　  -->
<!--ＰＨＰ処理～  -->
<!--  　　　　　  -->
<?php

// %表示の関数
function num2per($number, $total, $precision = 0) {
    if ($number < 0) { return 0;}

        try {
            $percent = ($number / $total) * 100;
            return round($percent, $precision);
        }
        catch (Exception $e) {
            return 0;
        }

    }



    //データ数
    $data_su=0; 
    // 格納配列
    $data_tukihi = [] ;
    $data_jikan = [] ;
    $data_asa_yoru = [] ;
    $data_pres_top = [] ;
    $data_pres_low = [] ;
    $data_bad = [];
    $result = [];

    $php_data_tukihi = [];
    $php_data_jikan = [];
    $php_data_asa_yoru = [];
    $php_data_pres_top = [];
    $php_ata_pres_low = [];
    $php_data_bad = [];

    // ファイルを開く
    $openFile = fopen('./data/data.txt','r');
    // ファイル内容を1行ずつ読み込んで出力
    $i=0;
    while($line = fgets($openFile)){
        //  「/n」を「br」へ変更する
        // echo nl2br($line);

        // 行から\nを削除する
    $line=trim($line);

    $data = explode(" ",$line);
    $data_tukihi[$i] = $data[0];
    $data_jikan[$i] =  $data[1];
    $data_asa_yoru[$i] = $data[2];
    $data_pres_top[$i] = intval($data[3]);
    $data_pres_low[$i] = intval($data[4]);
    $data_bad[$i] = $data[5];

    $i++;
    $data_su=$i;
    }
    // ファイルを閉じる
    fclose($openFile);



// 
// 血圧平均値
// 
    $av_pres_top = round(array_sum($data_pres_top) / $data_su,1);
    $av_pres_low = round(array_sum($data_pres_low) / $data_su,1);
//  echo "血圧（上）平均".$av_pres_top."\n";
//  echo "血圧（下）平均".$av_pres_low."\n";

    $result = array_keys($data_asa_yoru, '朝');

    // var_dump($result);
    $n=count($result);
    // echo "朝個数".$n."\n";


    $sum_top=0;
    $sum_low=0;
    for($i=0; $i<$n; $i++){
        $sum_top +=  $data_pres_top[ $result[$i] ];
        $sum_low +=  $data_pres_low[ $result[$i] ];
    }
    $av_mon_top=round($sum_top/$n,1);
    $av_mon_low=round($sum_low/$n,1);
    // echo "血圧（上）朝・平均 ".$av_mon_top;
    // echo "血圧（下）朝・平均 ".$av_mon_low;


    $result = array_keys($data_asa_yoru, '夜');

    // var_dump($result);
    $n=count($result);
    // echo "夜個数".$n."\n";


    $sum_top=0;
    $sum_low=0;
    for($i=0; $i<$n; $i++){
        $sum_top +=  $data_pres_top[ $result[$i] ];
        $sum_low +=  $data_pres_low[ $result[$i] ];
    }
    $av_night_top=round($sum_top/$n,1);
    $av_night_low=round($sum_low/$n,1);
    // echo "血圧（上）夜・平均 ".$av_night_top;
    // echo "血圧（下）夜・平均 ".$av_night_low;

// 
// ｂａｄ率
// 
// bad項目を配列に格納
$result = array_keys($data_bad, 'bad');
//  var_dump($result);



// ｂａｄ個数を算出
$n=count($result);
//  echo "bad個数".$n."\n";


$bad_mon_sum=0;
$bad_nig_sum=0;
for($i=0; $i<$n; $i++){
    if($data_asa_yoru[$result[$i]] == '朝'){
        $bad_mon_sum++;
    }else if($data_asa_yoru[$result[$i]] == '夜'){
        $bad_nig_sum++;
    }
}

$bad_total=$n;
$bad_rate = num2per($bad_total, $data_su, $precision = 1);
$bad_mon_rate= num2per($bad_mon_sum, $data_su, $precision = 1);
$bad_nig_rate= num2per($bad_nig_sum, $data_su, $precision = 1);

// PHP→javascript JSONエンコード
$php_data_tukihi = json_encode( array_values($data_tukihi) );
$php_data_jikan = json_encode( array_values($data_jikan) );
$php_data_asa_yoru = json_encode( array_values($data_asa_yoru) );
$php_data_pres_top = json_encode( array_values($data_pres_top) );
$php_data_pres_low = json_encode( array_values($data_pres_low) );
$php_data_bad = json_encode( array_values($data_bad) );

?>
<!-- 　　　　 　  -->
<!--～ＰＨＰ処理  -->
<!--  　　　　　  -->



<!-- JSONデコード -->
<script>
var json_data_tukihi = JSON.parse('<?php echo $php_data_tukihi; ?>');  
var json_data_jikan = JSON.parse('<?php echo $php_data_jikan; ?>');  
var json_data_asa_yoru = JSON.parse('<?php echo $php_data_asa_yoru; ?>');  
var json_data_pres_top = JSON.parse('<?php echo $php_data_pres_top; ?>');  
var json_data_pres_low = JSON.parse('<?php echo $php_data_pres_low; ?>');  
var json_data_bad = JSON.parse('<?php echo $php_data_bad; ?>');  
</script>


<!--統計データ表示  -->
<section>
<h2 >統計データ</h2>

    <table class="table_toukei" >
    <tr>
        <td>
       <!-- 血圧（上）平均 　血圧（上）朝平均　血圧（上）夜平均-->
        <table >
            <tr>
                <th class="t_border_h">血圧（上）平均</th>
                <th class="t_border_h">朝・平均</th>
                <th class="t_border_h">夜・平均</th>
            </tr>
            <tr>
                <td class="t_border"> <?php echo $av_pres_top ?> </td>
                <td class="t_border"> <?php echo $av_mon_top?>  </td>
                <td class="t_border"> <?php echo $av_night_top?> </td>
            </tr>
        </table>
        </td>
        <td>
    <!-- 血圧（下）平均 　血圧（下）朝平均　血圧（下）夜平均-->
        <table >
            <tr>
                <th class="t_border_h">血圧（下）平均</th>
                <th class="t_border_h">朝・平均</th>
                <th class="t_border_h">夜・平均</th>
            </tr>
            <tr>
                <td class="t_border"> <?php echo $av_pres_low ?></td>
                <td class="t_border"> <?php echo $av_mon_low ?></td>
                <td class="t_border"> <?php echo $av_night_low ?></td>
            </tr>
        </table>
        </td>
  <!-- バットマーク　朝合計・夜合計 -->
        <td>
        <table >
            <tr>
                <th class="t_border_h">bad率（総計）</th>
                <th class="t_border_h">（朝）</th>
                <th class="t_border_h">（夜）</th>
            </tr>
            <tr>
                <td class="t_border"><?php echo $bad_rate."％"; ?></td>
                <td class="t_border"><?php echo $bad_mon_rate."％"; ?></td>
                <td class="t_border"><?php echo $bad_nig_rate."％"; ?></td>
            </tr>
        </table>
        </td>
    </tr>
    </table>

</section>


<section style="text-align: center;  width: 800px;  margin: auto; ">
<!-- データ　読み込み   　-->
<h2>登録データ</h2> 
 
<!-- javascriptで表を生成 -->
    <div id=disp >   </div>
    <div id=end_table></table> </div>

</section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>
