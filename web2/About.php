<html>
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
<!--Navbar-->
<nav class="navbar">
  <div class="navbar__container">
      <a href="/" id="navbar__logo">
          <i class="fa-solid fa-cat"></i>PSM
      </a>
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
          <li class="navbar__button">
              <a href="/" class="button">Register</a>
          </li>
          <li class="navbar__button">
              <a href="/" class="button">Log in</a>
          </li>
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