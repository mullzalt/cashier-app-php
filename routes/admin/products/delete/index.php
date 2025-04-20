<?php

include_once __DIR__ . "/../../../../templates/admin/admin-header.php";
include_once __DIR__ . "/../../../../core/database/products.php";
include_once __DIR__ . "/../../../../core/navigation.php";
include_once __DIR__ . "/../../../../core/form.php";


function handle_delete_product($id){
  $res = delete_product($id);

  if(!$res){
    return;
  }

  redirect("/admin/products");
}

$id = $_GET["id"];

if(!$id){
  redirect("/admin/products");
}

$product = find_product_by_id($id);

if(!$product){
  redirect("/admin/products");
}

handle_delete_product($id);
?>
