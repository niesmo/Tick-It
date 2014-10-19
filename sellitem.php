<?php require_once "config/config.php";?>

<div class="container">
    <div class="row">
        <div class="form-group">
            <label for="exampleInputEmail1">Ticket Name:</label>
            <input type="text" class="form-control" id="txtName" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Ticket Description:</label>
            <input type="text" class="form-control" id="txtDescription" placeholder="Description">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Price ($):</label>
            <input type="text" class="form-control" id="txtPrice" placeholder="Price">
        </div>
        <div id="dropDownDiv" class="form-group">
            <label for="dropDownDiscountedDuration">Discount Duration:</label>
            <select onchange="updateDiscountGUI();" id="dropDownDiscountedDuration" class="form-control">
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
        <div id="divDiscountedPrice" class="form-group">
            <label for="exampleInputPassword1">Discount Price</label>
            <input type="text" class="form-control" id="txtDiscountedPrice" placeholder="Discounted Price">
        </div>
        <div class="checkbox">
            <label>
                <input id="checkboxEmail" type="checkbox"> Share Email
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input id="checkboxNumber" type="checkbox"> Share Phone Number
            </label>
        </div>
        <button style="width: 100%;" onclick="validateForm()" class="btn btn-default">Submit</button>
    </div>
</div>
<?
require_once "inc/footer.php";
?>