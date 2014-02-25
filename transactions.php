<?php
include('util.php');
begin();
$user = get_user();
make_head("View all transactions");
if (!isset($_GET['page'])) {
  $transactions = R::findAll('transaction', 'ORDER BY id DESC LIMIT 20');
  $next = 2;
} else {
  $transactions = R::findAll('transaction', 'ORDER BY id DESC LIMIT :start, :limit', array(':start'=>($_GET['page']-1)*20, ':limit'=>$_GET['page']*20));
  $next = $_GET['page']+1;
}
?>
<body>
  <div class="container">
  <? make_navbar(); make_heading("Transactions"); ?>
  <table class="table table-striped table-bordered">
    <tr>
      <th>Amount</th>
      <th>Date</th>
      <th>Description</th>
      <th>Recipients</th>
    </tr>
  <?
  foreach($transactions as $t) {
    $recips = $t->sharedUser;
?>
    <tr>
    <td>$<?=$t->amt ?></td>
    <td><?=$t->date ?></td>
    <td><?=$t->description ?></td>
    <td><? foreach($recips as $r) { echo($r->name . ', '); }?></td>
    </tr>
<?
  }
?>
  </table>
<?
  if ($next > 2) {
    $prev = $next-2;
?>
  <a href="transactions.php?page=<?=$prev ?>"><button type="button" class="btn-large"><i class="icon-arrow-left"></i> Previous page</button></a>
<?
  }
  if (count($transactions) == 20) {
?>
  <a href="transactions.php?page=<?=$next ?>"><button type="button" class="btn-large">Next page <i class="icon-arrow-right"></i></button></a>
<?
  }
?>
  </div>
</body>
</html>
