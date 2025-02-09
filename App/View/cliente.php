<?php
    require '../Controller/Usuario.php';

    
    //___________________CADASTRAR__________________________

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
    //______________________LISTAR________________________________

    if (isset($_POST['acao']) && $_POST['acao'] == 'Listar') {
        $usuario = new Usuario();
        $clientes = $usuario->buscar(); // Obtém todos os clientes
    
        if (!empty($clientes)) {
            echo "<div class='tabela-container'>"; // Div para controle da tabela
            echo "<table class='tabela-clientes'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th><th>Nome</th><th>Email</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    
            foreach ($clientes as $cliente) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($cliente['id_usuario']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['nome']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['email']) . "</td>";
                echo "</tr>";
            }
    
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='msg-vazio'>Nenhum cliente encontrado.</p>";
        }
    }

     
    //____________________EDITAR___________________________
    $id_editar = $nome_editar = $email_editar = $senha_editar = '';
    if (isset($_POST['ID_editar'])) {
        // Verifica qual ação foi solicitada: buscar ou atualizar
        if ($_POST['acao'] == 'Procurar') {
            // Buscar os dados do usuário
            $id_editar = $_POST['ID_editar'];
            $usuario = new Usuario();
            $buscar = $usuario->buscar_por_id($id_editar);

            if ($buscar) {
                $usuario->id_usuario = (int) $buscar->id_usuario;
                $nome_editar = $buscar->nome;
                $email_editar = $buscar->email;
                $senha_editar = $buscar->senha;
            } else {
                // Caso não encontre o usuário
                $nome_editar = $email_editar = $senha_editar = '';
            }
        }
        
        // Se o botão "Salvar Alterações" for clicado
        if ($_POST['acao'] == 'Salvar Alterações') {
            // Obter os dados do formulário
            $id_editar = $_POST['id_usuario_editar'];
            $nome_editar = $_POST['nome_editar'];
            $email_editar = $_POST['email_editar'];
            $senha_editar = $_POST['senha_editar'];
            $confSenha_editar = $_POST['confSenha_editar'];

            // Verifique se os campos estão preenchidos corretamente
            if (!empty($nome_editar) && !empty($email_editar) && !empty($senha_editar) && !empty($confSenha_editar)) {
                // Verifique se as senhas coincidem
                if ($senha_editar == $confSenha_editar) {
                    // Crie o objeto Usuario e atribua os novos valores
                    $usuario = new Usuario();

                    $usuario->id_usuario = (int) $id_editar;
                    $usuario->nome = $nome_editar;
                    $usuario->email = $email_editar;
                    $usuario->senha = $senha_editar;

                    // Chame a função de atualizar
                    if ($usuario->atualizar()) {
                        ?>
                        <div class="msg-sucesso">
                            <p>Cadastro atualizado com sucesso!</p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="msg-erro">
                            <p>Erro ao atualizar cadastro. Tente novamente.</p>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="msg-erro">
                        <p>As senhas não coincidem.</p>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="msg-erro">
                    <p>Preencha todos os campos corretamente.</p>
                </div>
                <?php
            }
        }
    }
    
    //________________________Excluir_____________________________
    if (isset($_POST['id_excluir']) && $_POST['acao'] == 'Excluir') {
        // Obtém o ID do usuário a ser excluído
        $id_excluir = $_POST['id_excluir'];
    
        // Cria o objeto Usuario
        $usuario = new Usuario();
    
        // Atribui o id do usuário que será excluído
        $usuario->id_usuario = (int) $id_excluir;
    
        // Chama o método excluir da classe Usuario
        if ($usuario->excluir() !==true) {
            ?>
            <div class="msg-sucesso">
                <p>Usuário excluído com sucesso!</p>
            </div>
            <?php
        } else {
            ?>
            <div class="msg-erro">
                <p>Erro ao excluir o usuário. Tente novamente.</p>
            </div>
            <?php
        }
    }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Cadastro</title>
    <link rel="stylesheet" href="../../public/assets/css/style-cliente.css">
</head>
<body>


    <h2>CADASTRO DE CLIENTE</h2><br>
    <form action="" method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" id="" placeholder="Nome Completo."><br>
        <label>Email:</label><br>
        <input type="email" name="email" id="" placeholder="digite seu e-mail."><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" id="" placeholder="Digite sua senha."><br>
        <label>Confirmar Senha:</label><br>
        <input type="password" name="confSenha" id="" placeholder="Confirme sua Senha"><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <h2>LISTAR CLIENTES</h2><br>
    <form action="" method="post">
        
        
        <input type="submit" name="acao" value="Listar">
    </form>  


    <h2>EDITAR CLIENTE</h2><br>
    <form action="" method="post">
        <label>ID do Cadastro:</label><br>
        <input type="text" name="ID_editar" id="" placeholder="Informe o ID do cadastro" value="<?php echo $id_editar; ?>">
        <input type="submit" name="acao" value="Procurar"><br>

        <label>ID:</label><br>
        <input type="text" name="id_usuario_editar" value="<?php echo $id_editar; ?>" readonly><br>

        <label>Nome:</label><br>
        <input type="text" name="nome_editar" id="" placeholder="Nome Completo" value="<?php echo $nome_editar; ?>"><br>

        <label>Email:</label><br>
        <input type="email" name="email_editar" id="" placeholder="digite seu e-mail." value="<?php echo $email_editar; ?>"><br>

        <label>Senha:</label><br>
        <input type="password" name="senha_editar" id="" placeholder="Digite sua senha." value="<?php echo $senha_editar; ?>"><br>

        <label>Confirmar Senha:</label><br>
        <input type="password" name="confSenha_editar" id="" placeholder="Confirme sua Senha"><br><br>

        <input type="submit" name="acao" value="Salvar Alterações"><br>
        
    </form>


    <h2>EXCLUIR CADASTRO</h2><br>
    <form id="form-excluir" action="" method="post">
        <label>ID do Cadastro:</label><br>
        <input type="text" name="id_excluir" id="id_excluir" placeholder="ID a ser excluído."><br>
        <input type="hidden" name="acao" value="Excluir">
        <button type="button" onclick="confirmarExclusao()">Excluir</button> 
    </form>

    <div id="modalConfirmacao" class="modal">
        <div class="modal-content">
            <p>Tem certeza que deseja excluir este usuário?</p>
            <button onclick="executarExclusao()">Sim</button>
            <button onclick="fecharModal()">Não</button>
        </div>
    </div>

      
     <script src="../../public/js/modal-confirmacao.js"></script>
</body>
</html>