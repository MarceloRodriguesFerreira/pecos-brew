<?php
$servername = "localhost";
$username = "root";
$password = "tafe2006";
$database = "pecosbrew";
$modo_dev = true; 
$erros_amigaveis = []; // Armazena mensagens de erro



// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
