<style>
  /* Sidebar container */
  #sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 230px;
    height: 100%;
    background-color: #343a40;
    z-index: 900;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
  }

  /* Sidebar list styles */
  .sidebar-list {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Allow items to grow and push logout to bottom */
  }

  .nav-item {
    display: flex;
    align-items: center; /* Align the text and icon vertically */
    padding: 10px 15px;
    text-decoration: none;
    color: white;
    font-size: 14px;
    width: 100%; /* Ensure the nav item spans the full width */
  }

  .nav-item:hover,
  .nav-item.active {
    background-color: #007bff; /* Add a blue background on hover or active */
    color: white; /* Make text white when active */
  }

  .icon-field {
    margin-right: 10px;
  }

  /* Logout at the bottom */
  .logout-container {
    margin-top: auto; /* Pushes logout to the bottom */

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
    margin-left: 0; /* Default margin */
  }

  .hehe-title {
    margin-bottom:0 !important
  }

  .image-logo-nav {
    width: 20px;
    height: 20px;
    margin-right:10px;
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
      margin-left: 230px; /* Push content right to make room for the sidebar */
    }

    .burger-menu {
      display: block; /* Show the burger icon */
    }

    .hehe-title {
      margin-top:0;
    }
  }
</style>

<!-- Burger Menu -->
<div>
  <button class="burger-menu" id="burger-icon">
    <i class="fa fa-bars"></i>
  </button>
</div>

<!-- Sidebar -->
<nav id="sidebar" class="bg-dark">
  <div class="sidebar-list">
    
    <div class="text-white text-[13px] py-3 flex text-center justify-center">
      <img src="/deped-fms/assets/img/Group 35.png" class="image-logo-nav">
      <p class="hehe-title uppercase font-bold">FILE MANAGEMENT SYSTEM</p>
    </div>

    <a href="index.php?page=home" class="nav-item nav-home py-3">
      <span class="icon-field">
        <i class="fa fa-home"></i>
      </span>
      <span class="ms-1 uppercase">Dashboard</span>

    </a>
    <a href="index.php?page=files" class="nav-item nav-files py-3">
      <span class="icon-field">
        <i class="fa fa-file"></i>
      </span>
      <span class="ms-2 uppercase">Files</span>
    </a>
    <a href="index.php?page=shared_files" class="nav-item nav-shared_files py-3">
      <span class="icon-field">
        <i class="fa fa-share-alt"></i>
      </span>
      <span class="ms-2 uppercase">Shared Files</span>
    </a>
    <?php if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
      <a href="index.php?page=users" class="nav-item nav-users py-3">
        <span class="icon-field">
          <i class="fa fa-users"></i>
        </span>
        <span class="ms-1 uppercase "> Users</span>
      </a>
    <?php endif; ?>
  </div>

  <!-- Logout Button at Bottom -->
  <div class="logout-container">
    <a href="ajax.php?action=logout" class="nav-item logout-link d-flex align-items-center py-3">
      <span class="icon-field">
        <i class="fa fa-power-off"></i>
      </span> 
      <span class="ms-2">LOGOUT</span>
    </a>
  </div>
</nav>

<!-- Main content -->
<div id="content">
  <!-- Your page content goes here -->
</div>

<!-- JavaScript -->
<script>
  $(document).ready(function() {
    // Highlight the active page link based on the URL
    var page = "<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>";
    if (page) {
      $('.nav-' + page).addClass('active');
    }

    // Toggle sidebar visibility on burger menu click
    $('#burger-icon').click(function() {
      $('#sidebar').toggleClass('active');
      $('#content').toggleClass('active');
    });
  });
</script>
