<?php //pornim sesiunea
      session_start();
?>

<?php
//if Session_logged_user is 0, then redirect to index.php
if ($_SESSION['logged_in_user'] == 0){
    header ("location: index.php");
    exit;
}
if ($_SESSION['login_user'] != $_GET['user']){
    header ("location: index.php");
    exit;
}
$pdo = new PDO("sqlite:database.db");
if (isset($_POST["send-event"])) {
    $year = date("Y", strtotime($_POST["event-date"]));
    $month = date("m", strtotime($_POST["event-date"]));
    $day = date("d", strtotime($_POST["event-date"]));
    //get the event type
    $event_type = $_POST["event-type"];
    $statement = $pdo->prepare(
        "INSERT INTO Calendar (username, year, month, day, text, petname, type) VALUES (:username, :year, :month, :day, :text, :petname, :type)"
    );
    $statement->execute([
        ":username" => $_SESSION['login_user'],
        ":year" => $year,
        ":month" => $month,
        ":day" => $day,
        ":text" => $_POST["event-desc"],
        ":petname" => $_GET["value"],
        ":type" => $event_type
    ]);
}
if (!empty($_POST["delete"]) && is_array($_POST["delete"])) {
    foreach ($_POST["delete"] as $id => $yyyymmdd) {
        $year = substr($id, 0, 4);
        $month = substr($id, 5, 2);
        $day = substr($id, 8, 2);
        $statement = $pdo->prepare(
            "DELETE FROM Calendar WHERE username = :username AND year = :year AND month = :month AND day = :day AND petname = :petname"
        );
        $statement->execute([
            ":username" => $_SESSION['login_user'],
            ":year" => $year,
            ":month" => $month,
            ":day" => $day,
            ":petname" => $_GET["value"],
        ]);
    }
}
if (!empty($_POST["delete2"]) && is_array($_POST["delete2"])) {
    foreach ($_POST["delete2"] as $id => $restrictie) {
        $statement = $pdo->prepare(
            "DELETE FROM Restrictions WHERE username = :username AND restriction = :restriction AND petname = :petname"
        );
        $statement->execute([
            ":username" => $_SESSION['login_user'],
            ":restriction" => $id,
            ":petname" => $_GET["value"],
        ]);
    }
}

// Set your timezone!!
date_default_timezone_set("Europe/Athens");
//if value is set in the URL, display it
if (isset($_GET["value"])) {
    $pet_id = $_GET["value"];
}
// Get prev & next month
if (isset($_GET["ym"])) {
    $ym = $_GET["ym"];
} else {
    // This month
    $ym = date("Y-m");
}




//split ym into year and month
$year = substr($ym, 0, 4);
$month = substr($ym, 5, 2);
// Check format
$timestamp = strtotime($ym . "-01"); // the first day of the month
if ($timestamp === false) {
    $ym = date("Y-m");
    $timestamp = strtotime($ym . "-01");
}

// Today (Format:2018-08-8)
$today = date("Y-m-j");

// Title (Format:August, 2018)
$title = date("F, Y", $timestamp);

// Create prev & next month link
$prev = date("Y-m", strtotime("-1 month", $timestamp));
$next = date("Y-m", strtotime("+1 month", $timestamp));

// Number of days in the month
$day_count = date("t", $timestamp);

// 1:Mon 2:Tue 3: Wed ... 7:Sun
$str = date("N", $timestamp);

// Array for calendar
$weeks = [];
$week = "";

// Add empty cell(s)
$week .= str_repeat("<td></td>", $str - 1);

//connect to sqlite database
//get all rows from the table "calendar" for user with username "ceva"
// $statement = $pdo->query(
//     "SELECT * FROM Calendar WHERE username = 'placeholder' AND petname = '$pet_id'"
// );
// $rows = [];
// while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
//     $rows[] = [
//         "year" => $row["year"],
//         "month" => $row["month"],
//         "day" => $row["day"],
//         "text" => $row["text"],
//     ];
// }


$statement = $pdo->prepare(
    "SELECT * FROM Calendar WHERE username = :username AND petname = :petname"
);

$statement->execute([
    ":username" => $_SESSION['login_user'],
    ":petname" => $pet_id,
]);
$rows = [];
while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
    $rows[] = [
        "year" => $row["year"],
        "month" => $row["month"],
        "day" => $row["day"],
        "text" => $row["text"],
        "type" => $row["type"],
    ];
}


//print_r for the column "date"
//loop through all rows and print them
for ($day = 1; $day <= $day_count; $day++, $str++) {
    $date = $ym . "-" . $day;

    if ($today == $date) {
        $week .= '<td class="today">';
    } else {
        $week .= "<td>";
    }
    $week .= "<div>";
    $week .= "<p>";
    $week .= $day;
    $week .= "</p>";
    //if day is single digit, create a new variable with a zero in front of it
    if ($day < 10) {
        $day = "0" . $day;
    }
    $week .=
        '<form method="post">
    <button type="submit" name="delete[' .
        $year .
        "-" .
        $month .
        "-" .
        $day .
        ']" class="btn-link-delete">Delete</button> </form>';
    //iterate through the rows array
    foreach ($rows as $row) {
        if (
            $row["year"] == $year &&
            $row["month"] == $month &&
            $row["day"] == $day
        ) {
            //  $week .= '<div class="event">' . $row["text"] . "</div>";
            // if type is medical, along with the text, display a red circle
            if ($row["type"] == "Medical") {
                $week .= '<div class="medical-event-text">' . $row["text"] . "</div>";
            } else if ($row["type"] == "Feeding") {
                $week .= '<div class="feeding-event-text">' . $row["text"] . "</div>";
            } else if ($row["type"] == "Life Event") {
                $week .= '<div class="life-event-text">' . $row["text"] . "</div>";
            } else if ($row["type"] == "Other") {
                $week .= '<div class="other-event-text">' . $row["text"] . "</div>";
            }
        }
    }

    $week .= "</div>";
    $week .= "</td>";

    // Sunday OR last day of the month
    if ($str % 7 == 0 || $day == $day_count) {
        // last day of the month
        if ($day == $day_count && $str % 7 != 0) {
            // Add empty cell(s)
            $week .= str_repeat("<td></td>", 7 - ($str % 7));
        }

        $weeks[] = "<tr>" . $week . "</tr>";

        $week = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Profile</title>
    <link rel="stylesheet" href="stylesAll.css">
    <link rel="stylesheet" href="styles_petProfile.css">
    <script src="https://kit.fontawesome.com/adab9891dd.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
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
                  echo "<form action='logOut.php' method='post'><li class='navbar__button'>
                  <button class='button' name = 'Logout' type = 'submit'><a class='button' id = 'LogOut'>Log Out</a></button>
                  </li></form>";
               ?>
            </ul>
         </div>
      </nav>
    <!--a section to display data about the pet-->
    <div class="profile-container">
        <div class="profile-details">
            <div class="pd-left">
                <div class="pd-row">
                <?php 
                ////get the pet's image using sqlite3
                $statement = $pdo->query(
                    "SELECT * FROM Pets WHERE petname = '$pet_id'"
                );
                $row = $statement->fetch();
                echo '<img src="data:image/png;base64,' . base64_encode($row['image']) . '" class="pd-image">';
                ?>
                    <div>
                        <!-- <h3>
                            name
                        </h3> -->
                        <?php echo "<h3>" . $pet_id . "</h3>"; ?>
                        <button name="edit" class="button" id="see-info">See Info</button>
                    </div>
                    <?php

$web_url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($web_url, "&") !== false) {
    $web_url = str_replace("&", "&amp;", $web_url);
}

$str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$str .= "<rss version=\"2.0\">\n";
$str .= "<channel>\n";
$str .= "<title>Important Moments for " . $pet_id . "</title>\n";
$str .= "<link> $web_url </link>\n";
$str .= "<description>Here you can see all important moments that " . $pet_id . " has had</description>\n";
$str .= "<language >en-US </language>\n";
//connect to sqlite database
$pdo = new PDO("sqlite:database.db");
//get all "text" from table Calendar where "type" is "Life Event" using a prepared statement, in chronological order
$statement = $pdo->prepare("SELECT * FROM Calendar WHERE type = 'Life Event' AND petname = :petname AND username = :owner ORDER BY year, month, day desc");
$statement->bindValue(':petname', $pet_id);
$statement->bindValue(':owner', $_SESSION['login_user']);
$statement->execute();
$rows = $statement->fetchAll();
//if web_url contains character &, replace it with &amp;

foreach ($rows as $row) {
    $str .= "<item>\n";
    //title = date
    $str .= "<title>" . $row["year"] . "-" . $row["month"] . "-" . $row["day"] . "</title>\n";
    $str .= "<description>" . $row["text"] . "</description>\n";
    //link
    $str .= "<link>" . htmlspecialchars($web_url) . "</link>\n";
    $str .= "</item>\n";
}
$str .= "</channel>\n";
$str .= "</rss>\n";
file_put_contents("rss.xml", $str);
?>
<a href = "rss.xml" target = "_blank">
    <img src="images/Feed-icon.svg.png" style="width: 25px;">
</a>

                </div>
            </div>
        </div>

        <div class="profile-info">
            <div class="info-col-left">
            </div>
            <div class="info-col-right">

            </div>
        </div>
    </div>

    <div class="calendar" >
    <div class="containerr">
        <div class="calendar-header">
        <ul class="list-inline">
            <li id="top-of-calendar"class="list-inline-item"><a href="?ym=<?= $prev ?>&value=<?= $pet_id ?>&user=<?=$_SESSION['login_user']?>#topofpage" class="btn btn-link">&lt; prev</a></li>
            <li class="list-inline-item"><span class="title"><?= $title ?></span></li>
            <li class="list-inline-item"><a href="?ym=<?= $next ?>&value=<?= $pet_id ?>&user=<?=$_SESSION['login_user']?>#topofpage" class="btn btn-link">next &gt;</a></li>
            
        </ul>
        <div class="calendar-button">
            <!-- a button that says "add event"-->
            <button href="" class="button-74" id="add-event">Add Event</button>
        </div>
        </div>
        <div style="overflow-x:auto;">
            <table>
            <thead>
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($weeks as $week) {
                    echo $week;
                } ?>
            </tbody>
            </table>
        </div>
        
    </div>
    </div>

    <div class="bg-modal">
         <div class="modal-content">
            <form method="post">
            <div class="close">+</div>
            <p class="simple-text">Add an event!</p>
            <br />
            <input id="event-desc" type="text" placeholder="Description" name="event-desc" /><br />
            <input type="date" id="event-date-id" name="event-date"
                min="0000-00-00" max="9999-12-31">
                <br />
            <!-- add a dropdoown selection with options -->
            <select name="event-type">
                <option value="Life Event">Life Event</option>
                <option value="Medical">Medical</option>
                <option value="Feeding">Feeding</option>          
                <option value="Other">Other</option>
            </select>
            <label for="event-type">Type</label>
            <br />
            <input type="submit" name="send-event">
            </form>
         </div>
      </div>
            
      <div class="Info">
         <div class="Info-content">
            <div class="close-Info">+</div>
            <!-- have two columns in the div, one column with header restrictions, other column with header medical history -->
            <div class="Info-header">
                <div class="Restrictions-header">
                    <h3>Restrictions</h3>
                    <form method = "post">
                        <input id="restri-text" type="text" style="width: 135px" placeholder="restriction" name="restri-text" />
                        <input type="submit" name="final" style="display:none;">
                    <?php
                        /*$nume_pet_curent = $_GET["value"];
                        echo ($nume_pet_curent);*/
                        $pdo = new PDO('sqlite:database.db'); 
                        if (isset($_POST['final'])){
                            //check if the restriction already exists
                            $statement = $pdo->prepare(
                                "SELECT * FROM Restrictions WHERE username = :user_name AND petname = :pet_name AND restriction = :restr"
                            );
                            $statement -> execute([
                                ":user_name" => $_GET["user"],
                                ":pet_name" => $_GET["value"],
                                ":restr" => $_POST["restri-text"]
                            ]);
                            $result = $statement->fetchAll();
                            if (count($result) > 0){
                                echo "<script>alert('Restriction already exists');</script>";
                            }else{
                                $statement = $pdo->prepare("INSERT INTO Restrictions (username, petname, restriction) VALUES (:user_name, :pet_name, :restr)");
                                $statement ->execute(array(
                                    ":user_name" => $_GET["user"],
                                    ":pet_name" => $_GET["value"],
                                    ":restr" => $_POST["restri-text"]
                                ));
                            }
                        }
                        $statement = $pdo->query("SELECT * FROM Restrictions WHERE username = '" .$_GET["user"]. "'AND petname ='" .$_GET["value"]. "'" );
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                            echo '<p>'.$row['restriction'].' </p>';
                            echo '<button type ="submit" style = "float: right; "name ="delete2[' .$row['restriction'].
                            ']">Delete</button><br / >';
                        }
                    ?>
                       
                    </form>
                </div>
                <div class="Medical-history-header">
                    <h3>Medical History</h3>
                    <?php
                        $pdo = new PDO('sqlite:database.db');
                        $statement = $pdo->query("SELECT * FROM Calendar WHERE username = '" .$_GET["user"]. "'AND petname ='" .$_GET["value"]. "' AND type = 'Medical'" );
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                            echo '<p>'.$row['text'].' </p>';
                            echo '<p>'.$row['day'].'-</p>';
                            echo '<p>'.$row['month'].'-</p>';
                            echo '<p>'.$row['year'].'</p> <br / >';
                        }
                    ?>
                </div>
            </div>
         </div>
      </div>

      <div class="LogIn-modal">
         <div class="modal-content">
            <div class="close" id = "close">+</div>
            <a id="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
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
          <a id="navbar__logo"> <i class="fa-solid fa-cat"></i>PSM </a>
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
        const menu = document.querySelector("#mobile-menu");
        const menuLinks = document.querySelector(".navbar__menu");
    
        menu.addEventListener("click", function () {
          menu.classList.toggle("is-active");
          menuLinks.classList.toggle("active");
        });
      </script>
      <script>
         document.getElementById("add-event").addEventListener("click", function () {
         document.querySelector(".bg-modal").style.display = "flex";
         });
         document.querySelector(".close").addEventListener("click", function () {
         document.querySelector(".bg-modal").style.display = "none";
         });
      </script>
      <script>
         document.getElementById("see-info").addEventListener("click", function () {
         document.querySelector(".Info").style.display = "flex";
         });
         document.querySelector(".close-Info").addEventListener("click", function () {
         document.querySelector(".Info").style.display = "none";
         });
      </script>
      
      <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
   </script>
</body>
</html>
