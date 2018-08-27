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
        if(TRUE) {
            echo "<a href='carForm.php'>הבא</a>";
        }
        else {
             echo "<a href='cars.php'>הבא</a>";
        }
?>
    <table border="1" dir="rtl" id="hours" style="text-align: center; width: 96%; border: 1px solid black;">
        <tr style=" max-height: 10%;">
            <td class="tableTop">ראשון</td>
            <td class="tableTop">שני</td>
            <td class="tableTop">שלישי</td>
            <td class="tableTop">רביעי</td>
            <td class="tableTop">חמישי</td>
            <td class="tableTop">שישי</td>
            <td class="tableTop">שבת</td>
        </tr>
        <?php
            $arr = array (
                "userid" => array(),
                "start_hour" => array(),
                "finish_hour" => array(),
                "roleid" => array(),
                "day" => array()
            );
            $indexi = 0;
            $counter = 0;
            $sql = "SELECT @day :=DAYOFWEEK(start_hour) FROM shifts WHERE userid=".$_SESSION['userid'].";";
            $result = $databaseConnection->query($sql);
            $sql = "SELECT userid, start_hour, @day, role_id FROM shifts WHERE userid=".$_SESSION['userid'].";";
            $result = $databaseConnection->query($sql);

            

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $arr["userid"][$counter] = $row["userid"];
                    $arr["start_hour"][$counter] = $row["start_hour"];
                    $arr["finish_hour"][$counter] = $row["finish_hour"];
                    $arr["day"][$counter] = $row["@day"];
                    $arr["roleid"][$counter] = $row["roleid"];
                    $counter++;
                }
                 echo "<tr><td>".$arr["userid"][0].$arr["start_hour"][0].$arr["day"][0]."</td></tr>";
            }
            echo "<tr>";
            for($indexi = 0; $indexi < $counter; $indexi++) {
                //echo "<td>";
            }
            echo"</tr>";
            for($i = 0; $i<5; $i++) {
                echo "<tr>";
                echo "<td class=\"tableHours\"></td>";
                for($j = 0; $j<6; $j++) {
                    echo "<td class=\"\"></td>";
                    echo "
                    ";
                }
                echo "</tr>";
            }
        ?>
        
    </table>

    </div>

</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    include ("Includes/footer.php");
 ?>