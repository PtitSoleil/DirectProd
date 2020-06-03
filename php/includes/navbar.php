<nav class="navbar navbar-expand-lg navbar" style="background-color: #1e281e">

<a class="navbar-brand text-light" href="./index.php">Direct Prod</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php if (isLogged()): ?>
    <li class="nav-item active">
        <a class="nav-link text-light" href="./addAdvert.php"> <i class="fas fa-plus"></i> Ajouter une annonce</a>
      </li>
      <?php endif; ?>
      <li class="nav-item active">
        <a class="nav-link text-light" href="./researchAdvert.php"> <i class="fas fa-search"></i> Rerchercher une annonce</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php if (!isLogged()): ?>
      <li class="nav-item active">
        <a class="nav-link text-light" href="./login.php"> <i class="fas fa-sign-in-alt"></i> Connexion</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="./register.php"> <i class="fas fa-user-plus"></i> Inscription</a>
      </li>
      <?php else: ?>
        <li class="nav-item active">
          <a class="nav-link text-light" href="./myAdvert.php"> <i class="fas fa-bars"></i> Mes annonces</a>
        </li>
        <?php if ($_SESSION['admin'] == ADMIN): ?>
          <li class="nav-item active">
            <a class="nav-link text-light" href="./administration.php"> <i class="#"></i> Administration</a>
          </li>
        <?php endif; ?>
        <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo explode("@", $_SESSION['email'])[0] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./profile.php?idUser=<?php echo $_SESSION['id']?>"> <i class="fas fa-user"></i> Mon profil</a>
          <a class="dropdown-item" href="./logout.php"> <i class="fas fa-sign-out-alt"></i> Déconnexion</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  
</nav>