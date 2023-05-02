<script>

$("#submitsearch").on('submit', function(event){
  event.preventDefault();
  
  $.ajax({
    type: 'POST',
    url: 'submitsearch',
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
            $("#button").hide();
            $("#processing").show();
        },
    success: function(data){
    if(data.message == 'error'){
      $("#button").show();
      $("#processing").hide();
      
    	Swal.fire('Error!', data.info, 'error');
    }else{
      $("#button").show();
      $("#processing").hide();

    	$("#results").html(data);
    }
      
      
    }
  });
});




$("#submitcompare").on('submit', function(event){
  event.preventDefault();
  
  $.ajax({
    type: 'POST',
    url: 'submitcompare',
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
            $("#button").hide();
            $("#processing").show();
        },
    success: function(data){

    if(data.message == 'error'){
      Swal.fire('Error!', data.info, 'error');
    }else{
      
      $("#compare").html(data);
    }
      
      $("#button").show();
      $("#processing").hide();
    }
  });
});

</script>