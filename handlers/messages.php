<?php
include ('../config.php');


    switch ( $_REQUEST['action'] ) {
        case "sendMessage":

            session_start();

            $query = $db->prepare("INSERT INTO messages SET user=?, message=?");

            $run = $query->execute([$_SESSION['username'], $_REQUEST['message']]);

            if($run){
                echo 1;
                exit;
            }

            break;

             case "getMessages":

                 $query = $db->prepare("SELECT * FROM messages");
                 $run = $query->execute();

                 $rs = $query->fetchAll(PDO::FETCH_OBJ);

                 $chat = '';
                 foreach ($rs as $message) {
                     if($message->user === 'Daniel Carvalho'){
                         $chat .= '<div class="container message">
                                <strong>'.$message->user.': </strong> '.$message->message.'
                                <span class="time-right">'.date('h:i a', strtotime($message->date)).'</span>
                                </div>';
                     }else{
                         $chat .= '<div class="container darker message">
                                    <div style="float: right;">
                                <strong >'.$message->user.': </strong> '.$message->message.'
                                <span style="position:absolute; left: 0; padding-left: 20px;" class="time-left">'.date('h:i a', strtotime($message->date)).'</span>
                                </div>
                                </div>';
                     }

                 }
                 echo $chat;

            break;
    }

?>