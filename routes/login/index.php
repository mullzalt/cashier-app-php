<?php
  require_once __DIR__ . "/../../core/session.php";
  require_once __DIR__ . "/../../core/flasher.php";
  require_once __DIR__ . "/../../core/navigation.php";
  require_once __DIR__ . "/../../core/database/users.php";
  require_once __DIR__ . "/../../core/form.php";

  include_once __DIR__ . "/../../templates/header.php";

  const WRONG_USERNAME_PASSWORD = "invalid_credential";


  if(is_authenticated()){
    redirect("/dashboard");
  }

  function handle_login(){
    if(empty($_POST)){
      return;
    }

    $values = get_post_values();
    $username = $values["username"];
    $password = $values["password"];


    $user = find_user_by_username($username);

    if(!$user){
      create_flash_message(WRONG_USERNAME_PASSWORD, "Invalid username or password", FLASH_ERROR);
      return;
    }

    $password_hashed = $user["password_hashed"];

    if(!password_verify($password, $password_hashed)){
      create_flash_message(WRONG_USERNAME_PASSWORD, "Invalid username or password", FLASH_ERROR);
      return;
    }

    set_session($user);
    redirect("/dashboard");
  }

  handle_login();

  $errors = get_all_flash_messages();

  clear_flash_messages();
?>

<h1>Login Page</h1>

<form method="post">
  <div>
    <label for="username">Username</label>
    <input name="username" id="username" type="text" required/>
  </div>
  <div>
    <label for="password">Password</label>
    <input name="password" id="password" type="password" required/>
    <?=show_flash_message($errors[WRONG_USERNAME_PASSWORD])?>
  </div>
  <button type="submit">Login</button>

</form>
