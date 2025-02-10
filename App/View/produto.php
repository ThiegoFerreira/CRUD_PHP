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
                ?>
                    <!-- bloco de HTML -->
                    <div class="msg-sucesso">
                        <p>Cadastrado com Sucesso</p>
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
        $produto = new Produto();
        $produtos = $produto->buscar(); // Obtém todos os clientes
    
        if (!empty($produtos)) {
            echo "<div class='tabela-container'>"; // Div para controle da tabela
            echo "<table class='tabela-produtos'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th><th>Nome</th><th>Descrição</th><th>Quantidade</th><th>Valor</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    
            foreach ($produtos as $prod) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($prod['id_produto']) . "</td>";
                echo "<td>" . htmlspecialchars($prod['nome']) . "</td>";
                echo "<td>" . htmlspecialchars($prod['descricao']) . "</td>";
                echo "<td>" . htmlspecialchars($prod['quantidade']) . "</td>";
                echo "<td>" . htmlspecialchars($prod['valor']) . "</td>";
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
        $produto = new Produto();
    
        // Atribui o id do usuário que será excluído
        $produto->id_produto = (int) $id_excluir;
    
        // Chama o método excluir da classe Usuario
        if ($produto->excluir() !==true) {
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


    <h2>CADASTRO DE PRODUTO</h2><br>
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

    <h2>LISTAR PRODUTOS</h2><br>
    <form action="" method="post">      
        <input type="submit" name="acao" value="Listar">
    </form>  


    <h2>EDITAR PRODUTO</h2><br>
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


    <h2>EXCLUIR CADASTRO</h2><br>
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

      
     <script src="../../public/js/modal-confirmacao.js"></script>
</body>
</html>