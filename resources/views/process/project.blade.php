<script>

//Adding project into the system

	$("#submitproject").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitproject',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/addtask?pj='+data.pjid;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });




	//Adding a task to an existing project

	$("#submittask").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submittask',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/projectdetails?pj='+data.pjid;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


	$("#submittaskupdate").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submittaskupdate',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    location.reload();
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


	$("#submitedittask").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitedittask',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/taskdetails?tk='+data.tk;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


	$(".deletetask").on('click', function(event){
	      event.preventDefault();
	      
	      var id = $(this).attr("id");

	      Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this task? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deletetask?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/projectdetails?pj='+data.pjid;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
		  }
		});

	    });


	$("#submiteditproject").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submiteditproject',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/projectdetails?pj='+data.pj;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


	$(".deleteproject").on('click', function(event){
	      event.preventDefault();
	      
	      var id = $(this).attr("id");

	      Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this project? This project and all the tasks associated to it will be deleted and the action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteproject?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/projects';
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
		  }
		});

	    });


	$("#startdate").on('change', function(){

		var startdate = $("#startdate").val();

		$("#enddate").removeAttr("readonly");
		$("#enddate").val("");
		$("#enddate").attr("min", startdate);
	});


	$("#showattachment").click(function(){
		$("#hideattachment").toggle();
	});



/******************** Invoice Sheet 1 ***************************/

	var invoicetype = $("#invoicetype").val();

	if(invoicetype == "Sheet 1"){

		var u = $("#countrow1").val();

		if(u == 1){
			var x = 2;
		}else{
			var x = parseInt(u)+1;
		}

		$("#addsheet1").click(function(){
			
			
			$("#sheetdata1").append('<tr class="'+x+'"><td><p id="sn1'+x+'">'+x+'</p></td><td><input type="text" class="form-control" id="description1'+x+'" name="description1[]" placeholder="Description"></td><td><input type="text" class="form-control qty" id="qty1'+x+'" name="qty1[]" value="0"></td><td><input type="text" class="form-control" id="price1'+x+'" name="price1[]" value="0.00"></td><td><p class="form-control" id="amount1'+x+'">0.00</p><input type="hidden" class="form-control" id="amounts1'+x+'" name="amounts1[]" value="0.00"></td></tr>');


			$("#counter1").val(x);
			$("#countrow1").val(x);


			x++;

		});


		$("#minussheet1").click(function(){	

			y = --x;

			$("#counter1").val(--y);
			$("#countrow1").val(--y);
			
			$("."+x).remove();

			if(x<2){
				x=2
			}




		});



		$("#sumrow1").click(function(){

			var a = $("#counter1").val();
		    
			var qty = $("#qty1"+a).val();

			var price = $("#price1"+a).val();

			var amount = qty*price;

			$("#amount1"+a).html(amount);

			$("#amounts1"+a).val(amount);
			
		});



		$("#editrow1").click(function(){
			$("#rowid1").toggle();
			
		});

		$("#rowid1").change(function(){
				var rowid = $("#rowid1").val();
		        
				$("#counter1").val(rowid);

			});

		$("#sumall1").click(function(){

			var countrow = $("#countrow1").val();

			var totalprice = 0;
			var totalamount = 0;
			

			var price = 0;
			var amount = 0;
			

			for(var i=1; i<=countrow; i++){

				price = $("#price1"+i).val();
				amount = $("#amounts1"+i).val();
				

				totalprice += parseFloat(price);
				totalamount += parseFloat(amount);
				

			}



			$("#totalprice1").html(totalprice.toFixed(2));
			$("#totalprices1").val(totalprice.toFixed(2));

			$("#totalamount1").html(totalamount.toFixed(2));
			$("#totalamounts1").val(totalamount.toFixed(2));

			var vat = $("#vat1").val();
			var vatamount = parseFloat(vat)/100 * totalamount;
			$("#vatamount1").html(vatamount.toFixed(2));
			$("#vatamounts1").val(vatamount.toFixed(2));


			var wht = $("#wht1").val();
			var whtamount = parseFloat(wht)/100 * totalamount;
			$("#whtamount1").html(whtamount.toFixed(2));
			$("#whtamounts1").val(whtamount.toFixed(2));


			var sumamount = totalamount + vatamount + whtamount;
			$("#sumamount1").html(sumamount.toFixed(2));
			$("#sumamounts1").val(sumamount.toFixed(2));
			
		});

/******************** Invoice Sheet 1 Ends Here *************************/

		}else if(invoicetype == "Sheet 2"){

/******************** Invoice Sheet 2 ***************************/

var u = $("#countrow2").val();

if(u == 1){
	var x = 2;
}else{
	var x = parseInt(u)+1;
}

//var x = 2;

$("#addsheet2").click(function(){
	$("#sheetdata2").append('<tr class="'+x+'"><td><p id="sn2">'+x+'</p></td><td><input type="text" class="form-control" id="description2'+x+'" name="description2[]" placeholder="Description" ></td><td><input type="text" class="form-control" id="period2'+x+'" name="period2[]" placeholder="Period" ></td><td><input type="text" class="form-control prc" id="price2'+x+'" name="rate2[]" value="0.00" ></td><td><input type="text" class="form-control qty" id="qty2'+x+'" name="hours2[]" value="0"></td><td><p class="form-control amt" id="amount2'+x+'">0.00</p><input type="hidden" class="form-control" id="amounts2'+x+'" name="amounts2[]" value="0.00"></td></tr>');


	$("#counter2").val(x);
	$("#countrow2").val(x);


	x++;

});


$("#minussheet2").click(function(){	

	y = --x;

	$("#counter2").val(--y);
	$("#countrow2").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}

});



$("#sumrow2").click(function(){ 

	var a = $("#counter2").val(); 
    
	var qty = $("#qty2"+a).val();

	var price = $("#price2"+a).val();

	var amount = qty*price;

	$("#amount2"+a).html(amount);

	$("#amounts2"+a).val(amount);
	
});



$("#editrow2").click(function(){
	$("#rowid2").toggle();
	
});

$("#rowid2").change(function(){
		var rowid = $("#rowid2").val();
        
		$("#counter2").val(rowid);

	});

$("#sumall2").click(function(){

	var countrow = $("#countrow2").val();

	var totalprice = 0;
	var totalamount = 0;
	

	var price = 0;
	var amount = 0;
	

	for(var i=1; i<=countrow; i++){

		price = $("#price2"+i).val();
		amount = $("#amounts2"+i).val();
		

		totalprice += parseFloat(price);
		totalamount += parseFloat(amount);
		

	}



	$("#totalprice2").html(totalprice.toFixed(2));
	$("#totalprices2").val(totalprice.toFixed(2));

	$("#totalamount2").html(totalamount.toFixed(2));
	$("#totalamounts2").val(totalamount.toFixed(2));

	var vat = $("#vat2").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount2").html(vatamount.toFixed(2));
	$("#vatamounts2").val(vatamount.toFixed(2));


	var wht = $("#wht2").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount2").html(whtamount.toFixed(2));
	$("#whtamounts2").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount2").html(sumamount.toFixed(2));
	$("#sumamounts2").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 2 Ends Here *********************/

	}else if(invoicetype == "Sheet 3"){

/******************** Invoice Sheet 3 ***************************/

var u = $("#countrow3").val();

if(u == 1){
	var x = 2;
}else{
	var x = parseInt(u)+1;
}

$("#addsheet3").click(function(){
	$("#sheetdata3").append('<tr class="'+x+'"><td><p id="sn3">'+x+'</p></td><td><input type="text" class="form-control" id="name'+x+'" name="name3[]" placeholder="Name" ></td><td><input type="text" class="form-control" id="designation'+x+'" name="designation3[]" placeholder="Designation" ></td><td><input type="text" class="form-control" id="location'+x+'" name="location3[]" placeholder="Location" ></td><td><input type="text" class="form-control" id="amounts3'+x+'" name="amounts3[]" value="0.00"></td></tr>');


	$("#counter3").val(x);
	$("#countrow3").val(x);


	x++;

});


$("#minussheet3").click(function(){	

	y = --x;

	$("#counter3").val(--y);
	$("#countrow3").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow3").click(function(){

	var a = $("#counter3").val();
    
	var qty = $("#qty3"+a).val();

	var price = $("#price3"+a).val();

	var amount = qty*price;

	$("#amount3"+a).html(amount);

	$("#amounts3"+a).val(amount);
	
});



$("#editrow3").click(function(){
	$("#rowid3").toggle();
	
});

$("#rowid3").change(function(){
		var rowid = $("#rowid3").val();
        
		$("#counter3").val(rowid);

	});

$("#sumall3").click(function(){

	var countrow = $("#countrow3").val();

	//var totalprice = 0;
	var totalamount = 0;
	

	//var price = 0;
	var amount = 0;

	for(var i=1; i<=countrow; i++){

		//price = $("#price3"+i).val();
		amount = $("#amounts3"+i).val();

		//totalprice += parseFloat(price);
		totalamount += parseFloat(amount);

	}





	//$("#totalprice3").html(totalprice.toFixed(2));
	//$("#totalprices3").val(totalprice.toFixed(2));

	$("#totalamount3").html(totalamount.toFixed(2));
	$("#totalamounts3").val(totalamount.toFixed(2));

	var vat = $("#vat3").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount3").html(vatamount.toFixed(2));
	$("#vatamounts3").val(vatamount.toFixed(2));


	var wht = $("#wht3").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount3").html(whtamount.toFixed(2));
	$("#whtamounts3").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount3").html(sumamount.toFixed(2));
	$("#sumamounts3").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 3 Ends Here *********************/

	}else if(invoicetype == "Sheet 4"){

/******************** Invoice Sheet 4 ***************************/

var u = $("#countrow4").val();

if(u == 1){
	var x = 2;
}else{
	var x = parseInt(u)+1;
}

$("#addsheet4").click(function(){
	$("#sheetdata4").append('<tr class="'+x+'"><td><p id="sn4">'+x+'</p></td><td><input type="text" class="form-control" id="description4'+x+'" name="description4[]" placeholder="Description"></td><td><input type="date" class="form-control" id="date4'+x+'" name="date4[]" placeholder="Date"></td><td></td><td><input type="text" class="form-control" id="amounts4'+x+'" name="amounts4[]" value="0.00"></td></tr>');


	$("#counter4").val(x);
	$("#countrow4").val(x);


	x++;

});


$("#minussheet4").click(function(){	

	y = --x;

	$("#counter4").val(--y);
	$("#countrow4").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow4").click(function(){

	var a = $("#counter4").val();
    
	var qty = $("#qty4"+a).val();

	var price = $("#price4"+a).val();

	var amount = qty*price;

	$("#amount4"+a).html(amount);

	$("#amounts4"+a).val(amount);
	
});



$("#editrow4").click(function(){
	$("#rowid4").toggle();
	
});

$("#rowid4").change(function(){
		var rowid = $("#rowid4").val();
        
		$("#counter4").val(rowid);

	});

$("#sumall4").click(function(){

	var countrow = $("#countrow4").val();

	//var totalprice = 0;
	var totalamount = 0;
	

	//var price = 0;
	var amount = 0;

	for(var i=1; i<=countrow; i++){

		//price = $("#price3"+i).val();
		amount = $("#amounts4"+i).val();

		//totalprice += parseFloat(price);
		totalamount += parseFloat(amount);
		
	}





	//$("#totalprice3").html(totalprice.toFixed(2));
	//$("#totalprices3").val(totalprice.toFixed(2));

	$("#totalamount4").html(totalamount.toFixed(2));
	$("#totalamounts4").val(totalamount.toFixed(2));

	var vat = $("#vat4").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount4").html(vatamount.toFixed(2));
	$("#vatamounts4").val(vatamount.toFixed(2));


	var wht = $("#wht4").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount4").html(whtamount.toFixed(2));
	$("#whtamounts4").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount4").html(sumamount.toFixed(2));
	$("#sumamounts4").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 4 Ends Here *********************/

	}




/******************** Invoice Sheet 1 ***************************/

$("#invoicetype").change(function(){

	var invoicetype = $("#invoicetype").val();

	if(invoicetype == "Sheet 1"){

		var x = 2;

		$("#addsheet1").click(function(){
			
			
			$("#sheetdata1").append('<tr class="'+x+'"><td><p id="sn1'+x+'">'+x+'</p></td><td><input type="text" class="form-control" id="description1'+x+'" name="description1[]" placeholder="Description"></td><td><input type="text" class="form-control qty" id="qty1'+x+'" name="qty1[]" value="0"></td><td><input type="text" class="form-control" id="price1'+x+'" name="price1[]" value="0.00"></td><td><p class="form-control" id="amount1'+x+'">0.00</p><input type="hidden" class="form-control" id="amounts1'+x+'" name="amounts1[]" value="0.00"></td></tr>');


			$("#counter1").val(x);
			$("#countrow1").val(x);


			x++;

		});


		$("#minussheet1").click(function(){	

			y = --x;

			$("#counter1").val(--y);
			$("#countrow1").val(--y);
			
			$("."+x).remove();

			if(x<2){
				x=2
			}




		});



		$("#sumrow1").click(function(){

			var a = $("#counter1").val();
		    
			var qty = $("#qty1"+a).val();

			var price = $("#price1"+a).val();

			var amount = qty*price;

			$("#amount1"+a).html(amount);

			$("#amounts1"+a).val(amount);
			
		});



		$("#editrow1").click(function(){
			$("#rowid1").toggle();
			
		});

		$("#rowid1").change(function(){
				var rowid = $("#rowid1").val();
		        
				$("#counter1").val(rowid);

			});

		$("#sumall1").click(function(){

			var countrow = $("#countrow1").val();

			var totalprice = 0;
			var totalamount = 0;
			

			var price = 0;
			var amount = 0;
			

			for(var i=1; i<=countrow; i++){

				price = $("#price1"+i).val();
				amount = $("#amounts1"+i).val();
				

				totalprice += parseFloat(price);
				totalamount += parseFloat(amount);
				

			}



			$("#totalprice1").html(totalprice.toFixed(2));
			$("#totalprices1").val(totalprice.toFixed(2));

			$("#totalamount1").html(totalamount.toFixed(2));
			$("#totalamounts1").val(totalamount.toFixed(2));

			var vat = $("#vat1").val();
			var vatamount = parseFloat(vat)/100 * totalamount;
			$("#vatamount1").html(vatamount.toFixed(2));
			$("#vatamounts1").val(vatamount.toFixed(2));


			var wht = $("#wht1").val();
			var whtamount = parseFloat(wht)/100 * totalamount;
			$("#whtamount1").html(whtamount.toFixed(2));
			$("#whtamounts1").val(whtamount.toFixed(2));


			var sumamount = totalamount + vatamount + whtamount;
			$("#sumamount1").html(sumamount.toFixed(2));
			$("#sumamounts1").val(sumamount.toFixed(2));
			
		});

/******************** Invoice Sheet 1 Ends Here *************************/

		}else if(invoicetype == "Sheet 2"){

/******************** Invoice Sheet 2 ***************************/

var x = 2;

$("#addsheet2").click(function(){
	$("#sheetdata2").append('<tr class="'+x+'"><td><p id="sn2">'+x+'</p></td><td><input type="text" class="form-control" id="description2'+x+'" name="description2[]" placeholder="Description" ></td><td><input type="text" class="form-control" id="period2'+x+'" name="period2[]" placeholder="Period" ></td><td><input type="text" class="form-control prc" id="price2'+x+'" name="rate2[]" value="0.00" ></td><td><input type="text" class="form-control qty" id="qty2'+x+'" name="hours2[]" value="0" ></td><td><p class="form-control amt" id="amount2'+x+'">0.00</p><input type="hidden" class="form-control" id="amounts2'+x+'" name="amounts2[]" value="0.00"></td></tr>');


	$("#counter2").val(x);
	$("#countrow2").val(x);


	x++;

});


$("#minussheet2").click(function(){	

	y = --x;

	$("#counter2").val(--y);
	$("#countrow2").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow2").click(function(){

	var a = $("#counter2").val();
    
	var qty = $("#qty2"+a).val();

	var price = $("#price2"+a).val();

	var amount = qty*price;

	$("#amount2"+a).html(amount);

	$("#amounts2"+a).val(amount);
	
});



$("#editrow2").click(function(){
	$("#rowid2").toggle();
	
});

$("#rowid2").change(function(){
		var rowid = $("#rowid2").val();
        
		$("#counter2").val(rowid);

	});

$("#sumall2").click(function(){

	var countrow = $("#countrow2").val();

	var totalprice = 0;
	var totalamount = 0;
	

	var price = 0;
	var amount = 0;
	

	for(var i=1; i<=countrow; i++){

		price = $("#price2"+i).val();
		amount = $("#amounts2"+i).val();
		

		totalprice += parseFloat(price);
		totalamount += parseFloat(amount);
		

	}



	$("#totalprice2").html(totalprice.toFixed(2));
	$("#totalprices2").val(totalprice.toFixed(2));

	$("#totalamount2").html(totalamount.toFixed(2));
	$("#totalamounts2").val(totalamount.toFixed(2));

	var vat = $("#vat2").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount2").html(vatamount.toFixed(2));
	$("#vatamounts2").val(vatamount.toFixed(2));


	var wht = $("#wht2").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount2").html(whtamount.toFixed(2));
	$("#whtamounts2").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount2").html(sumamount.toFixed(2));
	$("#sumamounts2").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 2 Ends Here *********************/

	}else if(invoicetype == "Sheet 3"){

/******************** Invoice Sheet 3 ***************************/

var x = 2;

$("#addsheet3").click(function(){
	$("#sheetdata3").append('<tr class="'+x+'"><td><p id="sn3">'+x+'</p></td><td><input type="text" class="form-control" id="name'+x+'" name="name3[]" placeholder="Name" ></td><td><input type="text" class="form-control" id="designation'+x+'" name="designation3[]" placeholder="Designation" ></td><td><input type="text" class="form-control" id="location'+x+'" name="location3[]" placeholder="Location" ></td><td><input type="text" class="form-control" id="amounts3'+x+'" name="amounts3[]" value="0.00"></td></tr>');


	$("#counter3").val(x);
	$("#countrow3").val(x);


	x++;

});


$("#minussheet3").click(function(){	

	y = --x;

	$("#counter3").val(--y);
	$("#countrow3").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow3").click(function(){

	var a = $("#counter3").val();
    
	var qty = $("#qty3"+a).val();

	var price = $("#price3"+a).val();

	var amount = qty*price;

	$("#amount3"+a).html(amount);

	$("#amounts3"+a).val(amount);
	
});



$("#editrow3").click(function(){
	$("#rowid3").toggle();
	
});

$("#rowid3").change(function(){
		var rowid = $("#rowid3").val();
        
		$("#counter3").val(rowid);

	});

$("#sumall3").click(function(){

	var countrow = $("#countrow3").val();

	//var totalprice = 0;
	var totalamount = 0;
	

	//var price = 0;
	var amount = 0;

	for(var i=1; i<=countrow; i++){

		//price = $("#price3"+i).val();
		amount = $("#amounts3"+i).val();

		//totalprice += parseFloat(price);
		totalamount += parseFloat(amount);

	}





	//$("#totalprice3").html(totalprice.toFixed(2));
	//$("#totalprices3").val(totalprice.toFixed(2));

	$("#totalamount3").html(totalamount.toFixed(2));
	$("#totalamounts3").val(totalamount.toFixed(2));

	var vat = $("#vat3").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount3").html(vatamount.toFixed(2));
	$("#vatamounts3").val(vatamount.toFixed(2));


	var wht = $("#wht3").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount3").html(whtamount.toFixed(2));
	$("#whtamounts3").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount3").html(sumamount.toFixed(2));
	$("#sumamounts3").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 3 Ends Here *********************/

	}else if(invoicetype == "Sheet 4"){

/******************** Invoice Sheet 4 ***************************/

var x = 2;

$("#addsheet4").click(function(){
	$("#sheetdata4").append('<tr class="'+x+'"><td><p id="sn4">'+x+'</p></td><td><input type="text" class="form-control" id="description4'+x+'" name="description4[]" placeholder="Description"></td><td><input type="date" class="form-control" id="date4'+x+'" name="date4[]" placeholder="Date"></td><td><input type="text" class="form-control" id="amounts4'+x+'" name="amounts4[]" value="0.00"></td></tr>');


	$("#counter4").val(x);
	$("#countrow4").val(x);


	x++;

});


$("#minussheet4").click(function(){	

	y = --x;

	$("#counter4").val(--y);
	$("#countrow4").val(--y);
	
	$("."+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow4").click(function(){

	var a = $("#counter4").val();
    
	var qty = $("#qty4"+a).val();

	var price = $("#price4"+a).val();

	var amount = qty*price;

	$("#amount4"+a).html(amount);

	$("#amounts4"+a).val(amount);
	
});



$("#editrow4").click(function(){
	$("#rowid4").toggle();
	
});

$("#rowid4").change(function(){
		var rowid = $("#rowid4").val();
        
		$("#counter4").val(rowid);

	});

$("#sumall4").click(function(){

	var countrow = $("#countrow4").val();

	//var totalprice = 0;
	var totalamount = 0;
	

	//var price = 0;
	var amount = 0;

	for(var i=1; i<=countrow; i++){

		//price = $("#price3"+i).val();
		amount = $("#amounts4"+i).val();

		//totalprice += parseFloat(price);
		totalamount += parseFloat(amount);
		
	}





	//$("#totalprice3").html(totalprice.toFixed(2));
	//$("#totalprices3").val(totalprice.toFixed(2));

	$("#totalamount4").html(totalamount.toFixed(2));
	$("#totalamounts4").val(totalamount.toFixed(2));

	var vat = $("#vat4").val();
	var vatamount = parseFloat(vat)/100 * totalamount;
	$("#vatamount4").html(vatamount.toFixed(2));
	$("#vatamounts4").val(vatamount.toFixed(2));


	var wht = $("#wht4").val();
	var whtamount = parseFloat(wht)/100 * totalamount;
	$("#whtamount4").html(whtamount.toFixed(2));
	$("#whtamounts4").val(whtamount.toFixed(2));


	var sumamount = totalamount + vatamount + whtamount;
	$("#sumamount4").html(sumamount.toFixed(2));
	$("#sumamounts4").val(sumamount.toFixed(2));
	
});


/******************* Invoice Sheet 4 Ends Here *********************/

	}

});



$("#project").change(function(){

	var id = $("#project").val();
	
	$.ajax({
	        type: 'GET',
	        url: 'getclientinfo?id='+id,
	        success: function(data){
	        	$("#clientdata").val(data.clientdata);
	        }
	    });
});





$("#submitinvoice").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitinvoice',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/invoicedetails?id='+data.iv;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });



$("#submitinvoicestatus").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitinvoicestatus',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
	        		if(data.status == "Paid"){
				    	window.location = '/receiptdetails?id='+data.iv;
					}else{
						window.location = '/invoicedetails?id='+data.iv;
					}
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


$("#submiteditinvoice").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submiteditinvoice',
	        data: new FormData(this),
	        contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Success!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/invoicedetails?id='+data.iv;
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


var currency = $("#currency").val();
$(".currency").html("("+currency+")");


$("#invoicetype").change(function(){
	var invoicetype = $("#invoicetype").val();

	if(invoicetype == "Sheet 1"){
		$("#invoicesheet1").show();
		$("#invoicesheet2").hide();
		$("#invoicesheet3").hide();
		$("#invoicesheet4").hide();
	}else if(invoicetype == "Sheet 2"){
		$("#invoicesheet2").show();
		$("#invoicesheet1").hide();
		$("#invoicesheet3").hide();
		$("#invoicesheet4").hide();
	}else if(invoicetype == "Sheet 3"){
		$("#invoicesheet3").show();
		$("#invoicesheet1").hide();
		$("#invoicesheet2").hide();
		$("#invoicesheet4").hide();
	}else if(invoicetype == "Sheet 4"){
		$("#invoicesheet4").show();
		$("#invoicesheet1").hide();
		$("#invoicesheet2").hide();
		$("#invoicesheet3").hide();
	}else{
		$("#invoicesheet1").hide();
		$("#invoicesheet2").hide();
		$("#invoicesheet3").hide();
		$("#invoicesheet4").hide();
	}
	
});


$("#currency").change(function(){
	var currency = $("#currency").val();

	$(".currency").html("("+currency+")");
});


$(".deleteinvoice").click(function(event){
	event.preventDefault();

	var id = $(this).attr("id");

	Swal.fire({
		  title: 'Are you sure?',
		  text: 'Are you sure you want to delete this invoice? This action can not be reversed!',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteinvoice?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
	        	setTimeout(function() {
				    window.location = '/allinvoices';
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
		  }
		});


});



</script>