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
      <th></th>
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
      <th></th>
      <th>Total Price:</th>
      <th id="total-price">0</th>
  </tr>

  </tfoot>

</table>

<form method="POST" id="checkout-form">
  <div>
    <label >Pay Ammount</label>
    <input name="pay_ammount" id="pay_ammount" type="number" />
  </div>
    <label >Chage:</label>
  <input type="text" id="money_change" readonly>
  <button disabled id="checkout-button" type="submit">Checkout</button>
</form>


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
    $("#product-discount").val(String(product.discount ?? 0));
    $("#product-qty").val("1");
    $("#search-btn").prop('disabled', false)
  }

  const calculateDiscount = (price, discount) => discount ? price * (discount / 100) : 0

  const getDiscount = (product) => {
    const price = Number(product.price ?? 0)
    const discount = Number(product.discount)
    const qty = Number(product.qty)
    return calculateDiscount(price, discount) * qty;
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
    $("#search-code").val("")
    $("#search-code").trigger("focus")
    $("#search-btn").prop('disabled', true)
    $("#checkout").prop('disabled', false)

    const updatedProduct = {
    ...product, 
      discount_price: getDiscount(product),
      sub_total: getSubTotal(product)
    }

    handleAddProduct(updatedProduct, productsList.length)
    
    productsList.push(updatedProduct)

    handleUpdateProducts(productsList)
    clearSearchProduct()
  })

  const getSubTotal = (product) => {
    const discount = getDiscount(product)
    const qty = Number(product.qty)
    const price = Number(product.price)
    return (price * qty) - discount
  }

    const productRow = (product, idx) => `
      <tr>
      <td>${idx+1}</td>
      <td>${product.code}</td>
      <td>${product.name}</td>
      <td>${product.qty}</td>
      <td>${parsePrice(product.price)}</td>
      <td>${product.discount > 0 ? product.discount + "%" : "-"}</td>
      <td>${parsePrice(product.discount_price)}</td>
      <td>${parsePrice(product.sub_total)}</td>
      </tr>
    `

    const parsePrice = (num) => num ? new Intl
      .NumberFormat("id-ID", { style: "currency", currency: "IDR"})
      .format(num) : ""

    const handleUpdateProducts = (products) => {
      const totalPrice = products.reduce((acc, {sub_total}) => 
        acc + sub_total
        , 0 )
      $("#total-price").text(parsePrice(totalPrice))
    }

  const handleCheckout =   (data) => {
      return  postRequest('/routes/cashier/transactions/_checkout.php', {
        json: data,
        onSuccess: () => redirect("/routes/dashboard"),
        onError: (e) => alert("Failed to insert transaction"),
      }).then((res) => res)
  }

  const getTotalPrice = (products) => 
      products
      .map(({price, qty}) => price * qty)
      .reduce((acc, curr) => acc + curr, 0)

  const getTotalDiscount = (products) => 
      products
      .map(({discount_price}) => discount_price)
      .reduce((acc, curr) => acc + curr, 0)

  const getNetPrice = (products) => getTotalPrice(products) - getTotalDiscount(products)
  
  const getTransactionData = ({pay_ammount, money_change}) => {
    const discount = getTotalDiscount(productsList);
    const total_price = getTotalPrice(productsList);
  
    const net_price = getNetPrice(productsList);

    const details = productsList.map((product) => ({
      product_id: product.id,
      discount_percentage: product.discount,
      discount_price: product.discount_price,
      quantity: product.qty,           
      sub_total: product.sub_total          
    }))

    const transaction = { total_price, discount, net_price, pay_ammount, money_change }

    return { transaction, details }
  }

  $("#pay_ammount").on('input', (e) => {
    e.preventDefault()
    const ammount = Number(e.target.value)
    const total_price = getNetPrice(productsList)
    const change = ammount - getNetPrice(productsList)
    const isEmpty = productsList.length < 1

    $("#checkout-button").prop("disabled", isEmpty || ammount < total_price )
    $("#money_change").val(String(change))
  })


  $("#checkout-form").on('submit', async(e) => { 
    e.preventDefault()
    const pay_ammount = Number($("#pay_ammount").val())
    const money_change = Number($("#money_change").val())
    await handleCheckout(
      getTransactionData({pay_ammount, money_change})
    )}
  )

  const handleAddProduct =(product, idx) => {
    $("#product-rows").append(productRow(product, idx))
  }

</script>


</div>
