
<?php

$data = ["one" => "one2", "two" => "two2"];
$json = json_encode(["one" => "one2", "two" => "two2"]);

header("Content-Type: application/json");

echo $json;
?>