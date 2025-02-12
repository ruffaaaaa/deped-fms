<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <title>FMS | Login</title>

  <?php include('./header.php'); ?>
  <?php 
  session_start();
  if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
  ?>

  </head>
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      font-family: Arial, sans-serif;
      background-image: url("/asset/img/background.png");
    }

    main#main {
      display: flex;
      flex-wrap: wrap;
      width: 100%;
      height: 100vh;
      background: white;
    }

    #login-left {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #fff;
    }

    #login-right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #ff6600;
      padding: 2rem;
    }

    .logo {
      text-align: center;
      margin: auto;
    padding-bottom: 10px;
    }

    .logo img {
      max-width: 80%;
      height: auto;
    }

    .login-body {
      width: 100%;
      max-width: 480px;
      padding: 4rem;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      height:75%;
      justify-content: center;
    }

    /* .login-body {
      
    } */

    .form-group {
      margin-bottom: 1rem;
      
    }

    .form-group label {
      margin-bottom: 0.5rem;
      display: block;
      color: #333;
    }

    .form-group input {
      width: 100%;
      padding: 1.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
    }

    .btn-primary {
      background-color: #ff6600;
      border: none;
      color: white;
      padding: 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 4rem;
      
    }

    .btn-primary:hover {
      background-color: #e65c00;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border-radius: 4px;
      border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
      #login-left,
      #login-right {
        flex: 1 1 100%;
        height: auto;
      }

      .card {
        margin-top: 1rem;
      }
    }

    @media (max-width: 480px) {
      .logo img {
        max-width: 60%;
      }
    }

  </style>

  <body>
    <main id="main">
      <div id="login-left">
        <div class="logo">
          <img src="logo.png" class="img-fluid" alt="Logo" />
        </div>
      </div>

      <div id="login-right">
        <div class="login-body">
          <div class="">
            <div style="text-align: center; font-weight: bolder; font-size: 20px;">
              <p class="text-[26px] uppercase" style="margin-bottom: 2rem" >File Management System</p>
            </div>
            <form id="login-form">
              <div class="form-group">
                <input type="text" id="username" name="username" class="form-control rounded-pill" placeholder="Username" required>
              </div>
              <div class="form-group">
                <input type="password" id="password" name="password" class="form-control rounded-pill" placeholder="Password" required>
              </div>
              <center>
                <button type="submit" class="btn-sm btn-block btn-wave col-md-12 rounded-pill btn-primary">
                  Login
                </button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <script>
      $('#login-form').submit(function (e) {
        e.preventDefault();
        $(this).find('button').attr('disabled', true).text('Logging in...');
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();

        $.ajax({
          url: 'ajax.php?action=login',
          method: 'POST',
          data: $(this).serialize(),
          error: err => {
            console.log(err);
            $('#login-form button').removeAttr('disabled').text('Login');
          },
          success: function (resp) {
            if (resp == 1) {
              location.reload('index.php?page=home');
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
              $('#login-form button').removeAttr('disabled').text('Login');
            }
          }
        });
      });
    </script>
  </body>

</html>