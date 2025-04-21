<?php 
  require_once __DIR__ . "/../../../core/component.php";
  require_once __DIR__ . "/../../../core/config.php";

?>

<?php render("header"); ?>

<h1>New Transaction</h1>


<div>
<form id="add-product" method="post">
  <div>
    <label for="search-name">enter Code:</label>
    <input name="code" id="search-code"  type="text"/>
  </div>
  <div>
    <label for="search-name">qty:</label>
    <input name="qty" id="product-qty" value="0" type="number"/>
  </div>
  <div>
    <label for="search-name">id</label>
    <input name="id" id="product-id" type="text" readonly/>
  </div>
  <div>
    <label for="search-name">Code</label>
    <input name="code" id="product-code" type="text" readonly/>
  </div>
  <div>
    <label for="search-name">Name</label>
    <input name="name" id="product-name" type="text" readonly/>
  </div>
  <div>
    <label for="search-name">Price</label>
    <input name="price" id="product-price" type="number" readonly/>
  </div>
  <button id="search-btn" type="submit" disabled>Add Product</button>

<div>
</form>
  
</div>

<table>
  <thead>
    <tr>
      <th></th>
      <th>Code</th>
      <th>Name</th>
      <th>Qty</th>
      <th>Price</th>
      <th>Discount</th>
      <th>Sub Total</th>
  
    </tr>

  </thead>
  <tbody id="product-rows">

  </tbody>

</table>

<script>



  const getProduct = async (code) => {
  return await fetch("/routes/cashier/products/view.php?code=" + code)
      .then((res) => res.json())
  }

  const clearSearchProduct = () => {
    $("#product-id").val("");
    $("#product-code").val("");
    $("#product-name").val("");
    $("#product-qty").val("0");
    $("#product-price").val("");

  }
  const handleProductNotFound = () => {
    clearSearchProduct();
    $("#search-btn").prop('disabled', true)

  }

  const handleProductFound = (product) => {
    $("#product-id").val(String(product.id));
    $("#product-code").val(product.code);
    $("#product-name").val(product.name);
    $("#product-price").val(String(product.price));
    $("#product-qty").val("1");
    $("#search-btn").prop('disabled', false)
  }


  $("#search-code").on('input', async (e) => {
    const code = e.target.value
    const {data} = await getProduct(code)
    if(!data){
      handleProductNotFound();
      return;
    }
    handleProductFound(data);
  })

  const parseSerialized = (arr)=> {
  return arr.map(({name, value}) => ({
      [name]: value
    })).reduce((acc, curr) => ({...acc, ...curr}), {})



  }

  $("#add-product").on("submit", (e) => {
    e.preventDefault()
    const product = parseSerialized($("#add-product").serializeArray())
    handleAddProduct(product, 1)
    
  })

    const productRow = (product, idx) => `
      <tr>
      <td>${idx+1}</td>
      <td>${product.name}</td>
      <td>${product.price}</td>
      <td>${product.qty}</td>
      <td>${Number(product.qty) * Number(product.price)}</td>
      </tr>
    `

  const handleAddProduct =(product, idx) => {
    $("#product-rows").append(productRow(product, idx))
  }




</script>


</div>
