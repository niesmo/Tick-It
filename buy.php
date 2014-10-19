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
                        echo "<h3 class='ticket-title'>{$ticket->get_title()}</h3>";
                        echo "<p class='description'>".$ticket->get_description(true)."</p>";

                        if($ticket->is_discounted()){
                            echo "<p class='price crossed-off'>\${$ticket->get_price()}</p>";
                            echo "<p class='discounted-price'>\${$ticket->get_discounted_price()} ({$ticket->get_discount_percentage()} % Off)</p>";
                        }
                        else{
                            echo "<p class='price'>\${$ticket->get_price()}</p>";
                        }

                        if($ticket->is_email_sharable()){
                            echo "<p>{$ticket->get_created_by_user()->get_email()}</p>";
                        }
                        if($ticket->is_phone_number_sharable()){
                            echo "<p>{$ticket->get_created_by_user()->get_phone_number()}</p>";
                        }
                    echo "</div>";
                    echo "<div class='ticket-buy-btn'>";
                        if($ticket->is_discounted()){
                            echo "<p class='discount-clock' data-diff='{$ticket->get_discount_time_left()}'>{$ticket->get_discount_time_left()}</p>";
                        }
                        echo  "<button class='btn btn-info sm-right-margin'>Buy it</button>";
                        if(isset($_SESSION['user_id'])){
                            if($ticket->get_created_by_id() == $_SESSION['user_id'] /*&& !$ticket->is_discounted()*/){
                                echo "<button class='btn btn-success' data-toggle='modal' data-target='#set-promotion'>Promotion</button>";
                                ?>
                                <!-- Modal -->
                                <div class="modal fade" id="set-promotion" tabindex="-1" role="dialog" aria-labelledby="Set new promotion" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Set a discount</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <p>THIS FORM DOES NOT REALLY WORK! SORRY</p>
                                                    <label for="new-discount-end-time">For how long?</label>
                                                    <select class="form-control" id="new-discount-end-time">
                                                        <option value="0">No Discounted Value</option>
                                                        <option value="15">15 minutes</option>
                                                        <option value="30">30 minutes</option>
                                                        <option value="60">1 hour</option>
                                                        <option value="120">2 hours</option>
                                                        <option value="300">5 hours</option>
                                                        <option value="600">10 hours</option>
                                                        <option value="1440">24 hours</option>
                                                        <option value="2880">48 hours</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-discount-price">New Discounted Price</label>
                                                    <input type="text" id="new-discount-price" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="new-discount-submit" data-ref="<?php echo $ticket->get_id(); ?>" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?
                            }
                        }
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