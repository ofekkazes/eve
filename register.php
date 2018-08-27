<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if(!is_admin()) {
        header ("Location: index.php");
    }

    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "INSERT INTO users (username, password) VALUES (?, SHA(?))";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();
        $statement->store_result();

        $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
        if ($creationWasSuccessful)
        {
            $userId = $statement->insert_id;

            $addToUserRoleQuery = "INSERT INTO users_in_roles (user_id, role_id) VALUES (?, ?)";
            $addUserToUserRoleStatement = $databaseConnection->prepare($addToUserRoleQuery);

            // TODO: Extract magic number for the 'user' role ID.
            $userRoleId = 2;
            $addUserToUserRoleStatement->bind_param('dd', $userId, $userRoleId);
            $addUserToUserRoleStatement->execute();
            $addUserToUserRoleStatement->close();

            //$_SESSION['userid'] = $userId;
            //$_SESSION['username'] = $username;
            $_SESSION['eve'] = "Success";
            header ("Location: index.php");
        }
        else
        {
            echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Failed Registration: ".$statement->error."</div>";
            $_SESSION['eve'] = "Failure";
        }
    }
?>
<div id="main" style="text-align: center; width:  100%;">
    <h2>רישום עובד</h2>
        <input type="button" value="מורכב" onclick="expert.hidden = ''; basic.hidden = 'hidden'; expert.username.focus();" />
        <input type="button" value="בסיסי" onclick="basic.hidden = ''; expert.hidden = 'hidden'; basic.username.focus();" />
        <form id="basic" action="register.php" method="post">
            <fieldset>
                <legend>רישום עובד</legend>
                <ol>
                    <li>
                        <label for="username">שם עובד</label> 
                        <input type="text" name="username" value="" id="username" style="text-align: right;" />
                    </li>
                    <li>
                        <label for="password">סיסמא</label>
                        <input type="password" name="password" value="" id="password" style="text-align: right;" />
                    </li>
                </ol>
                <input type="submit" name="submit" value="שלח" />
            </fieldset>
        </form>
        <form id="expert" action="register.php" method="post" hidden="hidden">
            <fieldset>
                <legend>רישום עובד</legend>
                <ol>
                    <li>
                        <label for="username">שם עובד</label> 
                        <input type="text" name="username" value="" id="username" style="text-align: right;" />
                    </li>
                    <li>
                        <label for="password">סיסמא</label>
                        <input type="password" name="password" value="" id="password" style="text-align: right;"  />
                    </li>
                    <li>
                        <label for="phone">טלפון</label>
                        <input type="text" name="phone" value="" id="phone" style="text-align: right;" />
                    </li>
                    <li>
                        <label for="fullname">כתובת</label>
                        <input type="text" name="adress" value="" id="adress" style="text-align: right;" />
                    </li>
                </ol>
                <input type="submit" name="submit" value="שלח" />
            </fieldset>
        </form>
     </div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php
    include ("Includes/footer.php");
?>