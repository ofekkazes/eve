    <?php 
        require_once ("Includes/session.php");
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!logged_on()) {
            header ("Location: logon.php");
        }
        
        if(isset($_POST['submit'])) {
            
            if(!empty($_POST['check_list'])) {
                    foreach($_POST['check_list'] as $check) {
                        $query = "UPDATE notifications SET is_read = 'Y' WHERE id = ".$check;

                        $statement = $databaseConnection->query($query);

                        $updatenWasSuccessful = $statement->affected_rows == 1 ? true : false;
                        if(!($updateWasSuccessful)) {
                            echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error: ".$statement->error."</div>";
                            $_SESSION['eve'] = "Failure";
                            break;
                        }
                        //$statement->close();
                        }
                }
                    
                
        }
     ?>


    <div id="main" style="text-align: center; width:  100%;">
        <form action="notifications.php" method="post">
        
        
        
        <?php
            $sql = "SELECT message, action, is_read, id FROM notifications WHERE to_user=".$_SESSION['userid']." AND is_read = 'N'";
            $result = $databaseConnection->query($sql);

            if (mysqli_num_rows($result) > 0) {
                ?>
            <table dir='rtl' style='width: 90%;'>
            <tr style="float: right;"><th style="">סמן כנקרא</th><th style="width: 80%; text-align: center;">הודעה</th></tr>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td style='float: right;'><input name='check_list[]' value='".$row['id']."' type='checkbox' /></td>\n<td  style='float: right; width: 80%; text-align: right;'><a href='".$row['action'].".php'>".$row['message']."</a></td></tr>";
                }
                ?>
                </table>
            <input type="submit" name="submit" value="קראתי ואישרתי" />
        </form>
                <?php
            }
            else {
                ?>
                <form action="shifts.php" method="post">
            <input type="submit" name="submit" value="אין הודעות" />
        </form>
                <?php
            }
        ?>

        
        
    </div>


<?php 
    include ("Includes/footer.php");
 ?>