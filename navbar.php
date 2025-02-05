<style>
  /* Sidebar container */
  #sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background-color: #343a40;
    z-index: 1000;
    transition: transform 0.3s ease;
  }

  /* Sidebar list styles */
  .sidebar-list {
    list-style: none;
    padding: 0;
    margin-top: 60px; /* Add some space from top */
  }

  .nav-item {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    color: white;
    font-size: 18px;
  }

  .nav-item:hover,
  .nav-item.active {
    background-color: white;
  }

  .icon-field {
    margin-right: 10px;
  }

  /* Burger menu styles */
  .burger-menu {
    display: none;
    position: fixed;
    top: 12px;
    right: 20px;
    z-index: 1500;
    cursor: pointer;
	border: none;
	background-color: #343a40;
	color: white;
	font-size: 20px;
  }

  .burger-menu i {
    color: white;
    font-size: 30px;
  }

  /* Content container */
  #content {
    transition: margin-left 0.3s ease; /* Smooth transition for content */
  }

  /* Media query for mobile */
  @media (max-width: 768px) {
    #sidebar {
      transform: translateX(-250px); /* Initially hide sidebar off-screen */
    }

    #sidebar.active {
      transform: translateX(0); /* Show sidebar when active */
    }

    /* Shift content to the right when sidebar is active */
    #content.active {
      margin-left: 250px; /* Push content right to make room for the sidebar */
    }

    .burger-menu {
      display: block; /* Show the burger icon */
    }
  }
</style>


<!-- Burger Menu -->
<button class="burger-menu" id="burger-icon">
  <i class="fa fa-bars"></i>
</button>

<!-- Sidebar -->
<nav id="sidebar" class="mx-lt-5 bg-dark">
  <div class="sidebar-list">
    <a href="index.php?page=home" class="nav-item nav-home"><span class="icon-field"><i class="fa fa-home"></i></span> Dashboard</a>
    <a href="index.php?page=files" class="nav-item nav-files"><span class="icon-field"><i class="fa fa-file"></i></span> Files</a>
    <a href="index.php?page=shared_files" class="nav-item nav-shared_files"><span class="icon-field"><i class="fa fa-file"></i></span> Shared Files</a>
    <?php if ($_SESSION['login_type'] == 1): ?>
      <a href="index.php?page=users" class="nav-item nav-users"><span class="icon-field"><i class="fa fa-users"></i></span> Users</a>
    <?php endif; ?>
	<a href="ajax.php?action=logout" class="nav-item logout-link"> 
	<i class="fa fa-power-off"></i>
                    <?php echo $_SESSION['login_name'] ?> </a>
  </div>
</nav>

<!-- Main content -->
<div id="content">
  <!-- Your page content goes here -->
</div>


<!-- JavaScript -->
<script>
  $(document).ready(function() {
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>').addClass('active');

    $('#burger-icon').click(function() {
      $('#sidebar').toggleClass('active');
      $('#content').toggleClass('active');
    });
  });
</script>

