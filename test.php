    <?php 
        require_once ("Includes/session.php");
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!logged_on()) {
            header ("Location: logon.php");
        }
     ?>
    
<style>
    #vertical { width:  100%;}
#vertical tr { display: block; float: right; width:  13.5%;}
#vertical th, td { display: block; }
</style>

    <div id="main" style="text-align: center; width:  100%;">

        <?php
            $arr = array(
                    1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array(), 6 => array(), 7 => array()
            );             
            $counter = 0;
            $prevday = 0;
            date_default_timezone_set("Asia/Jerusalem");
            $date = date('Y-m-d');
            $week = date("W", strtotime($date));
            $sql = "SELECT WEEK(start_hour, 3) as weekNum,shift_id FROM shifts ";

            $result = $databaseConnection->query($sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {

                    if($row['weekNum'] == $week) {
                        $shift_id = $row['shift_id'];
                        $query = "SELECT shift_id, start_hour, finish_hour, user_id, role_id, DAYOFWEEK(start_hour) as dayNum, UNIX_TIMESTAMP( start_hour ) AS date, HOUR(start_hour) as hours FROM shifts WHERE shift_id=$shift_id ORDER BY shift_id asc";
                        $res = $databaseConnection->query($query);
                        
                        if (mysqli_num_rows($res) > 0) {
                            
                            while($row2 = mysqli_fetch_assoc($res)) {
                                if($prevday < $row2['dayNum']) {
                                    $counter = 0;
                                    $prevday = $row2['dayNum'];
                                }
                                $arr[$row2['dayNum']][$counter] = $row2['start_hour'].",".$row2['finish_hour'].",".$row2['dayNum'].",".$row2['role_id'].",".$row2['user_id'].",".$row2['shift_id'];
                                
                                //echo $row2['start_hour']."  ".$counter." ".$row2['dayNum']." <br> ";
                                $counter++;
                                
                            }
                        }
                    }
                    
                }
            }
            
            echo "
            <table style='text-align: center; width: 100%;' dir='rtl'>
            <tr><th>ראשון</th><th>שני</th><th>שלישי</th><th>רביעי</th><th>חמישי</th><th>שישי</th><th>שבת</th></tr></table>  

            <table id=\"vertical\" style='text-align: center; width: 100%;' dir='rtl'>";
            
            
            for($i = 1; $i<=7; $i++) {
                echo"<tr style='padding: 20px 0px 0px 0px;'>";
                
                $j = 0;
                while(isset($arr[$i][$j])) {
                    //if($arr[$i][$j] == 0) {echo "<td style='margin-right: 50px;'></td>";}
                    $vars = explode(",", $arr[$i][$j]);
                    echo "<td style='padding: 10px 0px 10px 0; width: 100%;'>".$vars[0]."<br />".$vars[1]."<br />".$vars[2]."</td>";
                    if($j == 4) {
                        break;
                    }
                    $j++;
                }
                echo "</tr>";
            }
            echo "
            
            </table>
            
            ";
        ?>
       
    </div>
<?php 
    include ("Includes/footer.php");
 ?>
