<?php 

require_once __DIR__ . "/query-builder.php";

function find_many_users(){
  return find_many("users");
}

function find_user_by_id($id){
  return find_first("users", [
    "where" => "id = $id"
  ]);
}

function find_user_by_username($username){
  return find_first("users", [
    "where" => "username = '$username'"
  ]);
}

function create_user($values){
  return insert("users", $values);
}

function update_user($id, $values){
  return update("users", $values, "id = $id");
}

function delete_user($id){
  return delete_("users", "id = $id");
}

function register_user($values){
  $username = $values["username"];
  $password = $values["password"];

  $password_hashed = password_hash($password, PASSWORD_BCRYPT);

  $result = create_user([
    "username" => $username,
    "password_hashed" => $password_hashed
  ]);

  if(!$result){
    return null;
  }

  $user = find_user_by_username($username);
  return $user;
}
