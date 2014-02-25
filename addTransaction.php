<?
include('util.php');
begin();
$user = get_user();
if (isset($_POST['amount'])) {
  $transaction = R::dispense('transaction');
  $transaction->amt = $_POST['amount'];
  $transaction->date = $_POST['date'];
  $transaction->description = $_POST['description'];
  $recipients = array();
  foreach($_POST['recipients'] as $r) {
    if ($r == $user->id) {
      $user->balance += ($_POST['amount']/count($_POST['recipients']));
      $recipients[] = $user;
    } else {
      $recip = R::load('user', $r);
      $recipients[] = $recip;
      $recip->balance += ($_POST['amount']/count($_POST['recipients']));
      R::store($recip);
    }
  }
  $transaction->sharedUser = $recipients;
  $user->balance -= $_POST['amount'];
  R::store($transaction);
  R::store($user);
  $added = true;
}
make_head('Add new transaction');
?>
<body>
  <div class="container">
    <? make_navbar(); ?>
    <? if (isset($added)) { ?>
    <div class="alert alert-success">Transaction added successfully</div>
    <? } make_heading("Add new transaction"); ?>
    <form method="post" action="addTransaction.php" class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="amount">Amount</label>
        <div class="controls">
          <input type="text" name="amount" placeholder="amount">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="recipients[]">Recipients</label>
        <div class="controls">
  <? 
  $recipients = R::find('user');
  ?>
    <select name="recipients[]" multiple="multiple" size="<?=count($recipients)?>">
  <?
  foreach($recipients as $r) {
    echo('<option value="' . $r->id . '" selected="selected">' . $r->name . '</option>');
  }
  ?>
          </select></br>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="description">Description</label>
        <div class="controls">
          <input type="text" name="description" placeholder="description">
        </div>
          <br/>
        <label class="control-label" for="date">Date</label>
        <div class="controls">
          <input type="date" name="date" value="<?=date("Y-m-d"); ?>"/>
        </div>
        <div class="controls">
          <br/>
          <button type="submit" class="btn btn-primary">Add transaction</button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
