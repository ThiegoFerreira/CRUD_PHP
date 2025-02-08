<?php

require '../Model/Database.php';

$banco = new Database('');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
</head>
<body>
    <form action="adm.php" method="POST">
        <label for="">Nome: </label>
        <input type="text" name = nome placeholder = "Digite o usuário">
        <label for="">Senha: </label>
        <input type= "password" name= senha placeholder = "Digite a senha">

        <button type="submit">Entrar</button>

    </form>
</body>
</html>