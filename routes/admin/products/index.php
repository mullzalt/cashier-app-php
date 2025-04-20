<?php

include_once __DIR__ . "/../../../templates/admin/admin-header.php";
include_once __DIR__ . "/../../../core/database/products.php";
include_once __DIR__ . "/../../../core/navigation.php";

$products = find_many_products();

?>

<h1>Admin product</h1>

<a href='<?=to("/admin/products/new")?>'>add product</a>


 <table>
  <tr>
    <th>Code</th>
    <th>Name</th>
    <th>Price</th>
    <th>Action</th>
  </tr>
  <?php foreach ($products as $product): ?>
    <tr>
        <td><?= htmlspecialchars($product['code']) ?></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['price']) ?></td>
        <td>
          <a href='<?=to("/admin/products/edit?id=". $product["id"])?>'>Edit</a>
          <a href='<?=to("/admin/products/delete?id=". $product["id"])?>'>Delete</a>

        </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php if(empty($products)){  echo("Nothing to show");} ?>
