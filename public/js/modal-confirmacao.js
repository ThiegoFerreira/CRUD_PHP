function confirmarExclusao() {
    var id = document.getElementById("id_excluir").value;

    // Verifica se o ID foi preenchido antes de exibir o modal
    if (id.trim() === "") {
        alert("Por favor, informe um ID para excluir.");
        return;
    }

    // Exibe o modal apenas na exclusão
    document.getElementById("modalConfirmacao").style.display = "flex";
}

function fecharModal() {
    document.getElementById("modalConfirmacao").style.display = "none";
}

function executarExclusao() {
    // Fecha o modal
    fecharModal();

    // Agora sim, submete o formulário
    document.getElementById("form-excluir").submit();
}