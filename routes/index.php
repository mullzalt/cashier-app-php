<?php 
  require_once __DIR__ . "/../core/component.php";
  require_once __DIR__ . "/../core/navigation.php";
?>

<?php 
  render("/header");

?>

<div class="flex p-4 gap-4 justify-between">
  <div class="navbar-logo">APP NAME</div>
  <div class="navbar-items">
    <a class="btn btn-primary" href='<?=to("/login")?>'>Sign in</a>
    <a class="btn btn-primary" href='<?=to("/register")?>'>Sign up</a>
  </div>
</div>

<h1>Hello from home!</h1>

<?php 
  render("/footer");
?>

