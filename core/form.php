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
