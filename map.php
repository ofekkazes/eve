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
        <h1>מפה</h1>
       
    </div>

</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    include ("Includes/footer.php");
 ?>