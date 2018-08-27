    <?php 
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        if(!logged_on()) {
            header ("Location: logon.php");
        }

         if (isset($_POST['submit'])){
             $carType = $_POST['carID'];
             $color = $_POST['color'];
             $location = $_POST['location'];
             $target = $_POST['target'];
             $plate = $_POST['plate1'].$_POST['plate2'].$_POST['plate3'];
             
             date_default_timezone_set("Asia/Jerusalem");
             $date = date('Y-m-d H:i:s');

             $query = "INSERT INTO car_ongoing (manufacture, color, licence, target, location, time, userid)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";

            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ssssssi', $carType, $color, $plate, $target, $location, $date, $_SESSION['userid']);
            $statement->execute();
            $statement->store_result();

            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if(!($creationWasSuccessful)) {
                echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error: ".$statement->error."</div>";
                $_SESSION['eve'] = "Failure";
            }
            else {$_SESSION['eve'] = "Success";}
         }
     ?>
    <div id="main" style="text-align: center; width:  100%;">
        <h1>כניסת רכבים</h1>
        <?php if(is_admin()) {?><input type="button" value="עריכה" onclick="editform.hidden = ''; addcar.hidden = 'hidden'; editform.carID.focus();" /><?php }?>
        <input type="button" value="הוספה" onclick="addcar.hidden = ''; editform.hidden = 'hidden';" />
        <form id="addcar" action="cars.php" dir="rtl" id="cars" method="post">
            <fieldset>
                <div>
                    ID
                    <br />
                    <?php
                        $stmnt = $databaseConnection->query("SELECT COUNT(*) AS counter FROM car_ongoing");
                        if (mysqli_num_rows($stmnt) == 1) {
                            while($row = mysqli_fetch_assoc($stmnt)) {
                                $counter = 0;
                                $counter  = $row['counter'];
                                $counter++;
                                if(($counter < 10)) {
                                    $counter = "0".$counter;
                                }
                                echo "<input type=\"text\" name=\"carGivenID\" disabled=\"disabled\" value='".$counter."' style=\"width: 45px; text-align: center;\" />";
                            }
                        }
                    ?>
                </div>
                <div>
                    <h3>מספר רכב</h3>
                    <input type="text" name="plate3" maxlength="2" style="width:  20px; text-align: center;" />-
                    <input type="text" name="plate2" maxlength="3" style="width:  25px; text-align: center;" oninput="if(this.value > 99) { plate3.focus(); }" />-
                    <input type="text" name="plate1" maxlength="2" style="width:  20px; text-align: center;" oninput="if(this.value > 9) { plate2.focus(); }" />
                </div>
                <div>
                    <h3>סוג הרכב</h3>
                    <select name="carID" style="visibility:visible;width: 100px;">
    <option value="0">משאית</option>
    <option value="1">אאודי</option>
    <option value="292">אברת'</option>
    <option value="5">אופל</option
    ><option value="6">אינפיניטי</option>
    <option value="9">אלפא-רומאו</option>
    <option value="258">אם. ג'י. / MG</option>
    <option value="300">אסטון מרטין</option>
    <option value="10">ב מ וו</option>
    <option value="11">ביואיק</option>
    <option value="282">גרייט וול</option>
    <option value="301">דאצ'יה</option>
    <option value="16">דודג'</option>
    <option value="17">דייהו</option>
    <option value="18">דייהטסו</option>
    <option value="22">הונדה</option>
    <option value="24">וולוו</option>
    <option value="26">טויוטה</option>
    <option value="28">יגואר</option>
    <option value="29">יונדאי</option>
    <option value="33">לנציה</option>
    <option value="34">לקסוס</option>
    <option value="35">מאזדה</option>
    <option value="286">מזראטי</option>
    <option value="36">מיני</option>
    <option value="37">מיצובישי</option>
    <option value="38">מרצדס</option>
    <option value="39">ניסאן</option>
    <option value="40">סאאב</option>
    <option value="42">סובארו</option>
    <option value="43">סוזוקי</option>
    <option value="44">סיאט</option>
    <option value="45">סיטרואן</option>
    <option value="46">סמארט</option>
    <option value="48">סקודה</option>
    <option value="49">פולקסווגן</option>
    <option value="50">פונטיאק</option>
    <option value="51">פורד</option>
    <option value="52">פורשה</option>
    <option value="54">פיאט</option>
    <option value="55">פיג'ו</option>
    <option value="56">פרארי</option>
    <option value="57">קאדילק</option>
    <option value="58">קיה</option>
    <option value="59">קרייזלר</option>
    <option value="60">רובר</option>
    <option value="61">רנו</option>
    <option value="62">שברולט</option>
    </select>
                </div>
                <div>
                    <h3>צבע הרכב</h3>
                    <select name="color">
                        <option value="לבן">לבן</option>
                        <option value="שחור">שחור</option>
                        <option value="כחול">כחול</option>
                        <option value="כסף">כסף</option>
                        <option value="אחר">אחר</option>
                    </select>
                </div>
                <div>
                    <h3>מטרת ביקור</h3>
                    <select name="target">
                        <option value="פארק">פארק</option>
                        <option value="קקל">קק"ל</option>
                        <option value="פיתוח">פיתוח</option>
                        <option value="אחר">אחר</option>
                    </select>
                </div>

                <div><?php //KILL?>
                    <h3>מיקום</h3>
                    <select name="location">
                        <option value="פארק">פארק</option>
                        <option value="חווה">חווה</option>
                    </select>
                </div>

                <div>
                    <br />
                    <input type="submit" value="שלח" name="submit" />
                </div>
            </fieldset>
            </form>
            <br /><br /><br />
            <form id="editform" action="editcar.php" dir="rtl" id="editcar" method="post" hidden="hidden">
                <fieldset>
                    <h2>הכנס מספר סידורי לעריכה</h2>
                    <input type="text" id="carID" style="width: 45px; text-align: center;" />
                    <input type="submit" value="ערוך" name="edit" />
                </fieldset>
        </form>
    </div>

<?php 
    include ("Includes/footer.php");
 ?>