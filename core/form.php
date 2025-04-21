<?php

function to_html_special_chars($value){
  return htmlspecialchars($value);
}

function get_post_value_by_key($key){
  $value = $_POST[$key];
  return isset($value) ? to_html_special_chars($value): null;
}

function get_post_values(){
  $values = $_POST;
  if(!isset($values)){
    return [];
  }
  return $values;
  return array_map('to_html_special_chars', $values);
}

function on_form_search(callable $fn){}

function on_form_submit(callable $fn){
  if(empty($_POST)){
    return;
  }
  $values = get_post_values();
  $fn($values);
}

