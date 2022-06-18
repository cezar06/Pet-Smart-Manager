<?php //pornim sesiunea
      session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel = "icon" href = 
      "https://cdn3.iconfinder.com/data/icons/animals-114/48/dog_animal_pet_canine-512.png" 
        type = "image/x-icon">
    <link rel="stylesheet" href="stylesAll.css" />
    <link rel="stylesheet" href="styles_dashboard.css" />
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
   <?php   //register method
    $dupUser=0;
    $pdo = new PDO('sqlite:database.db');
    if(isset($_POST['submitRegister']))
          {  
            if (htmlspecialchars($_POST['password']) !== htmlspecialchars($_POST['Repassword'])){   //parola e diferita de reconfirm parola
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
            else{
                $statement = $pdo->prepare(
                    "SELECT * FROM Users"
                );
                
                $statement->execute();
                
                while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
                    if (htmlspecialchars($row['username']) === htmlspecialchars($_POST['username'])){
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
                if ($dupUser === 0){
                    $statement = $pdo->prepare(
                      "INSERT INTO Users (username, password) VALUES (:username, :password)"
                    );
                    $statement->execute([
                          ":username" => $_POST["username"],
                          ":password" => password_hash($_POST["password"], PASSWORD_DEFAULT)
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
            <a class="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
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
                  if ($_SESSION['logged_in_user'] == '1'){
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
                  if ($_SESSION['logged_in_user'] == '0'){
                  echo "<li class='navbar__button'>
                  <a href='#' class='button' id='Register'>Register</a>
                  </li>
                  <li class='navbar__button'>
                  <a href='#' class='button' id='LogIn'>Log In</a>
                  </li>";
                  }else{
                  echo "<li class='navbar__button'><form action='logOut.php' method='post'>
                  <button class='button' name = 'Logout' type = 'submit'>Log Out</button></form></li>";
                  }
               ?>
            </ul>
         </div>
      </nav>

      <div class="dashboard">
         <div class="dashboard__container">
            <ul class="dashboard__header">
               <li class="dashboard__item">
                  <p id="petlist">These are your pets</p>
               </li>
               <li class="dashboard__item">
                  <a href="#" class="dashboard__button" id="addpet">Add a pet</a>
               </li>
            </ul>
            <div class="image-grid">
               <?php
                  $pdo = new PDO('sqlite:database.db');
                  if(isset($_POST['final']))
                        {  
                          
                           $statement = $pdo->prepare(
                               "SELECT * FROM Pets WHERE petname = :pet_name AND owner = :user_id"
                           );
                           $statement->execute([
                               ":pet_name" => $_POST["pettnameform"],
                               ":user_id" => $_SESSION['login_user']
                           ]);                           
                           $result = $statement->fetchAll();
                          
                           if(count($result) > 0)
                           {
                              echo "<script>alert('Pet already exists');</script>";
                           }
                           else
                           {
                              $statement = $pdo->prepare("INSERT INTO Pets (owner, petname, image) VALUES (:owner, :petname, :image)");
                           $statement->execute(array(
                              ':owner' => $_SESSION['login_user'],
                              ':petname' => $_POST['pettnameform'],
                              ':image' => file_get_contents($_FILES["file"]["tmp_name"])
                           ));
                        }}
                  $statement = $pdo->query("SELECT * FROM Pets WHERE owner = '".$_SESSION['login_user']."'");
                  while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                     echo '<div class="pet__item">';
                     echo '<a href="petProfile.php?value='.$row['petname'].'&amp;user='.$_SESSION['login_user'].'"><img src="data:image/png;base64,' . base64_encode($row['image']) . '" class="display-image" class="display-image2" alt="image of pet"></a>';
                     echo '<p class="pet__name">'.$row['petname'].'</p>';
                     echo '</div>';
                  }
               ?>
         </div>
      </div>

      <div class="bg-modal">
         <div class="modal-content">
            <div class="close">+</div>
            <p class="simple-text">Add a pet!</p>
            <form method="post" enctype='multipart/form-data'>
               <input id="nume" type="text" placeholder="Name" name="pettnameform" required/><br />
               <input
                  id="imagine"
                  type="file"
                  accept="image/*"
                  name="file"
                  required
                  />
                  <?php 
                  ?>
               <input type="submit" name="final" value="Add" />
            </form>
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
        var el = document.getElementById('addpet');
        if (el){
          document.getElementById("addpet").addEventListener("click", function () {
          document.querySelector(".bg-modal").style.display = "flex";
          });
          document.querySelector(".close").addEventListener("click", function () {
          document.querySelector(".bg-modal").style.display = "none";
          });
        }
      </script>
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

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


   </body>
</html>