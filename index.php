<?php
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
           <tr>
             <?php echo $body . $head; ?>
             <!-- <td class="youbi_0">1</td>
             <td class="youbi_1">2</td>
             <td class="youbi_2">3</td>
             <td class="youbi_3">4</td>
             <td class="youbi_4">5</td>
             <td class="youbi_5">6</td>
             <td class="youbi_6">7</td>
           </tr>
           <tr>
             <td class="youbi_0">30</td>
             <td class="youbi_1">31</td>
             <td class="gray">1</td>
             <td class="gray">2</td>
             <td class="gray">3</td>
             <td class="gray">4</td>
             <td class="gray">5</td> -->
           </tr>
         </tbody>
         <tfoot>
           <th colspan="7"><a href="#">Today</a> </th>
         </tfoot>
     </table>
   </body>
 </html>
