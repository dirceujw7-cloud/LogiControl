// Adiciona linhas de produtos dinamicamente no formulário de frete.
document.addEventListener('DOMContentLoaded', () => {
    const botao = document.getElementById('adicionar-produto');
    const lista = document.getElementById('lista-produtos');
    if (botao && lista) {
        botao.addEventListener('click', () => {
            const modelo = lista.querySelector('.produto-linha');
            if (!modelo) return;
            const nova = modelo.cloneNode(true);
            nova.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
            nova.querySelectorAll('input').forEach(el => el.value = 1);
            lista.appendChild(nova);
        });
        lista.addEventListener('click', (evento) => {
            if (evento.target.classList.contains('remover-produto')) {
                const linhas = lista.querySelectorAll('.produto-linha');
                if (linhas.length > 1) evento.target.closest('.produto-linha').remove();
            }
        });
    }
});
