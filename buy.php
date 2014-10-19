<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/18/14
 * Time: 7:26 PM
 */

require_once "config/config.php";
//get all the tickets
$tickets = $MTicket->get_all_tickets();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Current Ticket List</h2>
            <div class="row">
            <?php
            foreach($tickets as $ticket){
                echo "<div class='col-md-4'>";
                    echo "<div class='ticket-details'>";
                        echo "<h3>{$ticket->get_title()}</h3>";
                        echo "<p>\${$ticket->get_price()}</p>";
                        if($ticket->is_email_sharable()){
                            echo "<p>{$ticket->get_created_by_user()->get_email()}</p>";
                        }
                        if($ticket->is_phone_number_sharable()){
                            echo "<p>{$ticket->get_created_by_user()->get_phone_number()}</p>";
                        }
                        //TODO put an if to check if the discount is still valid
                        //echo "<div class='discount-clock'></div>";
                    echo "</div>";
                    echo "<div>";
                        echo  "<button class='btn btn-info'>Buy it</button>";
                    echo "</div>";
                echo "</div>";
            }
            ?>
            </div>
        </div>
    </div>
</div>


<?php
require_once "inc/footer.php";

?>