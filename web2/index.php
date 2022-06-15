<?php
      session_start();
      $_SESSION['logged_in_user_id'];
      $_SESSION['fail_to_login'];
      $_SESSION['contor_login'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pet Smart Manager</title>
    <link rel="stylesheet" href="stylesAll.css" />
    <script
      src="https://kit.fontawesome.com/adab9891dd.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>

    <?php
      if (!isset($_SESSION['fail_to_login']))
      {
        $_SESSION['fail_to_login'] = '0';
      }
      if (!isset($_SESSION['logged_in_user_id']))
      {
        $_SESSION['logged_in_user_id'] = '0';
      }
      if (!isset($_SESSION['logged_in_user_id']))
      {
        $_SESSION['contor_login'] = '0';
      }
      if ($_SESSION['fail_to_login'] == '1'){
        echo "<div class='isa_error' id='warning'>
              <i class='fa fa-times-circle'></i>
              Username or password is incorrect
              </div>
              <script>
              setTimeout(function(){
                  document.getElementById('warning').style.display = 'none';
                  },3000);
                  </script>";
        $_SESSION['fail_to_login'] = '0';
      }else if ($_SESSION['logged_in_user_id'] == '1' && $_SESSION['contor_login'] == '1'){
        $_SESSION['contor_login']++;
        echo "<div class='isa_success' id='succes'>
              <i class='fa fa-times-circle'></i>
              Login Successful!
              </div>
              <script>
              setTimeout(function(){
                  document.getElementById('succes').style.display = 'none';
                  },3000);
                  </script>";
      }
    ?>
    <!--Navbar-->
    <nav class="navbar">
      <div class="navbar__container">
        <a href="/" id="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
        <div class="navbar__toggle" id="mobile-menu">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
          <li class="navbar__item">
            <a href="./index.php" class="navbar__links">Home</a>
          </li>
          <li class="navbar__item">
            <a href="./dashboard.php" class="navbar__links">Dashboard</a>
          </li>
          <li class="navbar__item">
            <a href="./About.php" class="navbar__links">About</a>
          </li>
          <li class="navbar__item">
              <a href="./Contact.php" class="navbar__links">Contact Us</a>
          </li>
          <?php
            if ($_SESSION['logged_in_user_id'] == '0'){
              echo "<li class='navbar__button'>
              <a href='/' class='button'>Register</a>
            </li>
            <li class='navbar__button'>
              <a href='/' class='button'>Log In</a>
            </li>";
            }else{
              echo "<li class='navbar__button'>
              <a href='/' class='button'>Log Out</a>
            </li>";
            }
          ?>
          
        </ul>
      </div>
    </nav>

    <!--2-->
    <div class="main">
      <div class="main__container">
        <div class="main__content">
          <h1>PET SMART</h1>
          <h2>MANAGER</h2>
          <p>Manage your pets</p>
          <button class="main__button"><a href="/">Get Started</a></button>
        </div>
        <div class="main_img--container">
          <img src="images/welcome.svg" alt="pic" id="main__img" />
        </div>
      </div>
    </div>

    <div id="footer">
      <p>PET SMART MANAGER 2022</p>
    </div>
    <script>
      const menu = document.querySelector("#mobile-menu");
      const menuLinks = document.querySelector(".navbar__menu");

      menu.addEventListener("click", function () {
        menu.classList.toggle("is-active");
        menuLinks.classList.toggle("active");
      });
    </script>
  </body>
</html>
