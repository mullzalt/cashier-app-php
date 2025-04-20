<?php 
  require_once __DIR__ . "/../core/navigation.php";
  include_once __DIR__ . "/../templates/header.php";
?>

<div class="navbar">
  <div class="navbar-logo">APP NAME</div>
  <div class="navbar-items">
    <a class="btn btn-primary" href='<?=to("/login")?>'>Sign in</a>
    <a class="btn btn-primary" href='<?=to("/register")?>'>Sign up</a>
  </div>
</div>

<h1>Hello from home!</h1>

<?php 
  include_once __DIR__ . "/../templates/footer.php";
?>
