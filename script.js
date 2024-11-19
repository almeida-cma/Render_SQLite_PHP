function abrirModal(acao, id = null, nome = '', email = '') {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('acao').value = acao;
    document.getElementById('userId').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('email').value = email;
    document.getElementById('modal-title').textContent = acao === 'editar' ? 'Editar Usuário' : 'Adicionar Usuário';
}

function fecharModal() {
    document.getElementById('modal').style.display = 'none';
}
