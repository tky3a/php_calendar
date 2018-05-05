<?php
// namespaceを設定：名前空間にバックスペースを入れる必要性がある
namespace MyApp;

class Calendar {
  public $prev;
  public $next;
  public $yearMonth;
  private $_thisMonth;

  public function __construct() {
    try {
      if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
        throw new \Exception();
      }

      $this->_thisMonth = new \DateTime($_GET['t']);
    } catch (\Exception $e) {
      $this->_thisMonth = new \DateTime('first day of this month');
    }
    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();
    $this->yearMonth = $this->_thisMonth->format('F Y');
  }

  private function _createPrevLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('-1 month')->format('Y-m');
  }

  private function _createNextLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('+1 month')->format('Y-m');
  }

  public function show() {
    $tail = $this->_getTail();
    $body = $this->_getBody();
    $head = $this->_getHead();
    $html = '<tr>' . $tail . $body . $head . '</tr>';
    echo $html;
  }

  private function _getTail(){
    //前月の末日の曜日オブジェクトを取得してくる
    $tail ='';
    $lastDayOfPrevMonth = new \DateTime('last day of' . $this->yearMonth . '-1 month');
    #曜日が土曜日よりも少ない場合
    while ($lastDayOfPrevMonth->format('w') < 6) {
      $tail = sprintf('<td class="gray">%d</td>',
              $lastDayOfPrevMonth->format('d')) . $tail;
      $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
    }
    return $tail;
  }

  private function _getBody(){
    $body = '';
    #DatePeriod：特定の期間の日付オブジェクトを作成
    $period = new \DatePeriod(
      #その月の月始まりだよと宣言
      new \DateTime('first day of' . $this->yearMonth),
      #1日毎の日付データを取得
      new \DateInterval('P1D'),
      #次の月までの日付を取得(今月末まで)
      new \DateTime('first day of' . $this->yearMonth . ' +1 month ')
    );
    $today = new \DateTime('today');
    foreach ($period as $day) {
      /* 行替の処理 */
      if ($day->format('w') === '0') { $body .= '</tr><tr>';}
      $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
      $body .= sprintf('<td class="youbi_%d %s">%d</td>', $day->format('w'),
      $todayClass, $day->format('d'));
    }
    return $body;
  }

    private function _getHead(){

      //翌月の１日の曜日オブジェクトを取得
      $head ='';
      $firstDayOfNextMonth = new \DateTime('first day of' . $this->yearMonth . '+1 month');
      while ($firstDayOfNextMonth->format('w') > 0) {
        $head .= sprintf('<td class="gray">%d</td>',
          $firstDayOfNextMonth->format('d'));
        $firstDayOfNextMonth->add(new \DateInterval('P1D'));
    }
    return $head;
  }
}

//

// $dt = clone $thisMonth;
// $next = $dt->modify('+1 month')->format('Y-m');
//
// #formatで月の名前をFで取得し、年をYで取得
// $yearMonth = $thisMonth->format('F Y');
//

//



?>
