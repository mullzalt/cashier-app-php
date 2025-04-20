<?php

session_start();

require_once __DIR__ . "/navigation.php";

const AUTH_SESSION = 'auth_session';

function set_session($user){
  if(isset($_SESSION[AUTH_SESSION])){
    unset($_SESSION[AUTH_SESSION]);
  }

  $_SESSION[AUTH_SESSION] = [
    "username" => $user["username"],
    "role" => $user["role"]
  ];
}

function get_session(){
  return $_SESSION[AUTH_SESSION] ?? null;
}

function remove_session(){
  unset($_SESSION[AUTH_SESSION]);
}

function is_authenticated(){
  return get_session() !== null;
}

function is_admin(){
  $session = get_session();
  return is_authenticated() && $session["role"] === "admin";
}

function is_cashier(){
  $session = get_session();
  return is_authenticated() && $session["role"] === "cashier";
}

function public_only(){
  if(is_authenticated()){
    return redirect("/dashboard");
  }
}
