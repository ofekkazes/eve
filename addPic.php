    <?php 
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         

        
        function resize($width, $height, $name, $category)
        {
          $lpath = 'photos/'.$category.'/'.$name[0].'.JPG';
          /* new file name */

          date_default_timezone_set("Asia/Jerusalem");
          $date = date('Y-m-d H:i:s');

          $path = 'photos/'.$category.'/'.$date.'.JPG';
          

          $image = @imagecreatefromjpeg($lpath);
          $w = imagesx($image);
          $h = imagesy($image);
          $tmp = imagecreatetruecolor($width, $height);
          imagecopyresampled($tmp, $image, 0, 0, 0, 0, $width, $height, $w, $h);
          /* Save image */

          imagejpeg($tmp, $path, 100);
          /* cleanup memory */
          imagedestroy($image);
          imagedestroy($tmp);
        }

        if(!logged_on()) {
            header ("Location: logon.php");
        }

        if (isset($_POST['submit'])){

             $comment = $_POST['comments'];
             $location = $_POST['location'];
             date_default_timezone_set("Asia/Jerusalem");
             $date = date('Y-m-d H:i:s');
             
             $target_path = 'photos/shifts_photos/'.$_FILES['img']['name']; 
             $result = move_uploaded_file($_FILES['img']['tmp_name'], $target_path);
             $name = explode(".jpg", $_FILES['img']['name']);
             resize(400, 400, $name,"shifts_photos");
             if($result)
             {
                 //echo"99FM";
                 $query = "INSERT INTO photos (userid, shift_id, location_on_disk, location, comment, date)
                       VALUES (?, ?, ?, ?, ?, ?);";
                $statement = $databaseConnection->prepare($query);
                $statement->bind_param('iissss', $_SESSION['userid'], $_SESSION['shiftid'], $target_path, $location, $comment, $date);
                $statement->execute();
                $statement->store_result();
                $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
                if(!($creationWasSuccessful)) {
                    echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error: ".$statement->error."</div>";
                    $_SESSION['eve'] = "Failure";
                }
                else {$_SESSION['eve'] = "Success"; echo "<div id='success' onclick=\"this.hidden = 'hidden'\">Success</div>";}
             }
             else {
                 echo "<div id='errors' onclick=\"this.hidden = 'hidden'\">Error Uploading Photo</div>";
                 $_SESSION['eve'] = "Failure";
             }
         }
     ?>
    <div id="main" style="text-align: center; width:  100%;">
        <h1>הוסף צילום</h1>
        <form action="addPic.php" dir="rtl" id="Photos" method="post"  enctype='multipart/form-data'>
            <fieldset>
                <div>
                    <h3>העלאת תמונה</h3>
                    <input type="file" accept="image/*" capture="camera" name="img" />
                </div>
                <div>
                    <h3>מיקום</h3>
                    <input type="text" name="location" />
                </div>
                <div>
                    <h3>הערות</h3>
                    <input type="text" name="comments" />
                </div>
                <br />
                <div>
                    <input type="submit" value="שלח" name="submit" />
                </div>
            </fieldset>
        </form>    
    </div>

<?php 
    include ("Includes/footer.php");
 ?>