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

function find_product_by_code($code){
  return find_first("products", [
    "select" => ["products.id", "products.name", "products.price", "discounts.percentage as discount"],
    "join" => "LEFT JOIN discounts ON discounts.product_id = products.id",
    "where" => "products.code = '$code'",
  ]);
}

function create_product($values){
  return insert("products", $values);
}

function update_product($id, $values){
  return update("products", $values, "id = $id");
}

function delete_product($id){
  return delete_("products", "id = $id");
}
