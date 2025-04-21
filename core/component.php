<?php

require_once __DIR__ . "/config.php";


function render($layout_path, $data = []){
  extract($data); // safely pass data to layout

  include BASE_DIR . "/layouts/$layout_path.php";
}
