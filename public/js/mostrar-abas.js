function mostrarAba(id) {
    // Esconde todas as abas
    document.querySelectorAll('.aba-conteudo').forEach(function(aba) {
        aba.classList.remove('ativa');
    });

    // Remove a classe ativa dos botões
    document.querySelectorAll('.aba').forEach(function(botao) {
        botao.classList.remove('ativa');
    });

    // Exibe apenas a aba clicada
    document.getElementById(id).classList.add('ativa');

    // Ativa o botão correspondente
    document.querySelector(`[onclick="mostrarAba('${id}')"]`).classList.add('ativa');
}

// Exibe a primeira aba ao carregar a página
document.addEventListener("DOMContentLoaded", function() {
    mostrarAba('cadastro');
});