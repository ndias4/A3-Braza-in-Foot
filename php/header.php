<header>
  <a href="home.php">
    <img class="logo" src="../images/IMG-20250409-WA0006.jpg" alt="Logo">
  </a>

  <div class="navbar">
    <a href="catalogo.php?categoria=novidades"><button class="nav-btn">Novidades</button></a>
    <a href="catalogo.php?categoria=masculino"><button class="nav-btn">Masculino</button></a>
    <a href="catalogo.php?categoria=feminino"><button class="nav-btn">Feminino</button></a>
    <a href="catalogo.php?categoria=infantil"><button class="nav-btn">Infantil</button></a>
    <a href="catalogo.php?categoria=esportivo"><button class="nav-btn">Esportivo</button></a>
  </div>

  <div class="icons">
  <div class="search">
    <input class="search-input" type="search" placeholder="Encontre o que você procura">
  </div>

  <div class="busca">
    <a href="#">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
    </a>
  </div>

  <div class="user">
    <a href="#" id="user-icon">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
    </a>

    <div id="user-dropdown" class="dropdown hidden">
    <p>Bem-vindo, <?= $_SESSION['user_nome'] ?? 'Usuário'; ?>!</p>
    <hr>
    <a href="#">Perfil</a>
    <a href="index.html">Sair</a>

    </div>
</div>

    <div class="carrinho">
      <a href="#">
        <img src="../images/icone_carrinho.png" class="icon-img" alt="Carrinho" />
      </a>
    </div>
  </div>
</header>
