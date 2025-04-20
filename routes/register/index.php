<?php
  require_once __DIR__ . "/../../core/session.php";
  require_once __DIR__ . "/../../core/flasher.php";
  require_once __DIR__ . "/../../core/navigation.php";
  require_once __DIR__ . "/../../core/database/users.php";
  require_once __DIR__ . "/../../core/form.php";

  include_once __DIR__ . "/../../templates/header.php";

  const USERNAME_ERROR = "invalid_username";
  const PASSWORD_ERROR = "invalid_password";

  if(is_authenticated()){
    redirect("/dashboard");
  }

  function unique_username($username){
    $user = find_user_by_username($username);
    return !$user;
  }

  function valid_username($username){
    return strlen($username) >= 4;
  }

  function valid_password($password){
    return strlen($password) >= 6;
  }

  function password_match($password, $confirm_password){
    return $password == $confirm_password;
  }

  function validate_register($values){
    $username = $values['username'];
    $password = $values['password'];
    $confirm_password = $values['confirm_password'];
    $unique_username = unique_username($username);
    $valid_username = valid_username($username);
    $valid_password = valid_password($password);
    $password_match = password_match($password, $confirm_password);

    if(!$valid_username){
      create_flash_message(USERNAME_ERROR, "username  must be 4 char long!", FLASH_ERROR);
    }

    if(!$unique_username){
      create_flash_message(USERNAME_ERROR, "username already taken!", FLASH_ERROR);
    }

    if(!$password_match){
      create_flash_message(PASSWORD_ERROR, "Password does not match!", FLASH_ERROR);
    }

    if(!$valid_password){
      create_flash_message(PASSWORD_ERROR, "password  must be 6 char long!", FLASH_ERROR);
    }
    
    return unique_username($username) && valid_username($username) 
      && valid_password($password) 
      && password_match($password, $confirm_password);
  }

  function handle_register(){
    if(empty($_POST)){
      return;
    }
    $values = get_post_values();

    $is_valid = validate_register($values);

    if(!$is_valid){
      return;
    }

    $user = register_user($values);

    if(!$user){
      create_flash_message(USERNAME_ERROR, "Something went wrong", FLASH_ERROR);
      return;
    }

    set_session($user);
    redirect("/dashboard");
  }

  handle_register();

  $errors = get_all_flash_messages();

  clear_flash_messages();




?>

<h1>Register Page</h1>

<form method="post">
  <div>
    <label for="username">Username</label>
    <input name="username" id="username" type="text" required/>
    <?=show_flash_message($errors[USERNAME_ERROR])?>
  </div>
  <div>
    <label for="password">Password</label>
    <input name="password" id="password" type="password" required/>
    <?=show_flash_message($errors[PASSWORD_ERROR])?>
  </div>
  <div>
    <label for="confirm_password">Confirm Password</label>
    <input name="confirm_password" id="confirm_password" type="password" required/>
  </div>
  <button type="submit">Register</button>

</form>
