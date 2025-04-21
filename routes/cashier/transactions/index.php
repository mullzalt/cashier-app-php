<?php 
  require_once __DIR__ . "/../../../core/component.php";
  require_once __DIR__ . "/../../../core/config.php";

?>

<?php render("header"); ?>

<h1>New Transaction</h1>


<div>
<form id="add-product" method="post">
  <div>
    <label for="search-code">enter Code:</label>
    <input name="code" id="search-code"  type="text"/>
  </div>
  <div>
    <label >qty:</label>
    <input name="qty" id="product-qty" value="0" type="number"/>
  </div>
  <div>
    <label >id</label>
    <input name="id" id="product-id" type="text" readonly/>
  </div>
  <div>
    <label >Code</label>
    <input name="code" id="product-code" type="text" readonly/>
  </div>
  <div>
    <label >Name</label>
    <input name="name" id="product-name" type="text" readonly/>
  </div>
  <div>
    <label >Price</label>
    <input name="price" id="product-price" type="number" readonly/>
  </div>
  <div>
    <label>Discount</label>
    <input name="discount" id="product-discount" type="number" readonly/>
  </div>
  <button id="search-btn" type="submit" disabled>Add Product</button>

<div>
</form>
  
</div>

<table>
  <thead>
    <tr>
      <th>No.</th>
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
  <tfoot>
      
  <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>Discount</th>
      <th id="total-discount">0</th>
  </tr>
  <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>Total Price:</th>
      <th id="total-price">0</th>
  </tr>

  </tfoot>

</table>

<script>



  const getProduct = async (code) => {
  return await fetch("/routes/cashier/products/view.php?code=" + code)
      .then((res) => res.json())
  }

  const productsList = [];

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
    $("#product-discount").val(String(10));
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
    $("#search-code").val("")
    $("#search-code").trigger("focus")
    $("#search-btn").prop('disabled', true)
    productsList.push(product)

    handleUpdateProducts(productsList)
    clearSearchProduct()
  })

  const getSubTotal = (product) => {
    const qty = Number(product.qty)
    const price = Number(product.price)
    return (price * qty)
  }

    const productRow = (product, idx) => `
      <tr>
      <td>${idx+1}</td>
      <td>${product.code}</td>
      <td>${product.name}</td>
      <td>${product.qty}</td>
      <td>${parsePrice(product.price)}</td>
      <td></td>
      <td>${parsePrice(getSubTotal(product))}</td>
      </tr>
    `

    const parsePrice = (num) => new Intl
      .NumberFormat("id-ID", { style: "currency", currency: "IDR"})
      .format(num)

    const handleUpdateProducts = (products) => {
      const totalPrice = products.reduce((acc, curr) => 
        acc + (curr.price * curr.qty)
        , 0 )
      $("#total-price").text(parsePrice(totalPrice))
    }

  const handleAddProduct =(product, idx) => {
    $("#product-rows").append(productRow(product, idx))
  }

</script>


</div>
