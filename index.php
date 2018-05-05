<?php

require 'Calendar.php';

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$cal = new \MyApp\Calendar();

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
           <th><a href="/?t=<?php echo h($cal->prev); ?>">&laquo;</a> </th>
           <th colspan="5"> <?php echo h($cal->yearMonth); ?></th>
           <th><a href="/?t=<?php echo h($cal->next); ?>">&laquo;</a> </th>
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
           <?php echo $cal->show(); ?>
         </tbody>
         <tfoot>
           <th colspan="7"><a href="/">Today</a> </th>
         </tfoot>
     </table>
   </body>
 </html>
