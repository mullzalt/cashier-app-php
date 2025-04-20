<?php

require_once __DIR__ . "/config.php";

function to($url){
  return BASE_URL . "$url";
}

function redirect($url){
  return header('location:'. to($url));
}
