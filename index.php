    <?php 
        require_once ("Includes/session.php");
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!logged_on()) {
            header ("Location: logon.php");
        }
     ?>


    <div id="main" style="text-align: center; width:  100%;">
        <?php
            if(!is_admin()) {
                header("Location: notifications.php");
            }
            else {
                echo $_SESSION['shiftid'];
                echo "<div style='text-align: right; width: 97%; margin-right: 10%;'><h2>רכבים שנכנסו היום</h2>";

                 $sql = "SELECT time, manufacture, color, licence, target, location FROM car_ongoing WHERE DATE(time) = DATE(NOW())";
                $result = $databaseConnection->query($sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<ul dir='rtl' style='text-align: right;'>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<li style='text-align: right;'>רכב בעל מספר ".$row['licence'].", בצבע ".$row['color'].", למטרת ".$row['target']." ב".$row['location'].", בשעה ".substr($row['time'], 11, 10)."</li>";
                    }
                     echo "</ul></div>";
                }

                echo "<div style='text-align: right; width: 97%; margin-right: 10%;'><h2>תמונות שצולמו היום</h2>";

                 $sql = "SELECT date, location_on_disk FROM photos WHERE DATE(date) = DATE(NOW())";
                $result = $databaseConnection->query($sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<ul dir='rtl' style='text-align: right;'>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<li style='text-align: right;'><img style='width: 100px; height: 100px;' src='".$row['location_on_disk']."' /> בשעה ".substr($row['date'], 11, 10)."</li>";
                    }
                     echo "</ul></div>";
                }
            }
        ?>
    </div>

</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    include ("Includes/footer.php");
 ?>