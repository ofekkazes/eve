<?php 
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include ("Includes/header.php");

    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT id, username FROM users WHERE username = ? AND password = SHA(?) LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows == 1)
        {
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
            $statement->fetch();
            $statement->close();
            $_SESSION['eve'] = "Success";

            if(is_admin()) {
                header ("Location: index.php?message=נכנסת למערכת כמנהל&rate=1");
            }
            
            $query = "SELECT shift_id FROM shifts WHERE user_id = ? AND DATE(NOW()) BETWEEN DATE(start_hour) and DATE(finish_hour) AND TIME(NOW()) BETWEEN TIME(start_hour) and TIME(finish_hour);";
            $statement1 = $databaseConnection->prepare($query);
            $statement1->bind_param('i', $_SESSION['userid']);
            
            $statement1->execute();
            $statement1->store_result();
            if ($statement1->num_rows == 1)
            {
                $statement1->bind_result($shiftID);
                $statement1->fetch();
                $statement1->close();
                
                if($shiftID>-1 && isset($shiftID) && $shiftID != NULL) {
                    $query = "UPDATE shifts SET actual_time_entered = NOW() WHERE shift_id = ?";
                    
                    $statement2 = $databaseConnection->prepare($query);
                    $statement2->bind_param('i', $shiftID);
                    $statement2->execute();
                    $statement2->store_result();

                    $enterToShift = $statement2->affected_rows == 1 ? true : false;

                    if($enterToShift) {
                        
                        $_SESSION['shiftid'] = $shiftID;
                        header ("Location: index.php?message=נכנסת למשמרת בהצלחה&rate=1");
                    }
                }

            }
            else {
                echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">אין לך משמרת</div>";
            }
           // header ("Location: index.php");
        }
        else
        {
            echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">שם משתמש או סיסמא לא נכונים</div>";
            $_SESSION['eve'] = "Failure";
        }
        
    }
?>
<script type="text/javascript">
    function checkForm(that) {

        var username = that.username.value;
        var password = that.password.value;
        //var node = document.getElementById('node-id');
        //node.innerHTML("<div id='errors' onclick=\"this.hidden = 'hidden'\">שם משתמש ריק</div>");

        var node = document.getElementById('node-id');
        var newNode = document.createElement('div');
        newNode.id = "errors";
        newNode.addEventListener('click', function () { newNode.hidden = "hidden"; }, false);

        if (username.length == 0) {
            newNode.appendChild(document.createTextNode('שם משתמש ריק'));
            node.appendChild(newNode);
            return false;
        }
        if (password.length == 0) {
            newNode.appendChild(document.createTextNode('הסיסמא ריקה'));
            node.appendChild(newNode);
            return false;
        }

        return true;
    }

</script>
<div id="node-id"></div>
<div id="main">
    <h2 style="text-align: center;">כניסה למערכת</h2>
        <form action="logon.php" method="post" style="text-align: center;" onsubmit="return checkForm(this)">
            <fieldset>
            <ol>
                <li>
                    <label for="username">שם משתמש</label> 
                    <input type="text" name="username" id="username" />
                </li>
                <li>
                    <label for="password">סיסמא</label>
                    <input type="password" name="password" id="password" />
                </li>
            </ol>
            <input type="submit" name="submit" value="שלח" />
        </fieldset>
    </form>
</div>

<?php include ("Includes/footer.php"); ?>