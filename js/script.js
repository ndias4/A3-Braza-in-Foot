document.getElementById("loginForm").addEventListener("submit", function (e) {
    const chave = this.chave.value.trim();
    const senha = this.senha.value.trim();
  
    if (!chave || !senha) {
      e.preventDefault();
      alert("Preencha todos os campos!");
    }
  });
  