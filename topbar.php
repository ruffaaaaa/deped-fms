<style>
    .logo {
        margin: auto;
        font-size: 20px;
        background: #fff;
        padding: 5px 11px;
        border-radius: 50%;
        color: #ff6600;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand p {
        margin-left: 10px;
        font-size: 1.1rem;
    }

    .logout-link {
        color: #fff;
    }

    /* Make the navbar elements center-align on small screens */
    @media (max-width: 768px) {
        .navbar-brand {
            flex-direction: column;
            text-align: center;
        }

        .navbar-brand p {
            margin-left: 0;
            font-size: 1.2rem;
        }

        .logout-link {
            margin-top: 10px;
            text-align: center;
        }
    }
</style>

<nav class="navbar navbar-dark bg-dark fixed-top" style="padding:0;">
    <div class="container-fluid mt-2 mb-2">
        <div class="row w-100">
            <!-- Logo Section -->
            <div class="col-md-1 col-3 d-flex justify-content-center align-items-center">
                <div class="logo">
                    <i class="fa fa-share-alt"></i> 
                </div>
            </div>

            <!-- Title Section -->
            <div class="col-md-8 col-6 d-flex justify-content-center align-items-center">
                <p class="m-0 text-white">File Management System</p>
            </div>

            <!-- Logout Section -->
            <!-- <div class="col-md-3 col-3 d-flex justify-content-center align-items-center">
                <a href="ajax.php?action=logout" class="logout-link">
                    <?php /* echo $_SESSION['login_name'] */ ?> <i class="fa fa-power-off"></i>
                </a>
            </div> -->
        </div>
    </div>
</nav>
