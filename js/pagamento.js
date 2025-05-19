document.getElementById('cep').addEventListener('blur', calcularFrete);
document.getElementById('formPagamento').addEventListener('submit', finalizarCompra);

function calcularFrete() {
    const cep = document.getElementById('cep').value;

    if (!cep.match(/^[0-9]{8}$/)) {
        alert('Digite um CEP válido (somente números, 8 dígitos)');
        return;
    }

    let frete = cep.startsWith('90') ? 25.90 : 39.90;
    document.getElementById('frete').innerText = `R$ ${frete.toFixed(2).replace('.', ',')}`;
}

function finalizarCompra(event) {
    event.preventDefault();
    alert('Compra finalizada com sucesso!');
    window.location.href = 'home.php';
}
