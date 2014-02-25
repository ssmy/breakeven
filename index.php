<?
include('util.php');
session_start();
require_once('redbean/rb.php'); // RedBean library
R::setup('mysql:host=localhost;dbname=breakeven','breakeven','breakeven');
if (isset($_GET['username']) && isset($_GET['password'])) {
  $user = R::dispense('user');
  $user->username = $_GET['username'];
  $user->password = sha1($_GET['password']);
  $id = R::store($user);
}
if (isset($_SESSION['username'])) {
  header('Location: home.php');
  die();
} elseif (isset($_POST['username'])) {
  $user = R::findOne('user', ' password=?', array(sha1($_POST['password'])));
  if ($user != NULL && $user->username == $_POST['username']) {
    $_SESSION['username'] = $_POST['username'];
    header('Location: home.php');
    die();
  }
  $failure = true;
}
make_head('Login');
?>
<body>
  <h1 class="text-center">Breakeven</h1>
  <div class="container">
    <?if (isset($failure)) {?><div class="alert alert-error">Incorrect login</div><?}?>
    <form action="index.php" method="post" class="form-signin">
      <h2 class="form-signin-heading">Please sign in</h2>
      <input type="text" class="input-block-level" placeholder="username" name="username">
      <input type="password" class="input-block-level" placeholder="password" name="password">
      <button class="btn btn-large btn-primary">Sign in</button>
    </form>
  </div>
</body>
</html>
