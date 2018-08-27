<?php
require_once ("Includes/simplecms-config.php");
require_once  ("Includes/connectDB.php");
include("Includes/header.php");
confirm_is_admin();
if($_GET['action'] == 'viewAll' || !isset($_GET['action'])) {
echo "<center><table dir='rtl' style='width: 80%; text-align: center;'>";
echo "<tr><th>ID</th><th>שם עובד</th><th>טלפון</th><th>כתובת</th><th>פעולה</th></tr>";

$query = "SELECT id, username, phone, adress FROM users ORDER BY id ASC";
$res = $databaseConnection->query($query);
                        
if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['phone']."</td><td>".$row['adress']."</td><td><a href='?action=viewOne&userid=".$row['id']."'>הגדל</a><a href='?action=editOne&userid=".$row['id']."'>ערוך</a>";
        echo "</tr>";
    }
}

echo "</table></center>";
}
elseif ($_GET['action'] == 'viewOne') {
    echo $_GET['userid'];
}
?>