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
          <li><a href="">Home</a></li>
          <?php if($isAuth) { ?><!-- L'utilisateur est connecté -->
            <!-- <li><a href="index.php?page=genus">Genus</a></li> -->
            <!-- <li><a href="#">Parameters</a></li> -->
            <li><a href="index.php?page=samples">Sample gestion</a></li>
            <li><a href="index.php?page=results">Results</a></li>
            <!-- <li><a href="#">Exit</a></li> -->
            <li><a href="index.php?page=help">Help</a></li>
          <?php } ?>
        </ul>
        <!-- Here was the log in and log out -->
        <ul class="right">
          <?php if($isAuth) { ?>
            <li><a href="index.php?logout">LOG OUT</a></li>
          <?php } ?>
        </ul>

      </div>
    </nav>
  </div>
</header>
