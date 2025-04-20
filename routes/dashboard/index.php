<?php
  require_once __DIR__ . "/../../core/session.php";
  require_once __DIR__ . "/../../core/flasher.php";
  require_once __DIR__ . "/../../core/navigation.php";

  include_once __DIR__ . "/../../templates/header.php";


  if(!is_authenticated()){
    redirect("/login");
  }

  $user = get_session();


?>



<h1>Hellow, <?=$user["username"]?>, fuck you</h1>
<a href="<?=to('/logout')?>">Logout</a>
