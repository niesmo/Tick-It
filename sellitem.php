<html>
<head>
	<!-- Latest compiled and minified CSS -->


	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<script>
function validateForm()
{
	var name=document.getElementById("txtName").value.trim();
	var description=document.getElementById("txtDescription").value.trim();
	var price=document.getElementById("txtPrice").value.trim();
	var discountedPrice=document.getElementById("txtDiscountedPrice").value.trim();

	var discountedDuration=document.getElementById("dropDownDiscountedDuration").value.trim();

	var checkEmail=document.getElementById("checkboxEmail").checked;
	var checkPhone=document.getElementById("checkboxNumber").checked;

	// alert(checkEmail+" "+checkPhone);

	


	if(name=="")
	{
		alert("Please Enter Name Field");
		return;
	}
	else if(description=="")
	{
		alert("Please Enter Description Field");
		return;
	}
	else if(price==""||isNaN(price))
	{
		alert("Please Enter Valid Price");
		return;
	}
	else if(document.getElementById("dropDownDiscountedDuration").value!=0&&isNaN(discountedPrice))
	{
		alert("Please Enter A Valid Discounted Price");
		return;
	}

	submitItem(name, description, price, discountedPrice,discountedDuration, checkEmail, checkPhone);
	

}

function submitItem(name, description, price, discountedPrice, discountedDuration, checkEmail, checkPhone)
{
	$.ajax({
   url: 'submitItem.php',
   data: {
   		action:'submitItem',
     	name:name,
     	description:description,
     	price:price,
     	discountedPrice:discountedPrice,
     	discountedDuration:discountedDuration,
     	checkEmail:checkEmail,
     	checkPhone:checkPhone
   },
   error: function() {
     	alert("Sorry, data not sent.")
   },
  
   success: function(data) {
   		alert(data);
     	
   },
   type: 'POST'
});

}





$( document ).ready(function() {
    if( $("#dropDownDiscountedDuration").val() ==0)
	{
		showDiscountedPriceDiv(false);
	}
});



function showDiscountedPriceDiv(bool)
{
	if(bool)
	{
		$("#divDiscountedPrice").show();
	}
	else
	{
		$("#divDiscountedPrice").hide();
	}
}


function updateDiscountGUI()
{
	if(document.getElementById("dropDownDiscountedDuration").value==0)
	{
		showDiscountedPriceDiv(false);
	}
	else
	{
		showDiscountedPriceDiv(true);
	}
}
</script>

<body>



	<form role="form">
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

  

<!--  <div href="javascript: showDiscountedPriceDiv(true)">
</div> -->
<!-- 
<div class="dropdown">
  <button style="width:100%" class="btn btn-default dropdown-toggle" type="button" id="dropDownDiscounted" data-toggle="dropdown">Discounted Duration<span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
  	<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >No Discounted Value</a></li>
  	
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >15 minutes</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >30 minutes</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >1 hour</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">2 hours</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >5 hours</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >10 hours</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">24 hours</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" >48 hours</a></li>




  </ul>
</div> -->
  <div id="dropDownDiv" class="form-group">
<label for="dropDownDiscountedDuration">Discount Duration:</label>
<select onchange="updateDiscountGUI();" id="dropDownDiscountedDuration" class="form-control">
	<option value="0">No Discounted Value</option>

 	<option value="15">15 minutes</option>
    <option value="30" >30 minutes</option>
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
</form>
</body>




</html>
