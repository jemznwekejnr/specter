<script>

	//Adding departments into the system

	$("#submitdepartment").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitdepartment',
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





	//Adding designation into the system

	$("#submitdesignation").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitdesignation',
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
	        	Swal.fire('Success!', 'Designation successfully created!', 'success');
	        	setTimeout(function() {
				    location.reload();
				}, 3000);
	        }else{
	        	Swal.fire("Error!", "Error creating designation, is possible the designation already exist. Please try again!", "error");
	        }
	          
              $("#button").show();
              $("#processing").hide();
	        }
	      });
	    });



	//Adding offices into the system

	$("#submitoffices").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitoffices',
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



	//Adding bank into the system

	$("#submitbank").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitbank',
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


	$(".editdepartment").click(function(event){
		event.preventDefault();
		var department = $(this).attr("id");
		var id = $(this).attr("href");
		$("#departments").val(department);
		$("#deptid").val(id);
	});


	$(".deletedepartment").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this department? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deletedepartment?id='+id,
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



	$(".editdesignation").click(function(event){
		event.preventDefault();
		var designation = $(this).attr("id");
		var id = $(this).attr("href");
		$("#designations").val(designation);
		$("#desid").val(id);
	});


	$(".deletedesignation").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this designation? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deletedesignation?id='+id,
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




	$(".editoffice").click(function(event){
		event.preventDefault();
		var office = $(this).attr("id");
		var id = $(this).attr("href");
		$("#offices").val(office);
		$("#ofid").val(id);
	});


	$(".deleteoffice").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure you want to delete this branch? This action can not be reversed!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteoffice?id='+id,
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




	$(".editbank").click(function(event){
		event.preventDefault();
		var bank = $(this).attr("id");
		var id = $(this).attr("href");
		$("#banks").val(bank);
		$("#bkid").val(id);
	});


	$(".deletebank").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: 'Are you sure you want to delete this bank? This action can not be reversed!',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deletebank?id='+id,
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


	//Adding bank into the system

	$("#submitinfo").on('submit', function(event){
	      event.preventDefault();
	      
	      $.ajax({
	        type: 'POST',
	        url: 'submitinfo',
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


	$(".deleteinfo").click(function(event){

		event.preventDefault();
		
		var id = $(this).attr("href");

		Swal.fire({
		  title: 'Are you sure?',
		  text: 'Are you sure you want to delete this info? This action can not be reversed!',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {

		  	$.ajax({
	        type: 'GET',
	        url: 'deleteinfo?id='+id,
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