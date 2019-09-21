<?php
  require_once '../includes/session.php';
  require_once '../includes/functions.php';

  $session->logout();
  redirectTo("./index.php");
?>
