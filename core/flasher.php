<?php

const FLASH = 'FLASH_MESSAGES';

const FLASH_ERROR = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';

const FLASH_COLOR = [
  "error" => "red",
  "warning" => "yellow",
  "info" => "blue",
  "success" => "green",
];

function create_flash_message($name, $message, $type){
  if(isset($_SESSION[FLASH][$name])){
    unset($_SESSION[FLASH][$name]);
  }

  $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}

function get_flash_message($name){
  $flash = $_SESSION[FLASH][$name];

  return $flash;
}

function get_all_flash_messages(){
  return $_SESSION[FLASH];
}


function show_flash_message($flash){
  if(!$flash){
    return "";
  }

  return "<div style='color:" . FLASH_COLOR[$flash['type']] . "'>" . $flash['message'] . "</div>";
}

function clear_flash_messages(){
  unset($_SESSION[FLASH]);
}
