
<?php 

require_once __DIR__ . "/query-builder.php";

function find_many_transactions(){
  return find_many("transactions");
}

function find_transaction_by_id($id){
  return find_first("transactions", [
    "where" => "id = $id"
  ]);
}

function create_transaction($values){
  return insert("transactions", $values);
}

function update_transaction($id, $values){
  return update("transactions", $values, "id = $id");
}

function delete_transaction($id){
  return delete_("transactions", "id = $id");
}

// data barang
// masukan kode atau nama barang
// qty
// bakal banyak
// masukan kode atau nama barang
// qty
// masukan kode atau nama barang
// qty

// buat transaksi baru -> insert into transactions;
// $transaction_id = DB()->insert_id;
//

