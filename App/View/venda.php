<?php
    require '../Controller/Venda.php';
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Cadastro</title>
</head>
<body>
    <h2>NOVO PEDIDO</h2><br>
    <form action="" method="post">
        <label>Cliente:</label><br>
        <input type="text" name="nome" id="" placeholder="Nome Completo."><br>
        <label>Produto:</label><br>
        <input type="text" name="nome" id="" placeholder="Nome Completo."><br>
        <label>Quantidade:</label><br>
        <input type="text" name="email" id="" placeholder="digite seu e-mail."><br>
        <label>Valor:</label><br>
        <input type="text" name="email" id="" placeholder="digite seu e-mail."><br>
        <label>Vendedor:</label><br>
        

        <input type="submit" value="Cadastrar">
    </form>
    <h2>EDITAR PEDIDO</h2><br>
    <form action="" method="post">
        <label>ID do Cadastro:</label><br>
        <input type="text" name="nome" id="" placeholder="Informe o ID do usuário a ser editado"><br>
        <label>Nome:</label><br>
        <input type="text" name="nome" id="" placeholder="Nome Completo."><br>
        <label>Descrição:</label><br>
        <input type="email" name="email" id="" placeholder="digite seu e-mail."><br>
        <label>Quantidade:</label><br>
        <input type="text" name="senha" id="" placeholder="Digite sua senha."><br>
        <label>Valor Unitário:</label><br>
        <input type="text" name="confSenha" id="" placeholder="Confirme sua Senha"><br><br>

        <input type="submit" value="Salvar">
    </form>
    <h2>EXCLUIR PEDIDO</h2><br>
    <form action="" method="post">
        <label>ID do Cadastro:</label><br>
        <input type="text" name="nome" id="" placeholder="ID a ser excluído."><br>
        

        <input type="submit" value="Cadastrar">
    </form>
    <h2>LISTAR PEDIDOS</h2><br>
    <form action="" method="post">
        
        
        <input type="submit" value="Listar">
    </form>    

    <?php

        if(isset($_POST['nome']))
        {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confSenha = addslashes($_POST['confSenha']);

            $usuario = new Usuario();
            $usuario->nome = $nome;
            $usuario->email = $email;
            $usuario->senha = $senha;

            if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confSenha))
            {
               
                if($senha == $confSenha)
                {
                    if($usuario->cadastrar())
                    {
                        ?>
                            <!-- bloco de HTML -->
                            <div class="msg-sucesso">
                                <p>Cadastrado com Sucesso</p>
                                <p>Clique <a href="../../index.php">aqui</a>para logar.</p>
                            </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="msg_erro">
                            <p>Email já cadastrado.</p>
                        </div>
                        <?php 
                        }
                }
                else
                {
                    ?>
                    <div class="msg_erro">
                        <p>Senhas não conferem.</p>
                    </div>
                    <?php
                }
               
            }
            else
            {
                ?>
                    <div class="msg-erro">
                        <p>Preencha todos os campos.</p>
                    </div>
                <?php
            }
        
        }
    ?>

</body>
</html>