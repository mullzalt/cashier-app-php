<?php

require_once __DIR__ . "/config.php";

function DB(){
  return new mysqli(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME
  );
}
