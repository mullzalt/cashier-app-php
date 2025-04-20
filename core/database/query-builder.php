<?php
require_once __DIR__ . "/../database.php";

function column_parser($cols){
  return "(". implode(", ", $cols).  ")" ;
}

function value_parser($value){
  return is_string($value) ? "'$value'" : "$value";
}

function set_parser($values){
  $cols = array_keys($values);

  $transform = function($col, $value){
    return "$col = ". value_parser($value);
  }; 

  return implode(", ", array_map($transform, $cols, $values));
}

function where_parser($where){
  return "WHERE $where"; 
}

function limit_parser($limit){
  return "LIMIT $limit";
}

function offset_parser($offset){
  return "OFFSET $offset";
}

function find_many_query($table, $option = []) {
  $select = $option["select"] ? column_parser($option["select"]) : "*";
  $where = $option["where"] ? where_parser($option["where"]) : null;
  $join = $option["join"] ?? null;
  $limit = $option["limit"] ? limit_parser($option["limit"]) : null;
  $offset = $option["offset"] ? offset_parser($option["offset"]) : null;
  $query = [
    "SELECT",
    $select,
    "FROM",
    $table,
    $where,
    $join,
    $limit,
    $offset
  ];

  return implode(" ", array_filter($query));
} 

function find_first_query($table, $option = []) {
  $option["limit"] = 1;
  $option["offset"] = null;
  return find_many_query($table, $option);
} 

function find_many($table, $option = []){
  $query = find_many_query($table, $option);
  return DB()->query($query)->fetch_all(MYSQLI_ASSOC);
}

function find_first($table, $option = []){
  $query = find_first_query($table, $option);
  return DB()->query($query)->fetch_assoc();
}


function insert_query($table, $values){
  $cols = column_parser(array_keys($values));
  $values_ = implode(", ", array_map('value_parser', $values)); 
  
  return "INSERT INTO $table $cols VALUES ($values_)";
}

function update_query($table, $values, $where){
  $values_ = set_parser($values);
  return "UPDATE $table SET $values_ WHERE $where"; 
}

function delete_query($table, $where){
  return "DELETE FROM $table WHERE $where";
}

function insert($table, $values){
  $query = insert_query($table, $values);
  return DB()->query($query);
}

function update($table, $values, $where){
  $query = update_query($table, $values, $where);
  return DB()->query($query);
}

function delete_($table, $where){
  $query = delete_query($table, $where);
  return DB()->query($query);
}


