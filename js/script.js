/**
 * Created by Niesmo on 10/19/14.
 */

var base_url = "http://localhost/Tick-It";

function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function Timer(element){
    this.el = element;
    this.hour = 0;
    this.min = 0;
    this.sec = 0;
    this.time = new Date();
    this.timeInterval = undefined;
    this.isOver = false;

}

Timer.prototype.update = function(){
    this.sec--;
    if(this.sec <= 0){
        if(this.min == 0 && this.hour == 0){
            this.isOver = true;
            return;
        }
        this.min--;
        this.sec = 59;
    }
    if(this.min <= 0){
        if(this.hour == 0 && this.sec == 0){
            this.isOver = true;
            return;
        }
        this.hour --;
        this.min = 59;
    }

    this.time.setHours(this.hour);
    this.time.setMinutes(this.min);
    this.time.setSeconds(this.sec);
};

Timer.prototype.start = function(){
    var diffArr = $(this.el).data("diff").split(":");

    this.hour = diffArr[0];
    this.min = diffArr[1];
    this.sec = diffArr[2];

    this.time.setHours(this.hour);
    this.time.setMinutes(this.min);
    this.time.setSeconds(this.sec);

    var currTimer = this;

    this.timeInterval = setInterval(function(){
        $(currTimer.el).text(pad(currTimer.hour,2) + ":" + pad(currTimer.min,2) + ":" + pad(currTimer.sec,2) );
        currTimer.update();
        if(currTimer.isOver){
            clearInterval(currTimer.timeInterval);
        }
    },1000);
};


function updateDiscountById(ticket_id, data){
    $.ajax({
        url:base_url + "/ticketAjax.php",
        data: {
            id: ticket_id,
            newPrice: data.newDiscountPrice,
            duration : data.newDuration
        },
        method:"POST",
        success:function(data){
            console.log(data);
        }
    });
}


$(document).ready(function(){
    var discountClocks = $(".discount-clock");
    for(var i=0;i<discountClocks.length;i++){
        var temp = new Timer(discountClocks[i]);
        temp.start();
    }

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

    $("#new-discount-submit").click(function(){
        var ticket_id = $(this).data("ref");
        var data = {
            newDuration : $("#new-discount-end-time").val(),
            newDiscountPrice : $("#new-discount-price").val()
        };

        updateDiscountById(ticket_id, data)
    })

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