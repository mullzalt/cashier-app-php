<?php 

require_once __DIR__ . "/../../../core/database/products.php";

$code = $_GET["code"];

if(isset($code)){
  $product = find_product_by_code($code);

  if(!$product){
    echo json_encode([
      "data" => null
    ]);
    return;
  }

  echo json_encode([
    "data" => $product
  ]);
}
