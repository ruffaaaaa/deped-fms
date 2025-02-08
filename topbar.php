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
    .top-bar, .title-fms {
        display: none;
    }

    .image-logo {
        width: 20px;
        height: 20px;
        margin-top:-10px;
    }

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

        .title-fms {
        display: flex;
        justify-content: center; /* Horizontally center */
        align-items: center; /* Vertically center */
        width: 100%; /* Make it take full width */
        text-align: center; /* Ensure text is centered */
    }


    .top-bar{
        display: block;
        margin-bottom: 10px;
    }
    }
</style>

<nav class=" fixed-top bg-dark top-bar" style="padding:0;">
    <div class="container-fluid mt-2 mb-2">
        <div class="row w-100">
            <!-- Logo Section -->
            <!-- <div class="col-md-1 col-3 d-flex justify-content-center align-items-center">
                <div class="logo">
                    <i class="fa fa-share-alt"></i> 
                </div>
            </div> -->

            <div class="col-12 d-flex justify-content-center align-items-center">
                <img src="/deped-fms/assets/img/Group 35.png" class="image-logo">
                <p class="title-fms text-sm text-white text-uppercase font-bold mx-2 mt-2">File Management System</p>
            </div>

            <!-- <div class="col-md-3 col-3 d-flex justify-content-center align-items-center">
                <a href="ajax.php?action=logout" class="logout-link">
                    <?php /* echo $_SESSION['login_name'] */ ?> <i class="fa fa-power-off"></i>
                </a>
            </div> -->
       </div>
    </div>
</nav>
