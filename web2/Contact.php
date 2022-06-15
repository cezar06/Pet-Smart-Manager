<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact</title>
        <link rel="stylesheet" href="stylesAll.css">
        <link rel="stylesheet" href="styles_contact.css">
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

  <div class="page-body">
    <div class="contact-section">
        <h2>Let's talk</h2>
        <p>
            Do you have some big ideas, a random message or any kind of feedback for our website? 
            <br>
            Then please reach out, we would love to hear more about you, your idea and how we can help!
        </p>
    </div>

    <div>
        <form class="contact-form">      
            <input name="name" type="text" class="contact-data" placeholder="Name" />   
            <input name="email" type="text" class="contact-data" placeholder="Email" />
            <textarea name="text" class="contact-data" placeholder="Comment"></textarea>
            <br>
            <input type="submit" class="contact-data" value="SUBMIT"/>
        </form>
    </div>

    <div class="contact-data">
        <a href="#" class="fa fa-facebook"></a>
        <a href="#" class="fa fa-instagram"></a>
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