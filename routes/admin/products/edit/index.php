<?php

include_once __DIR__ . "/../../../../templates/admin/admin-header.php";
include_once __DIR__ . "/../../../../core/database/products.php";
include_once __DIR__ . "/../../../../core/navigation.php";
include_once __DIR__ . "/../../../../core/form.php";


function handle_update_product($id){

  if(empty($_POST)){
    return;
  }

  $values = get_post_values();

  $res = update_product($id, $values);

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

handle_update_product($id);
?>

  <h1>Edit <?= $product["name"]?></h1>

<form method="post">
  <div>
    <label for="code">Code</label>
    <input name="code" id="code" type="text" value='<?=$product['code']?>' required/>
  </div>
  <div>
    <label for="name">Name</label>
    <input name="name" id="name" type="text" value='<?=$product['name']?>' required/>
  </div>
  <div>
    <label for="price">Price</label>
    <input name="price" id="price" type="number" value='<?=$product['price']?>'  required/>
  </div>
  <button type="submit">Update</button>
</form>


