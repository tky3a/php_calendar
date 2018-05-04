<?php
$body = '';
#DatePeriod：特定の期間の日付オブジェクトを作成
$period = new DatePeriod(
  new DateTime('first day of this month'),
  #DateIntervalでどのくらいの間隔を開けて日付オブジェクトを作成するか決める
  #今回は1日毎
  new DateInterval('P1D'),
  new DateTime('first day of next month') #月末までの表示にしてくれる
);
foreach ($period as $day) {
  /*wで日曜日が0月曜日が１となるので、それを７で割った時の余りが０のときに行変えをしていくs*/
  if ($day->format('w') % 7 === 0) { $body .= '</tr><tr>';}
  $body .= sprintf('<td class="youbi_%d">%d</td>', $day->format('w'),
  $day->format('d'));
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
             <?php echo $body; ?>
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
