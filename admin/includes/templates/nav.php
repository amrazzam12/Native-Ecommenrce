<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashbord.php">Souq</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="dashbord.php"><?php echo lang("HOME"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="categories.php"><?php echo lang("CATEGORIES"); ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="items.php"><?php echo lang("ITEMS"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="members.php?do=Manage"><?php echo lang("MEMBERS"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="comments.php?do=Manage"><?php echo lang("COMMENTS"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#"><?php echo lang("STATISTICS"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#"><?php echo lang("LOGS"); ?></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Amr
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['userid']; ?>">Edit Profile </a></li>
            <li><a class="dropdown-item" href="../index.php">Go To Website </a></li>

            <li><a class="dropdown-item" href="logout.php"><?php echo lang("LOGOUT"); ?></a></li>
          </ul>
        </li>

      </ul>

    </div>
  </div>
</nav>