    <?php 
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!is_admin()) {
            header ("Location: logon.php");
        }
        if (isset($_POST['submit'])){
            $workerID = $_POST['workerID'];
            $start_min = $_POST['startMin'];
            $start_hour = $_POST['startHour'];
            $finish_min = $_POST['finishMin'];
            $finish_hour = $_POST['finishHour'];
            $shiftType = $_POST['shiftType'];
            $dateTime = $_POST['date'];


            date_default_timezone_set("Asia/Jerusalem");
            $date = date("Y-m-d");
            echo $date."<br />";
            $startDate = date("Y-m-d H:i:s", mktime($start_hour, $start_min, 0, substr($dateTime, 3, 2) , substr($dateTime, 0, 2), substr($dateTime, 7, 4)));
            echo $startDate."<br />";
            $endDate = date("Y-m-d H:i:s", mktime($finish_hour, $finish_min, 0, substr($dateTime, 3, 2) , substr($dateTime, 0, 2), substr($dateTime, 7, 4)));
            echo $endDate;

            $query = "INSERT INTO shifts (user_id,role_id, start_hour, finish_hour) VALUES (?, ?, ?, ?);";

            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('iiss', $workerID, $shiftType, $startDate, $endDate);
            $statement->execute();
            $statement->store_result();
            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if(!($creationWasSuccessful)) {
                echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error: ".$statement->error."</div>";
                $_SESSION['eve'] = "Failure";
            }
            else {$_SESSION['eve'] = "Success"; echo "<div id='success' onclick=\"this.hidden = 'hidden'\">Success</div>";header("Location: index.php?message=dadad");}
        }
     ?>
    <div id="main" style="text-align: center; width:  100%;">
        <h1>הוסף משמרת</h1>
        <form action="addShift.php" dir="rtl" id="Shifts" method="post">
            <fieldset>
            
                <div>
                    <h3>עובד</h3>
                    <select name="workerID">
                        <?php
                            $query2 = "SELECT id, username FROM users;";
                            $result = $databaseConnection->query($query2);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='".$row['id']."'>".$row['username']."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <h3>שעת התחלה</h3>
                    <input type="text" name="startHour" value="שעה" style="color: #808080; width:  30px; text-align: center;" maxlength="2" onclick="this.value=''; this.style.color = '#111';" /> : <input type="text" name="startMin" value="דקה" maxlength="2" style="color: #808080; width:  30px; text-align: center;" onclick="this.value=''; this.style.color = '#111';" />
                </div>
                <div>
                    <h3>שעת סיום</h3>
                    <input type="text" name="finishHour" value="שעה" style="color: #808080; width:  30px; text-align: center;" maxlength="2" onclick="this.value=''; this.style.color = '#111';" /> : <input type="text" name="finishMin" value="דקה" maxlength="2" style="color: #808080; width:  30px; text-align: center;" onclick="this.value=''; this.style.color = '#111';" />
                </div>
                <div>
                    <h3>תאריך</h3>
                    <input type="text" name="date" value="שעה" style="color: #808080; width:  60px; text-align: center;" onclick="this.value=''; this.style.color = '#111';" />
                </div>
                <div>
                    <h3>תפקיד</h3>
                    <select name="shiftType">
                        <option value="0">בוטקה הר</option>
                        <option value="1">בוטקה חווה</option>
                        <option value="2">סיור הר</option>
                        <option value="3">סיור חווה</option>
                    </select>
                </div>
                <div>
                    <h3>תמונות</h3><?php ////////?>
                    <input type="file" accept="image/*" capture="camera" name="img" />
                </div>
                <div>
                    <h3>הערות</h3>
                    <input type="text" name="comments" />
                </div>
                <div>
                    <input type="submit" value="שלח" name="submit" />
                </div>
            </fieldset>
        </form>    
    </div>

</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    include ("Includes/footer.php");
 ?>