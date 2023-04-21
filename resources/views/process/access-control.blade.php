<script>
	

	$("#submiaction").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submiaction',
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



	$("#submitprocess").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitprocess',
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


	$("#submitrole").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitrole',
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


	$("#checkall").click(function(){
	  	if($(this).prop("checked") == true){
                $('input[type="checkbox"]').prop("checked", true);
            }else{
            	$('input[type="checkbox"]').prop("checked", false);
            }
	  });



	$("#submitprivileges").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitprivileges',
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
	        	/*setTimeout(function() {
				    location.reload();
				}, 3000);*/
	        }else{
	        	Swal.fire("Error!", data.info, "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });


	$(".editrole").click(function(event){
		event.preventDefault();
		var role = $(this).attr("id");
		var id = $(this).attr("href");
		$("#role").val(role);
		$("#roid").val(id);
	});


	$(".deleterole").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this role? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleterole?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
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
		  }
		})

	});


	$(".editaction").click(function(event){
		event.preventDefault();
		var action = $(this).attr("id");
		var id = $(this).attr("href");
		$("#action").val(action);
		$("#actid").val(id);
	});


	$(".deleteaction").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this action? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteaction?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
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
		  }
		})

	});


	$(".editprocess").click(function(event){
		event.preventDefault();
		var process = $(this).attr("id");
		var id = $(this).attr("href");
		$("#process").val(process);
		$("#proid").val(id);
	});


	$(".deleteprocess").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this process? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteprocess?id='+id,
	        beforeSend:function(){
	                $("#button").hide();
	                $("#processing").show();
	            },
	        success: function(data){

	        if(data.message == 'success'){
	        	Swal.fire('Deleted!', data.info, 'success');
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
		  }
		})

	});


</script>