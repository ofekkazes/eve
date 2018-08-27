<?php require_once ("Includes/session.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>My Site's Title</title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 


    </head>
    <body>
        <div class="outer-wrapper">
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title" id="eve" ><a href="/index.php">>EVE</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
                        if (logged_on() || is_admin())
                        {
                            echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                            if (is_admin())
                            {
                                echo '<li><a href="/addpage.php">Add</a></li>' . "\n";
                                echo '<li><a href="/selectpagetoedit.php">Edit</a></li>' . "\n";
                                echo '<li><a href="/deletepage.php">Delete</a></li>' . "\n";
                                echo '<li><a href="/register.php">Register</a></li>' . "\n";
                            }
                        }
                        ?>
                        </ul>
                        <?php if (logged_on()) {
                            echo "<div class=\"welcomeMessage\">Welcome, <strong>{$_SESSION['username']}</strong></div>\n";
                        } ?>
                    </section>
                </div>

                <div class="clear-fix"></div>
            </div>

                <section class="navigation" data-role="navbar">
                    <nav>
                        <ul id="menu">
                             
                            
                            <?php
                                
                                if( logged_on()) {
                                    if(is_admin()) {
                                        echo "<li><a href=\"addShift.php\">הוסף משמרת</a></li>
                                              <li><a href=\"usertable.php\">ניהול משתמשים</a></li>
                                              <li><a href=\"test.php\">ניהול משמרות</a></li>";
                                    }
                                    if(on_shift()) {
                                        echo "<li><a href=\"carForm.php\">טופס רכב</a></li>
                                              <li><a href=\"cars.php\">רכבים</a></li>
                                              <li><a href=\"addPic.php\">צילום תמונה</a></li>
                                              <li><a href=\"notifications.php\">עדכונים</a></li>";
                                    }
                                    echo "
                                          <li><a href=\"map.php\">מפה</a></li>";
                                    echo "<li style=\"float: left;\"><a href=\"logoff.php\">התנתק</a></li>\n";
                                    echo "<li style=\"float: left;\"><a href=\"#\">ברוך הבא {$_SESSION['username']}</a></li>\n";
                                    

                                }

                            ?>
                        </ul>
                    </nav>
            </section>
        </header>
            <?php
                $message = $_GET['message'];
                $rate = $_GET['rate'];
                if(isset($message)) {
                    if($rate > 0) {
                        echo "<div id='success' onclick=\"this.hidden = 'hidden'\">$message</div>";
                    }
                    elseif ($rate < 0) {
                        echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">$message</div>";
                    }
                    else {
                        echo "<div id='ok' onclick=\"this.hidden = 'hidden'\">$message</div>";
                    }
                }
            ?>
