<?php //pornim sesiunea
      session_start();
      if (!isset($_SESSION['fail_to_login']))
      {
        $_SESSION['fail_to_login'] = '0';
      }
      if (!isset($_SESSION['logged_in_user']))
      {
        $_SESSION['logged_in_user'] = '0';
      }
      if (!isset($_SESSION['login_user']))
      {
        $_SESSION['login_user'] = '0';
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About</title>
  <link rel="stylesheet" href="stylesAll.css">
  <link rel="stylesheet" href="styles_about.css">
  <script src="https://kit.fontawesome.com/adab9891dd.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php   //register method
    $dupUser=0;
    $pdo = new PDO('sqlite:database.db');
    if(isset($_POST['submitRegister']))
      {  
        if ($_POST['password'] !== $_POST['Repassword']){   //parola e diferita de reconfirm parola
                echo "<div class='isa_error' id='warning'>
                <i class='fa fa-times-circle'></i>
                Passwords are not the same.
                </div>
                <script>
                setTimeout(function(){
                  document.getElementById('warning').style.display = 'none';
                  },3000);
                  </script>";
        }
        else{ //daca parolele sunt aceeleasi
            $statement = $pdo->prepare(
                "SELECT * FROM Users"
            );
            
            $statement->execute();
            
            while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['username'] === $_POST['username']){ //daca se gaseste un username cu user la fel =>eroare
                  echo "<div class='isa_error' id='warning'>
                  <i class='fa fa-times-circle'></i>
                  Username already exists.
                  </div>
                  <script>
                  setTimeout(function(){
                      document.getElementById('warning').style.display = 'none';
                      },3000);
                      </script>";
                  $dupUser=1;
                }
                  
            }
            if ($dupUser === 0){  //daca nu sunt useri cu username dublu insereaza in database
                $statement = $pdo->prepare(
                  "INSERT INTO Users (username, password) VALUES (:username, :password)"
                );
                $statement->execute([
                      ":username" => $_POST["username"],
                      ":password" => $_POST["password"]
                ]);
                echo "<div class='isa_success' id='succes'>
                  <i class='fa fa-times-circle'></i>
                  Account created successfully!
                  </div>
                  <script>
                  setTimeout(function(){
                      document.getElementById('succes').style.display = 'none';
                      },3000);
                      </script>";
            }
        }
      }
  ?>

    <!--Navbar-->
    <nav class="navbar">
      <div class="navbar__container">
        <a href="/" class="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
        <div class="navbar__toggle" id="mobile-menu">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
          <li class="navbar__item">
            <a href="./index.php" class="navbar__links">Home</a>
          </li>
          <?php
            if ($_SESSION['logged_in_user'] == '1'){  //daca utilizatorul e autentificat
              echo "<li class='navbar__item'>
                  <a href='./dashboard.php' class='navbar__links'>Dashboard</a>
              </li>";
            }
          ?>
          <li class="navbar__item">
            <a href="./About.php" class="navbar__links">About</a>
          </li>
          <li class="navbar__item">
              <a href="./Contact.php" class="navbar__links">Contact Us</a>
          </li>
          <?php
            if ($_SESSION['logged_in_user'] == '0'){  //daca utilizatorul nu e autentificat
              echo "<li class='navbar__button'>
              <a href='#' class='button' id='Register'>Register</a>
            </li>
            <li class='navbar__button'>
              <a href='#' class='button' id='LogIn'>Log In</a>
            </li>";
            }else{  //daca utilizatorul e autentificat
              echo "<li class='navbar__button'><form action='logOut.php' method='post'>
                  <button class='button' name = 'Logout' type = 'submit'>Log Out</button></form></li>";
            }
          ?>
        </ul>
      </div>
    </nav>

    <div class="about-section">
        <h1>About us</h1>
        <p>
            We are 3 students from Iasi and we are here to help you and your pet.
        </p>
    </div>

    <h2 style="text-align:center">Our Team</h2>
    <div class="row">
      <div class="column">
        <div class="card">
          <img src="images/rares_poza.jpg" alt="Rares" style="width:100%">
          <div class="container">
            <h2 style="text-align:center">Cires Rares</h2>
            <p style="text-align:center" class="title">Founder</p>
            <p style="text-align:center">I like turtles.</p>
            <p style="text-align:center"><button class="button2">Contact</button></p>
          </div>
        </div>
      </div>

      <div class="column">
        <div class="card2">
          <img src="images/vlad_poza.jpg" alt="Vlad" style="width:100%">
          <div class="container">
            <h2 style="text-align:center">Vlad Sarghe</h2>
            <p style="text-align:center" class="title">Founder</p>
            <p style="text-align:center">I like bears.</p>
            <p style="text-align:center"><button class="button2">Contact</button></p>
          </div>
        </div>
      </div>

      <div class="column">
        <div class="card3">
          <img src="images/cezar_poza.jpg" alt="Cezar" style="width:100%">
          <div class="container">
            <h2 style="text-align:center">Tudor Cezar</h2>
            <p style="text-align:center" class="title">Founder</p>
            <p style="text-align:center">I like birds.</p>
            <p style="text-align:center"><button class="button2">Contact</button></p>
          </div>
        </div>
      </div>
    </div>

    <div class="LogIn-modal">   
        <div class="modal-content">
            <div class="close" id = "close">+</div>
            <a class="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
            <form action="controller.php" method="post"> 
              <p><label for="username">Username:</label>
                    <input type="text" name="username" id="username" size="20" 
                    placeholder="Provide an username:" required/></p>
              <p><label for="password">Password:</label> 
                    <input type="password" name="password" id="password" size="20"
                    placeholder="Password" required/></p>
              <p><input type="submit" name ="submit" value="Log In"
                  title="Apasati butonul pentru a expedia datele spre server" /></p>
            </form> 
        </div>
      </div>

    <div class="Register-modal">
        <div class="Remodal-content">
          <div class="close" id = "close2">+</div>
          <a class="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
              <form method="post" enctype='multipart/form-data'>
                <p><label for="username">Username:</label>
                      <input type="text" name="username" id="Regiusername" size="20" 
                      placeholder="Provide an username:" required/></p>

                <p><label for="password">Password:</label> 
                      <input type="password" name="password" id="Regipassword" size="20"
                      placeholder="Password" required/></p>

                <p><label for="password">Retype password:</label> 
                <input type="password" name="Repassword" id="ReRegipassword" size="20"
                placeholder="Re-type password" required/></p>
                <p><input type="submit" name ="submitRegister" value="Register"
                    title="Apasati butonul pentru a expedia datele spre server" /></p>
              </form>     
        </div>
    </div>

    <div id="footer">
      <p>PET SMART MANAGER 2022</p>
    </div>
    
    <script>
      var el = document.getElementById('LogIn');
      if (el){
        document.getElementById("LogIn").addEventListener("click", function () {
        document.querySelector(".LogIn-modal").style.display = "flex";
        });
        document.getElementById("close").addEventListener("click", function () {
        document.querySelector(".LogIn-modal").style.display = "none";
        });
      }
    </script>
    
    <script>
        var el = document.getElementById('Register');
        if (el){
          document.getElementById("Register").addEventListener("click", function () {
          document.querySelector(".Register-modal").style.display = "flex";
          });
          document.getElementById("close2").addEventListener("click", function () {
          document.querySelector(".Register-modal").style.display = "none";
          });
        }
    </script>

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