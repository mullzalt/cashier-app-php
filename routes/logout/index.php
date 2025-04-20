<?php
  require_once __DIR__ . "/../../core/session.php";
  require_once __DIR__ . "/../../core/navigation.php";

  session_destroy();
  redirect("/login");
?>


