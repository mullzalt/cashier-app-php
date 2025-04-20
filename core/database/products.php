
<?php 

require_once __DIR__ . "/query-builder.php";

function find_many_products(){
  return find_many("products");
}

function find_product_by_id($id){
  return find_first("products", [
    "where" => "id = $id"
  ]);
}

function create_product($values){
  return;
}

function update_product($id, $values){
  return;
}

function delete_product($id){
  return;
}
