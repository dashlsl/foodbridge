<?php

include 'lib/db.php';

$db = Database::getInstance();

spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.php';
});

$users = new Users($db);
$donations = new Donations($db);
$admin = new Admin($db);
$deliveries = new Deliveries($db);

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css/root.css">
<base href="/foodbridge/">