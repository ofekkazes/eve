    <?php 
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!logged_on()) {
            header ("Location: logon.php");
        }

         if (isset($_POST['submit'])){
             $carType = $_POST['carID'];
             $shiftType = $_POST['shiftType'];
             $shiftTime = $_POST['shiftTime'];
             $fuel = $_POST['fuel'];
             $kmCount = $_POST['kmCount'];
             $comments = $_POST['comments'];
             
             if(!empty($_POST['check_list'])) {
                foreach($_POST['check_list'] as $check) {
                    $equimpent .=", ".$check;
                }
            }

             date_default_timezone_set("Asia/Jerusalem");
             $date = date('Y-m-d H:i:s');

             $query = "INSERT INTO car_reports (userid, date, patrol_type, car_type, shift_time, fuel_volume, kilometer, equipment, comments, shift_id)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('isssssdssi', $_SESSION['userid'], $date, $shiftType, $carType, $shiftTime, $fuel, $kmCount, $equimpent, $comments, $_SESSION['shiftid']);
            $statement->execute();
            $statement->store_result();

            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if(!($creationWasSuccessful)) {
                echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error: ".$statement->error."</div>";
                $_SESSION['eve'] = "Failure";
            }
            else {
                $_SESSION['eve'] = "Success";

            }
         }
     ?>
    <div id="main" style="text-align: center; width:  100%;">
        <h1>דוח רכב</h1>
        <form action="carForm.php" dir="rtl" id="carForm" method="post" onsubmit="if((obligations.checked != '')) { return true;} else { alert('אש בבקשה את הנושאים'); return false;}">
            <fieldset>
                <div>
                    <h3>סוג הרכב</h3>
                    <select name="carID">
                        <option value="טויוטה">טויוטה</option>
                        <option value="דיהטסו">דיהטסו</option>
                        <option value="אחר">אחר (שכור)</option>
                    </select>
                </div>
                <div>
                    <h3>נא לבחור משמרת הר/חווה</h3>
                    <select name="shiftType">
                        <option value="הר">הר</option>
                        <option value="חווה">חווה</option>
                    
                    </select>
                </div>
                <div>
                    <h3>נא לבחור משמרת סיור</h3>
                    <select name="shiftTime">
                        <option value="בוקר">בוקר</option>
                        <option value="צהריים">צהריים</option>
                        <option value="ערב">ערב</option>
                        <option value="לילה">לילה</option>
                    </select>
                </div>
                <div>
                    <h3>נא לציין כמות דלק</h3>
                    <select name="fuel">
                        <option value="מלא">מלא</option>
                        <option value="חצי">חצי</option>
                        <option value="רבע">רבע</option>
                        <option value="שליש">שליש</option>
                    </select>
                </div>
                <div>
                    <h3>קילומטראז'</h3>
                    <input type="text" name="kmCount" />
                </div>
                <div>
                    <h3>הערות/תקלות</h3>
                    <input type="text" name="comments" value="חובה למלא הערות שקרו במהלך המשמרת" style="color:  #808080;" onclick="this.value=''; this.style.color = '#111';" />
                </div>
                <div>
                    <h3>נא לבדוק שהציוד הנ"ל קיים ברכב</h3>
                    <input type="checkbox" value=" פנס מגה לייט" name="check_list[]" />פנס מגה לייט<br />
                    <input type="checkbox" value="ערכת עזרה ראשונה" name="check_list[]" />ערכת עזרה ראשונה<br />
                    <input type="checkbox" value="ערכת תיקון לפנצר" name="check_list[]" />ערכת תיקון פנצ'רים<br />
                    <input type="checkbox" value="אפוד זוהר" name="check_list[]" />אפוד זוהר<br />
                    <input type="checkbox" value="כבלי הנעה" name="check_list[]" />כבלי הנעה (טויוטה בלבד)<br />
                </div>
                <div>
                    <h3>נא לאשר את כל הנושאים הנ"ל</h3>
                    <span style="color:  red;">
                    בכל בעיה ממשית שלא נמצא לה פתרון בשטח ניתן ליצור קשר עם מירקו.<br />
                    א. חובה להגיע 15 דק' לפני משמרת (לטובת עדכונים) <br />
                    ב. חובה לוודאות נעילת מתחם (שערים ודלתות מבנים) וכן כיבוי אורות ומיזוג <br />
                    ג. חובה לבצע בדיקות קשר במהלך המשמרת
                    </span> 
                
                
                </div>
                <div style="font-size: x-large; color:  green;">
                    <input type="checkbox" id="obligations"/>קראתי ואישרתי
                    <br /><br />    
                </div>
                <div>
                    <input type="submit" value="שלח" id="submit" name="submit" />
                </div>
            </fieldset>
        </form>    
        
    </div>

</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    include ("Includes/footer.php");
 ?>