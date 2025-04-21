
<?php 

require_once __DIR__ . "/query-builder.php";
require_once __DIR__ . "/../database.php";

function find_many_transactions(){
  return find_many("transactions");
}

function find_transaction_by_id($id){
  return find_first("transactions", [
    "where" => "id = $id"
  ]);
}


function create_transaction($values){
  DB()->begin_transaction();
  try{
    $transaction = (array) $values->transaction;
    $details = json_decode(json_encode($values->details), true); // deep array
    $conn = DB();


    $conn->query(insert_query("transactions", $transaction));
    $transaction_id = $conn->insert_id;


    $transaction_detail = array_map(function($detail) use ($transaction_id){
      $detail['transaction_id'] = $transaction_id;
      return $detail;
    }, $details);


    foreach($transaction_detail as $detail){
      insert("transaction_details", $detail);
    }


    DB()->commit();
    return [null, true];
  }catch(mysqli_sql_exception $e){
    DB()->rollback();
    return [$e, false];
  }
}

function update_transaction($id, $values){
  return update("transactions", $values, "id = $id");
}

function delete_transaction($id){
  return delete_("transactions", "id = $id");
}
