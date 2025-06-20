<?php
include('conexao.php');

$id = $_GET['id'];
$ficha_id = $_GET['ficha_id'];

$conn->query("DELETE FROM rampas WHERE id = $id");

header("Location: rampas.php?ficha_id=$ficha_id");
exit;
?>
