<?php
    require '../Controller/Usuario.php';

    
    //___________________CADASTRAR__________________________
if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = addslashes($_POST['confSenha']);

    $usuario = new Usuario();
    $usuario->nome = $nome;
    $usuario->email = $email;
    $usuario->senha = $senha;

    if (!empty($nome) && !empty($email) && !empty($senha) && !empty($confSenha)) {
        if ($senha == $confSenha) {
            if ($usuario->cadastrar()) {
                echo "<script>
                            alert('Cadastrado com sucesso!');
                            window.location.href = window.location.href;
                          </script>";
            } else {
                echo "<script>
                        alert('Erro: Email já cadastrado.');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Erro: As senhas não conferem.');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Erro: Preencha todos os campos.');
              </script>";
    }
}
    //______________________LISTAR________________________________

    $usuario = new Usuario();
    $clientes = $usuario->buscar(); // Obtém todos os clientes automaticamente

     
    //____________________EDITAR___________________________
$id_editar = $nome_editar = $email_editar = $senha_editar = '';
if (isset($_POST['ID_editar'])) {
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
            $nome_editar = $email_editar = $senha_editar = '';
        }
    }

    if ($_POST['acao'] == 'Salvar Alterações') {
        // Obter os dados do formulário
        $id_editar = $_POST['id_usuario_editar'];
        $nome_editar = $_POST['nome_editar'];
        $email_editar = $_POST['email_editar'];
        $senha_editar = $_POST['senha_editar'];
        $confSenha_editar = $_POST['confSenha_editar'];
    
        // Verifique se os campos estão preenchidos corretamente
        if (!empty($nome_editar) && !empty($email_editar) && !empty($senha_editar) && !empty($confSenha_editar)) {
            if ($senha_editar == $confSenha_editar) {
                $usuario = new Usuario();
                $usuario->id_usuario = (int) $id_editar;
                $usuario->nome = $nome_editar;
                $usuario->email = $email_editar;
                $usuario->senha = $senha_editar;
    
                // Chame a função de atualizar
                if ($usuario->atualizar()) {
                    echo "<script>
                            alert('Cadastro atualizado com sucesso!');
                            window.location.href = window.location.href;
                          </script>";
                    exit();
                } else {
                    echo "<script>
                            alert('Erro ao atualizar cadastro. Tente novamente.');
                          </script>";
                }
            } else {
                echo "<script>
                        alert('As senhas não coincidem.');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Preencha todos os campos corretamente.');
                  </script>";
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
        if ($usuario->excluir()!==true) { // Se for true, excluiu com sucesso
            echo "<script>
                    alert('Cadastro excluído com sucesso!');
                    window.location.href = window.location.href;
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao excluir o usuário. Tente novamente.');
                  </script>";
        }
    }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../../public/assets/css/style-cliente.css">
</head>
<body>
    <a href="../../index.php"><h2>VOLTAR</h2></a><br>
    <div class="titulo-container">
        <h2>CADASTRO DE CLIENTE</h2>
    </div>

    <div class="conteudo">
        <!-- Container dos formulários -->
        <div class="container">
            <h2>CADASTRAR NOVO CLIENTE</h2>
            <div class="form-box">
                <form action="" method="post">
                    <label>Nome:</label><br>
                    <input type="text" name="nome" placeholder="Nome Completo."><br>
                    <label>Email:</label><br>
                    <input type="email" name="email" placeholder="Digite seu e-mail."><br>
                    <label>Senha:</label><br>
                    <input type="password" name="senha" placeholder="Digite sua senha."><br>
                    <label>Confirmar Senha:</label><br>
                    <input type="password" name="confSenha" placeholder="Confirme sua Senha"><br><br>
                    <input type="submit" value="Cadastrar">
                </form>
            </div>

            <h2>EDITAR CLIENTE</h2>
            <div class="form-box">
                <form action="" method="post">
                    <label>ID do Cadastro:</label><br>
                    <input type="text" name="ID_editar" id="" placeholder="Informe o ID do cadastro" value="<?php echo $id_editar; ?>">
                    <input type="submit" name="acao" value="Procurar"><br>

                    <label>ID:</label><br>
                    <input type="text" name="id_usuario_editar" value="<?php echo $id_editar; ?>" readonly><br>

                    <label>Nome:</label><br>
                    <input type="text" name="nome_editar" id="" placeholder="Nome Completo" value="<?php echo $nome_editar; ?>"><br>

                    <label>Email:</label><br>
                    <input type="email" name="email_editar" id="" placeholder="Digite seu e-mail." value="<?php echo $email_editar; ?>"><br>

                    <label>Senha:</label><br>
                    <input type="password" name="senha_editar" id="" placeholder="Digite sua senha." value="<?php echo $senha_editar; ?>"><br>

                    <label>Confirmar Senha:</label><br>
                    <input type="password" name="confSenha_editar" id="" placeholder="Confirme sua Senha"><br><br>

                    <input type="submit" name="acao" value="Salvar Alterações"><br>
                    
                </form>
            </div>

            <h2>EXCLUIR CADASTRO</h2>
            <div class="form-box">
                <form id="form-excluir" action="" method="post">
                    <label>ID do Cadastro:</label><br>
                    <input type="text" name="id_excluir" id="id_excluir" placeholder="ID a ser excluído."><br>
                    <input type="hidden" name="acao" value="Excluir">
                    <button type="button" onclick="confirmarExclusao()">Excluir</button> 
                </form>

                <div id="modalConfirmacao" class="modal">
                    <div class="modal-content">
                        <p>Tem certeza que deseja excluir este cliente?</p>
                        <button onclick="executarExclusao()">Sim</button>
                        <button onclick="fecharModal()">Não</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container da tabela -->
        <div class="tabela-container">
            <h2>LISTA DE CLIENTES</h2>
            <div class="tabela-box">
                <table class="tabela-clientes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clientes)): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cliente['id_usuario']) ?></td>
                                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="msg-vazio">Nenhum cliente encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../public/js/modal-confirmacao.js"></script>

</body>
</html>