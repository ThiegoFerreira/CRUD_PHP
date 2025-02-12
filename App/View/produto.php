<?php
    require '../Controller/Produto.php';

    
    //___________________CADASTRAR__________________________

    if(isset($_POST['nome']))
    {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $valor = $_POST['valor'];

        $produto = new Produto();
        $produto->nome = $nome;
        $produto->descricao = $descricao;
        $produto->quantidade = $quantidade;
        $produto->valor = $valor;

        if(!empty($nome) && !empty($descricao) && !empty($quantidade) && !empty($valor))
        {

            if($produto->cadastrar())
            {
                echo "<script>
                            alert('Cadastrado com sucesso!');
                            window.location.href = window.location.href;
                          </script>";
            }  else {
                echo "<script>
                        alert('Erro.');
                      </script>";
            }        
        }
        else
        {
            echo "<script>
                alert('Erro: Preencha todos os campos.');
              </script>";
        }
    
    }
    //______________________LISTAR________________________________


    $produto = new Produto();
    $produtos = $produto->buscar(); // Obtém todos os clientes
     
    //____________________EDITAR___________________________
    $id_editar = $nome_editar = $descricao_editar = $quantidade_editar = $valor_editar = '';
    if (isset($_POST['ID_editar'])) {
        // Verifica qual ação foi solicitada: buscar ou atualizar
        if ($_POST['acao'] == 'Procurar') {
            // Buscar os dados do usuário
            $id_editar = $_POST['ID_editar'];
            $produto = new Produto();
            $buscar = $produto->buscar_por_id($id_editar);

            if ($buscar) {
                $produto->id_produto = (int) $buscar->id_produto;
                $nome_editar = $buscar->nome;
                $descricao_editar = $buscar->descricao;
                $quantidade_editar = $buscar->quantidade;
                $valor_editar = $buscar->valor;
            } else {
                // Caso não encontre o produto
                $id_editar = $nome_editar = $descricao_editar = $quantidade_editar = $valor_editar = '';
            }
        }
        
        // Se o botão "Salvar Alterações" for clicado
        if ($_POST['acao'] == 'Salvar Alterações') {
            // Obter os dados do formulário
            $id_editar = $_POST['id_produto_editar'];
            $nome_editar = $_POST['nome_editar'];
            $descricao_editar = $_POST['descricao_editar'];
            $quantidade_editar = $_POST['quantidade_editar'];
            $valor_editar = $_POST['valor_editar'];

            // Verifique se os campos estão preenchidos corretamente
            if (!empty($nome_editar) && !empty($descricao_editar) && !empty($quantidade_editar) && !empty($valor_editar)) {          
                // Crie o objeto Usuario e atribua os novos valores
                $produto = new Produto();

                $produto->id_produto = (int) $id_editar;
                $produto->nome = $nome_editar;
                $produto->descricao = $descricao_editar;
                $produto->quantidade = $quantidade_editar;
                $produto->valor = $valor_editar;

                // Chame a função de atualizar
                if ($produto->atualizar()) {
                    echo "<script>
                            alert('Produto atualizado com sucesso!');
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
        $produto = new Produto();
    
        // Atribui o id do usuário que será excluído
        $produto->id_produto = (int) $id_excluir;
    
        // Chama o método excluir da classe Usuario
        if ($produto->excluir() !==true) {
            echo "<script>
                    alert('Produto excluído com sucesso!');
                    window.location.href = window.location.href;
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao excluir o Produto. Tente novamente.');
                  </script>";
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
    <a href="../../index.php"><h2>VOLTAR</h2></a><br>
    <div class="titulo-container">
        <h2>CADASTRO DE PRODUTO</h2><br>
    </div>

    <div class="conteudo">
        <div class="container">
            <h2>CADASTRAR NOVO PRODUTO</h2>
            <div class="form-box">
                <form action="" method="post">
                    <label>Nome:</label><br>
                    <input type="text" name="nome" id="" placeholder="Nome do produto."><br>
                    <label>Descrição:</label><br>
                    <input type="text" name="descricao" id="" placeholder="Digite uma breve descricão."><br>
                    <label>Quantidade:</label><br>
                    <input type="number" name="quantidade" id="" min = "0" placeholder="Digite a quantidade."><br>
                    <label>Valor:</label><br>
                    <input type="number" name="valor" id="" step ="0.01" placeholder="Digite o valor."><br>
                    
                    <input type="submit" value="Cadastrar">
                </form>
            </div>

            <h2>EDITAR PRODUTO</h2>
            <div class="form-box">
                <form action="" method="post">
                    <label>ID do Cadastro:</label><br>
                    <input type="text" name="ID_editar" id="" placeholder="Informe o ID do cadastro" value="<?php echo $id_editar; ?>">
                    <input type="submit" name="acao" value="Procurar"><br>

                    <label>ID:</label><br>
                    <input type="text" name="id_produto_editar" value="<?php echo $id_editar; ?>" readonly><br>

                    <label>Nome:</label><br>
                    <input type="text" name="nome_editar" id="" placeholder="Nome do Produto" value="<?php echo $nome_editar; ?>"><br>

                    <label>Descrição:</label><br>
                    <input type="text" name="descricao_editar" id="" placeholder="Digite uma breve descricao" value="<?php echo $descricao_editar; ?>"><br>

                    <label>Quantidade:</label><br>
                    <input type="number" name="quantidade_editar" id="" min = "0" placeholder="Digite a quantidade" value="<?php echo $quantidade_editar; ?>"><br>

                    <label>Valor:</label><br>
                    <input type="number" name="valor_editar" id="" min= "0" step ="0.01" placeholder="Digite o valor." value="<?php echo $valor_editar; ?>"><br>

                    <input type="submit" name="acao" value="Salvar Alterações"><br>
                    
                </form>
            </div>


            <h2>EXCLUIR PRODUTO</h2>
            <div class="form-box">
                <form id="form-excluir" action="" method="post">
                    <label>ID do Cadastro:</label><br>
                    <input type="text" name="id_excluir" id="id_excluir" placeholder="ID a ser excluído."><br>
                    <input type="hidden" name="acao" value="Excluir">
                    <button type="button" onclick="confirmarExclusao()">Excluir</button> 
                </form>

                <div id="modalConfirmacao" class="modal">
                    <div class="modal-content">
                        <p>Tem certeza que deseja excluir este produto?</p>
                        <button onclick="executarExclusao()">Sim</button>
                        <button onclick="fecharModal()">Não</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container da tabela -->
        <div class="tabela-container">
            <h2>LISTA DE PRODUTOS</h2>
            <div class="tabela-box">
                <table class="tabela-clientes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>DESCRIÇÃO</th>
                            <th>QUANTIDADE</th>
                            <th>VALOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produtos)): ?>
                            <?php foreach ($produtos as $prod): ?>
                                <tr>
                                    <td><?= htmlspecialchars($prod['id_produto']) ?></td>
                                    <td><?= htmlspecialchars($prod['nome']) ?></td>
                                    <td><?= htmlspecialchars($prod['descricao']) ?></td>
                                    <td><?= htmlspecialchars($prod['quantidade']) ?></td>
                                    <td><?= htmlspecialchars($prod['valor']) ?></td>
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