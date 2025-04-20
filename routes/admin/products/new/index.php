<?php

include_once __DIR__ . "/../../../../templates/admin/admin-header.php";
include_once __DIR__ . "/../../../../core/database/products.php";
include_once __DIR__ . "/../../../../core/navigation.php";
include_once __DIR__ . "/../../../../core/form.php";


function handle_create_product(){
  if(empty($_POST)){
    return;
  }
  $values = get_post_values();

  $res = create_product($values);

  if(!$res){
    return;
  }

  redirect("/admin/products");
}

handle_create_product();
?>

<h1>Admin new product</h1>

<form method="post">
  <div>
    <label for="code">Code</label>
    <input name="code" id="code" type="text" required/>
  </div>
  <div>
    <label for="name">Name</label>
    <input name="name" id="name" type="text" required/>
  </div>
  <div>
    <label for="price">Price</label>
    <input name="price" id="price" type="number" required/>
  </div>
  <button type="submit">Save</button>
</form>


