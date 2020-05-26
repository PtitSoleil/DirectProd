<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">

<a class="navbar-brand" href="./index.php">Direct Prod</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php if (isLogged()): ?>
    <li class="nav-item active">
        <a class="nav-link" href="./detailsAdvert.php"> <i class="fas fa-plus"></i>Ajouter une annonce</a>
      </li>
      <?php endif; ?>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php if (!isLogged()): ?>
      <li class="nav-item active">
        <a class="nav-link" href="./login.php"> <i class="fas fa-sign-in-alt"></i> Connexion</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./register.php"> <i class="fas fa-user-plus"></i> Inscription</a>
      </li>
      <?php else: ?>
      <li class="nav-item active">
        <a class="nav-link" href="./logout.php"> <i class="fas fa-sign-out-alt"></i> Déconnexion</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  
</nav>