
let deta_su=json_data_tukihi.length;
console.log( deta_su );

json_data_tukihi;  
json_data_jikan;  
json_data_asa_yoru;  
json_data_pres_top;  
json_data_pres_low;  
json_data_bad;  


// 表作成　　c:列　r:行

let c_end=6;
let r_end=deta_su;
var tableJQ =[];

// 読み込み時
$(window).on('load',function () {

 tableJQ_h = '<table class=\"data_area\">'+
                 '<tr><th class=\"t_border_h\">'+'月日'+'</th>'+
                 '<th class=\"t_border_h\">'+'測定時間'+'</th>'+
                 '<th class=\"t_border_h\">'+'朝・夜'+'</th>'+
                 '<th class=\"t_border_h\">'+'血圧（上）'+'</th>'+
                 '<th class=\"t_border_h\">'+'血圧（下）'+'</th>'+
                 '<th class=\"t_border_h\">'+'判定'+'</th>'+'</tr>';

       // console.log(tableJQ_h);
  tableJQ=tableJQ_h;

  for (var r = 0; r < r_end; r++) {
          tableJQ_d='';
          tableJQ_d = 
            '<tr><td  class=\"t_border\">' + json_data_tukihi[r]   + '</td>'+
            '<td  class=\"t_border\">'     + json_data_jikan[r]    + '</td>'+
            '<td  class=\"t_border\">'     + json_data_asa_yoru[r] + '</td>'+
            '<td  class=\"t_border\">'     + json_data_pres_top[r] + '</td>'+
            '<td  class=\"t_border\">'     + json_data_pres_low[r] + '</td>';

          if(json_data_bad[r]=='good'){
            tableJQ_d = tableJQ_d +
            '<td  class=\"t_border\">'     + json_data_bad[r]      + '</td>'+'<tr>';
          }else{
            tableJQ_d = tableJQ_d +
            '<td  class=\"t_border alart_back\">'     
                                           + json_data_bad[r]      + '</td>'+'<tr>';
          }
            // console.log(tableJQ);
          tableJQ=tableJQ+ tableJQ_d;
          // $(tableJQ).appendTo($('#disp'));
  }
  // tableJQ=tableJQ+'</table>';
  tableJQ=tableJQ;

  // $('</table>').appendTo($('#disp'));
  $(tableJQ).appendTo($('#disp'));
});



// データ更新時
// 読み込み時
$('#disp').on('submit',function () {
  tableJQ_d='';
  tableJQ_d = 
  '<tr><td  class=\"t_border\">' + json_data_tukihi[deta_su-1]   + '</td>'+
  '<td  class=\"t_border\">'     + json_data_jikan[deta_su-1]    + '</td>'+
  '<td  class=\"t_border\">'     + json_data_asa_yoru[deta_su-1] + '</td>'+
  '<td  class=\"t_border\">'     + json_data_pres_top[deta_su-1] + '</td>'+
  '<td  class=\"t_border\">'     + json_data_pres_low[deta_su-1] + '</td>';
  if(json_data_bad[r]=='good'){
    tableJQ_d = tableJQ_d +
  '<td  class=\"t_border\">'     + json_data_bad[r]      + '</td>'+'<tr>';
  } else {
    tableJQ_d = tableJQ_d +
  '<td  class=\"t_border alart_back\">' 
                                 + json_data_bad[r]      + '</td>'+'<tr>';
  }

  tableJQ=tableJQ_d;
  $(tableJQ).insertBefore($('#end_table'));

});


