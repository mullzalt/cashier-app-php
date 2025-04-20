<?php 
  require_once __DIR__ . "/../../core/navigation.php";
  require_once __DIR__ . "/../../core/session.php";
  include_once __DIR__ . "/../header.php";

  if(!is_admin()){
    redirect('/dashboard');
  }

?>

<div class="navbar">
  <div class="navbar-items">
    <a href='<?=to("/admin/products")?>'>Product</a>
    <a href='<?=to("/admin/taxes")?>'>Tax</a>
    <a href='<?=to("/admin/discounts")?>'>Discount</a>
    <a href='<?=to("/admin/users")?>'>Users</a>
  </div>
</div>
