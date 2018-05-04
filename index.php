<?php

//前月の末日の曜日オブジェクトを取得してくる
$tail ='';
$lastDayOfPrevMonth = new DateTime('last day of previous month');
#曜日が土曜日よりも少ない場合
while ($lastDayOfPrevMonth->format('w') < 6) {
  $tail = sprintf('<td class="gray">%d</td>',
          $lastDayOfPrevMonth->format('d')) . $tail;
  $lastDayOfPrevMonth->sub(new DateInterval('P1D'));
}


$body = '';
#DatePeriod：特定の期間の日付オブジェクトを作成
$period = new DatePeriod(
  #その月の月始まりだよと宣言
  new DateTime('first day of this month'),
  #1日毎の日付データを取得
  new DateInterval('P1D'),
  #次の月までの日付を取得(今月末まで)
  new DateTime('first day of next month')
);
foreach ($period as $day) {
  /*wで日曜日が0月曜日が１となるので、それを７で割った時の余りが０のときに行変えをしていくs*/
  if ($day->format('w') % 7 === 0) { $body .= '</tr><tr>';}
  $body .= sprintf('<td class="youbi_%d">%d</td>', $day->format('w'),
  $day->format('d'));
}

//翌月の１日の曜日オブジェクトを取得
$head ='';
$firstDayOfNextMonth = new DateTime('first day of next month');
while ($firstDayOfNextMonth->format('w') > 0) {
  $head .= sprintf('<td class="gray">%d</td>',
    $firstDayOfNextMonth->format('d'));
  $firstDayOfNextMonth->add(new DateInterval('P1D'));
}

$html = '<tr>' . $tail . $body . $head . '</tr>';

?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Calendar</title>
     <link rel="stylesheet" href="styles.css">
   </head>
   <body>
     <table>
       <thead>
         <tr>
           <th><a href="#">&laquo;</a> </th>
           <th colspan="5"> May 2018</th>
           <th><a href="#">&laquo;</a> </th>
         </tr>
       </thead>
         <tbody>
           <tr>
             <td>Sun</td>
             <td>Mon</td>
             <td>Tue</td>
             <td>Web</td>
             <td>Thu</td>
             <td>Fri</td>
             <td>Sat</td>
           </tr>
           <?php echo $html; ?>
         </tbody>
         <tfoot>
           <th colspan="7"><a href="#">Today</a> </th>
         </tfoot>
     </table>
   </body>
 </html>
