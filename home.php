<?php
include('util.php');
begin();
$user = get_user();
make_head('Home');
?>
<body>
  <div class="container">
    <? make_navbar(); make_heading("Home base"); ?>
    <? if ($user->balance > 0) { ?>
    <h2>You currently owe $<?=$user->balance ?></h2>
    <h3>People you should give some cash to:</h3>
    <ol>
    <?  $needmoney = R::find('user', ' balance < 0 ORDER BY balance asc'); 
        foreach($needmoney as $n) {
          if ($n != $user)
            echo('<li>' . $n->name . ' (bal ' . $n->balance . ')</li>');
        } ?>
    <? } elseif ($user->balance < 0) { ?>
    <h2>You are currently owed $<?=-($user->balance) ?></h2>
    <h3>People you should hit until they give you money:</h3>
    <ol>
    <?  $owemoney = R::find('user', ' balance > 0 ORDER BY balance desc'); 
        foreach($owemoney as $n) {
          if ($n != $user)
            echo('<li>' . $n->name . ' (bal ' . $n->balance . ')</li>');
        } ?>
    <? } else { ?>
    <h2>You are even! You don't owe anyone anything, and they don't owe you.</h2>
    <? } ?>
  </div>
</body>
</html>
