<?php
  $isAuth = $this->cast("coauth")->isAuthenticated();

  // var_dump($this->cast("coauth")->login('toto@gmail.com', 'toto'));

?>

<header>
  <div id="header" class="navbar-fixed" style="z-index: 998;">
    <nav>
      <div class="nav-wrapper">
        <a href="index.php" class="brand-logo center">NEMAID</a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
          <li><a href="#">Home</a></li>
          <li><a href="#">Genus</a></li>
          <?php if($isAuth) { ?><!-- L'utilisateur est connecté -->
            <li><a href="#">Parameters</a></li>
            <li><a href="index.php?page=sample">Sample</a></li>
            <li><a href="#">Results</a></li>
            <li><a href="#">Exit</a></li>
            <li><a href="#">Help</a></li>
          <?php } ?>
        </ul>
        <ul class="right">
          <?php if(!$isAuth) { ?>
          <li><a href="index.php?page=login">LOG IN</a></li>
        <?php } elseif($isAuth) { ?>
            <li><a href="index.php?logout">Logout</a></li>
          <?php } ?>
        </ul>

      </div>
    </nav>
  </div>
</header>
