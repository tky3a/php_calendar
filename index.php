<?php

require 'Calendar.php';

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

try {
  if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
    throw new Exception();
  }

  $thisMonth = new DateTime($_GET['t']);
} catch (Exception $e) {
  $thisMonth = new DateTime('first day of this month');
}

$dt = clone $thisMonth;
$prev = $dt->modify('-1 month')->format('Y-m');
$dt = clone $thisMonth;
$next = $dt->modify('+1 month')->format('Y-m');

#formatで月の名前をFで取得し、年をYで取得
$yearMonth = $thisMonth->format('F Y');

//前月の末日の曜日オブジェクトを取得してくる
$tail ='';
$lastDayOfPrevMonth = new DateTime('last day of' . $yearMonth . '-1 month');
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
  new DateTime('first day of' . $yearMonth),
  #1日毎の日付データを取得
  new DateInterval('P1D'),
  #次の月までの日付を取得(今月末まで)
  new DateTime('first day of' . $yearMonth . ' +1 month ')
);
$today = new DateTime('today');
foreach ($period as $day) {
  /*wで日曜日が0月曜日が１となるので、それを７で割った時の余りが０のときに行変えをしていくs*/
  if ($day->format('w') % 7 === 0) { $body .= '</tr><tr>';}
  $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
  $body .= sprintf('<td class="youbi_%d%s ">%d</td>', $day->format('w'),
  $todayClass, $day->format('d'));
}

//翌月の１日の曜日オブジェクトを取得
$head ='';
$firstDayOfNextMonth = new DateTime('first day of' . $yearMonth . '+1 month');
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
           <th><a href="/?t=<?php echo h($prev); ?>">&laquo;</a> </th>
           <th colspan="5"> <?php echo h($yearMonth); ?></th>
           <th><a href="/?t=<?php echo h($next); ?>">&laquo;</a> </th>
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
           <th colspan="7"><a href="/">Today</a> </th>
         </tfoot>
     </table>
   </body>
 </html>
