<script>

var x = 2;

$("#addsheet").click(function(){

	
	
	$("#sheetdata").append('<tr id="'+x+'"><td><p id="sn'+x+'">'+x+'</p></td><td><input type="text" class="form-control" id="description'+x+'" name="description[]" placeholder="Description"></td><td><input type="text" class="form-control qty" id="qty'+x+'" name="qty[]" value="0"></td><td><input type="text" class="form-control" id="price'+x+'" name="price[]" value="0.00"></td><td><p class="form-control" id="amount'+x+'">0.00</p><input type="hidden" class="form-control" id="amounts'+x+'" name="amounts[]" value="0.00"></td><td><input type="text" class="form-control" id="vatp'+x+'" name="vatp[]" value="0.00"></td><td><p class="form-control" id="vatamount'+x+'">0.00</p><input type="hidden" class="form-control" id="vata'+x+'" name="vata[]" value="0.00"></td><td><p class="form-control" id="grossamount'+x+'">0.00</p><input type="hidden" class="form-control" id="gross'+x+'" name="gross[]" value="0.00"></td><td><input type="text" class="form-control" id="whtp'+x+'" name="whtp[]" value="0.00"></td><td><p class="form-control" id="whtamount'+x+'">0.00</p><input type="hidden" class="form-control" id="whta'+x+'" name="whta[]" value="0.00"></td><td><p class="form-control" id="netamount'+x+'">0.00</p><input type="hidden" class="form-control" id="net'+x+'" name="net[]" value="0.00"></td></tr>');


	$("#counter").val(x);
	$("#countrow").val(x);


	x++;

});





$("#minussheet").click(function(){	

	y = --x;

	$("#counter").val(--y);
	$("#countrow").val(--y);
	
	$("#"+x).remove();

	if(x<2){
		x=2
	}




});



$("#sumrow").click(function(){

	var a = $("#counter").val();
    
	var qty = $("#qty"+a).val();

	var price = $("#price"+a).val();

	var amount = qty*price;

	$("#amount"+a).html(amount);

	$("#amounts"+a).val(amount);

	var vatp = $("#vatp"+a).val();

	var vatamount = vatp / 100 * amount;

	$("#vatamount"+a).html(vatamount.toFixed(2));

	$("#vata"+a).val(vatamount.toFixed(2));

	var grossamount = amount - vatamount;

	$("#grossamount"+a).html(grossamount.toFixed(2));

	$("#gross"+a).val(grossamount.toFixed(2));

	var whtp = $("#whtp"+a).val();

	var whtamount = whtp / 100 * grossamount;

	$("#whtamount"+a).html(whtamount.toFixed(2));

	$("#whta"+a).val(whtamount.toFixed(2));

	var netamount = grossamount + whtamount;

	$("#netamount"+a).html(netamount.toFixed(2));

	$("#net"+a).val(netamount.toFixed(2));

	
});



$("#editrow").click(function(){
	$("#rowid").toggle();
	
});

$("#rowid").change(function(){
		var rowid = $("#rowid").val();
        
		$("#counter").val(rowid);

	});

$("#sumall").click(function(){

	var countrow = $("#countrow").val();

	var totalprice = 0;
	var totalamount = 0;
	var totalvat = 0;
	var totalgross = 0;
	var totalwht = 0;
	var totalnet = 0;

	var price = 0;
	var amount = 0;
	var vat = 0;
	var gross = 0;
	var wht = 0;
	var net = 0;

	for(var i=1; i<=countrow; i++){

		price = $("#price"+i).val();
		amount = $("#amounts"+i).val();
		vat = $("#vata"+i).val();
		gross = $("#gross"+i).val();
		wht = $("#whta"+i).val();
		net = $("#net"+i).val();

		totalprice += parseFloat(price);
		totalamount += parseFloat(amount);
		totalvat += parseFloat(vat);
		totalgross += parseFloat(gross);
		totalwht += parseFloat(wht);
		totalnet += parseFloat(net);

	}

	$("#totalprice").html(totalprice.toFixed(2));
	$("#totalprices").val(totalprice.toFixed(2));

	$("#totalamount").html(totalamount.toFixed(2));
	$("#totalamounts").val(totalamount.toFixed(2));

	$("#totalvat").html(totalvat.toFixed(2));
	$("#totalvats").val(totalvat.toFixed(2));

	$("#totalgross").html(totalgross.toFixed(2));
	$("#totalgrosses").val(totalgross.toFixed(2));

	$("#totalwht").html(totalwht.toFixed(2));
	$("#totalwhts").val(totalwht.toFixed(2));

	$("#totalnet").html(totalnet.toFixed(2));
	$("#totalnets").val(totalnet.toFixed(2));

	
});


$("#submitpv").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitpv',
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
				    window.location = '/sentpvs';
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });

	

	$("#showattachment").click(function(){
		$("#hideattachment").toggle();
	});


	$("#submiteditpv").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submiteditpv',
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
				    window.location = '/sentpvs';
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });

	

	



	$("#submitpvstatus").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitpvstatus',
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
				    window.location = '/allpvs';
				}, 3000);
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });

	

	$("#attachbutton").click(function(){

		$("#showattachment").toggle();
	});




</script>