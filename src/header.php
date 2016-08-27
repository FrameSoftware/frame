<ul id="drop_etud" class="dropdown-content">
    <li><a href="#"><i class="fa fa-user"></i>Mon compte</a></li>
    <li><a href="default/default/unauth"><i class="fa fa-exit"></i>Deconnection</a></li>
</ul>
<div class="navbar-fixed col s10">
    <nav class="red">
        <div class="nav-wrapper">
          <a href="#" class="brand-logo left">UB Messenger</a>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars"></i></a>
          <ul  class="right hide-on-med-and-down">
              <li><a class="dropdown-button" data-activates="drop_etud" href="#"><?php echo $_SESSION['nom'] ?>&nbsp;<i class="fa fa-angle-down"></i></a></li>
          </ul>
        </div>
      </nav>
</div>