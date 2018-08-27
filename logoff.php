<?php
        require_once ("Includes/session.php");
        require_once ("Includes/simplecms-config.php"); 
        require_once ("Includes/connectDB.php");
        
        if(is_admin()) {
            kill_log();
        }
        if(logged_on()) {
            $query = "UPDATE shifts SET actual_time_left = NOW() WHERE shift_id = ?";
                    
            $statement2 = $databaseConnection->prepare($query);
            $statement2->bind_param('i', $_SESSION['shiftid']);
            $statement2->execute();
            $statement2->store_result();

            $leftShift = $statement2->affected_rows == 1 ? true : false;

            if($leftShift) {
                kill_log();
            }
       }
       else { header("Location: logon.php");}
        function kill_log()
        {
            session_start();
		    $_SESSION = array();
		    if(isset($_COOKIE[session_name()])) {
			    setcookie(session_name(), '', time()-300, '/');
		    }
		    session_destroy();

            header ("Location: index.php?message=יצאת ממשמרת&rate=1");
        }
		
?>