<?php
session_start();
//if session v ariable array 'petnames' is not set, set it to an empty array
if (!isset($_SESSION['petnames'])) {
    $_SESSION['petnames'] = array();
}
//if session variable array 'petimages' is not set, set it to an empty array
if (!isset($_SESSION['petimages'])) {
    $_SESSION['petimages'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="stylesAll.css" />
    <link rel="stylesheet" href="styles_dashboard.css" />
    <script
      src="https://kit.fontawesome.com/adab9891dd.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700%26display=swap"
      rel="stylesheet"
    />
  </head>
   <body>
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
            <a href="./index.html" class="navbar__links">Home</a>
          </li>
          <li class="navbar__item">
            <a href="./dashboard.php" class="navbar__links">Dashboard</a>
          </li>
          <li class="navbar__item">
            <a href="./About.html" class="navbar__links">About</a>
          </li>
          <li class="navbar__item">
              <a href="./Contact.html" class="navbar__links">Contact Us</a>
          </li>
          <li class="navbar__button">
            <a href="/" class="button">Register</a>
          </li>
          <li class="navbar__button">
            <a href="/" class="button">Log In</a>
          </li>
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
         if(isset($_POST['final']))
               {  
                  $pdo = new PDO('sqlite:database.db');
                  $statement = $pdo->prepare("INSERT INTO Pets (owner, petname, image) VALUES (:owner, :petname, :image)");
                  $statement->execute(array(
                     ':owner' => "placeholder",
                     ':petname' => $_POST['pettnameform'],
                     ':image' => file_get_contents($_FILES["file"]["tmp_name"])
                  ));
               }
         $pdo = new PDO('sqlite:database.db');
       
         $statement = $pdo->query("SELECT * FROM Pets");
        
         while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            echo '<div class="pet__item">';
            echo '<a href="petProfile.html"><img src="data:image/png;base64,' . base64_encode($row['image']) . '" id="display-image" class="display-image2"></a>';
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
               <input id="nume" type="text" placeholder="Name" name="pettnameform" /><br />
               <input
                  id="imagine"
                  type="file"
                  accept="image/jpeg, image/png, image/jpg"
                  name="file"
                  />
               <input type="submit" name="final">
            </form>
         </div>
      </div>
      <div id="footer">
      <p>PET SMART MANAGER 2022</p>
      </div>
      <script src ="index.js"></script>
      <script src="app.js"></script>
      <script src="addpet.js"></script>
      <script src="clickpet.js"></script>
      <script src="petlist.js"></script>
      <script src="database.db"></script>
      <script>
         document.getElementById("addpet").addEventListener("click", function () {
         document.querySelector(".bg-modal").style.display = "flex";
         });
         document.querySelector(".close").addEventListener("click", function () {
         document.querySelector(".bg-modal").style.display = "none";
         });
      </script>
      </div>
      </div>
   </body>
</html>