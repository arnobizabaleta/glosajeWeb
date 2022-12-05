<?php
define('CLIENT_ID','AeSj5KsZUly-VNCwtdt9QaUBzdaYwxREaIUHwP-t77NHxIWxhZ5x7ToeQlz2rPT8yoVbDbC4WFYKDkD_');
define('CURRENCY','USD');
define('KEY_TOKEN','AZC.rmp-221*');
define('MONEDA','$');
session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>