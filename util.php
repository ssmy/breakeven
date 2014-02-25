<?php
// Start session
// Should be called on every page that needs to be secured.
function begin() {
  session_start();
  if (!isset($_SESSION['username'])) {
    header('Location: ' . 'index.php');
    die();
  }
  require_once('redbean/rb.php'); // RedBean library
  include('creds.inc.php');
  R::setup('mysql:host='.$host.';dbname='.$dbname, $user, $password);
}

// Generate top section with specified title.
function make_head($title) {
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Breakeven :: <?=$title ?></title>
    <script src="jquery-1.10.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" type="text/css" href="main.css"/>
  </head>
<?php
}

function make_navbar() {
?>
  <div class="navbar navbar-inverse">
    <div class="navbar-inner">
      <a class="brand" href="/">Breakeven</a>
      <ul class="nav">
        <li><a href="transactions.php">View Transactions</a></li>
      </ul>
      <a class="btn pull-right btn-inverse" href="addTransaction.php">Add transaction</a>
    </div>
  </div>
<?
}

function make_heading($heading) {
?>
  <div class="page-header">
    <h1><?=$heading ?></h1>
  </div>
<?
}

function get_user() {
  $user = R::findOne('user', ' username=?', array($_SESSION['username']));
  return $user;
}
?>
