/**
 * Created by Niesmo on 10/19/14.
 */

var base_url = "http://localhost/Tick-It";

$(document).ready(function(){
    var clock = new FlipClock($('.discount-clock'), {
        autoStart : true
    });

    if ($("#dropDownDiscountedDuration").val() == 0) {
        showDiscountedPriceDiv(false);
    }

    $("#search-query").keyup(function(){
        var query = $(this).val();
        console.log();
        var ticketBlocks = $(".ticket-title");
        console.log(ticketBlocks);

        for(var i=0;i<ticketBlocks.length;i++){
            console.log(i);
            if(ticketBlocks[i].innerHTML.toLowerCase().indexOf(query.toLowerCase()) == -1){
                $(ticketBlocks[i]).parent().parent().fadeOut("slow");
            }
            else{
                $(ticketBlocks[i]).parent().parent().fadeIn("slow");
            }
        }
    });

});


function validateForm() {
    var name = document.getElementById("txtName").value.trim();
    var description = document.getElementById("txtDescription").value.trim();
    var price = document.getElementById("txtPrice").value.trim();
    var discountedPrice = document.getElementById("txtDiscountedPrice").value.trim();

    var discountedDuration = document.getElementById("dropDownDiscountedDuration").value.trim();

    var checkEmail = document.getElementById("checkboxEmail").checked;
    var checkPhone = document.getElementById("checkboxNumber").checked;

    if (name == "") {
        alert("Please Enter Name Field");
        return;
    } else if (description == "") {
        alert("Please Enter Description Field");
        return;
    } else if (price == "" || isNaN(price)) {
        alert("Please Enter Valid Price");
        return;
    } else if (document.getElementById("dropDownDiscountedDuration").value != 0 && isNaN(discountedPrice)) {
        alert("Please Enter A Valid Discounted Price");
        return;
    }


    submitItem(name, description, price, discountedPrice, discountedDuration, checkEmail, checkPhone);


}

function submitItem(name, description, price, discountedPrice, discountedDuration, checkEmail, checkPhone) {
    $.ajax({
        url: 'submitItem.php',
        type: 'POST',
        data: {
            action: 'submitItem',
            name: name,
            description: description,
            price: price,
            discountedPrice: discountedPrice,
            discountedDuration: discountedDuration,
            checkEmail: checkEmail,
            checkPhone: checkPhone
        },
        error: function(data) {
            console.log(data);
            alert("Sorry, data not sent.")

        },
        success: function(data) {
            //console.log(data);
            if (data.status == "success") {
                window.location = base_url + "/buy.php"
            } else {
                alert("Something went wrong");
                console.log(data.query);
            }


        }
    });

}


function showDiscountedPriceDiv(bool) {
    if (bool) {
        $("#divDiscountedPrice").show();
    } else {
        $("#divDiscountedPrice").hide();
    }
}


function updateDiscountGUI() {
    if (document.getElementById("dropDownDiscountedDuration").value == 0) {
        showDiscountedPriceDiv(false);
    } else {
        showDiscountedPriceDiv(true);
    }
}