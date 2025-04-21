<?php

require_once __DIR__ . "/../../../core/database/product-transaction.php";

$json = file_get_contents('php://input');

$values = json_decode($json);


[$err, $success] = create_transaction($values);

if($err){
  header("HTTP/1.1 500 Internal Server Error");
  header('Content-Type: application/json');
  echo json_encode(array(
    'success' => false
  ));
}

if($success){
  header('Content-Type: application/json');
  echo json_encode(array(
    'success' => true
  ));
}



