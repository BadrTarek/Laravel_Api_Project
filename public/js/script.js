$(document).ready(function(){
	$(".driverName").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
	            $.each(data, function(index,item) {
	               $(".search-results-list .list-group").append('<a href="/_admin/editDriver/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['name']+'</a>');
	               i++;
	            });
            }
          },

        });
    });
    $(".driverName").blur(function(){
    	var form = $(this).parent().parent();
    	setTimeout( function(){ 
		    form.find(".search-results-list .list-group").empty();
		},200);
    });

    $(".userName").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/viewUser/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['name']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".userName").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });


    $(".orderCode").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/orderDetails/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['code']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".orderCode").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });


    $(".contactType").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/editContactType/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['name_en']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".contactType").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });


    $(".phone").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/editPhone/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['phone']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".phone").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    $(".email").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/editEmail/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['email']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".email").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    $(".contactCode").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/viewContact/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['code']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".contactCode").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });


    $(".discountCode").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/viewCode/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['code']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".discountCode").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    $(".requestCode").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/viewBillPayRequest/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['code']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".requestCode").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    $(".adminName").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/editAdmin/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['name']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".adminName").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    $(".truckType").keyup(function(){
        var form = $(this).parent().parent();
        var input = $(this).val();
        $.ajax({
          type:"POST",
          dataType:'json',
          url:form.attr("action"),
          data:form.serialize(),
          success: function(data){
            $(".search-results-list .list-group").empty();
            var i = 0;
            if(data!==null)
            {
              $.each(data, function(index,item) {
                 $(".search-results-list .list-group").append('<a href="/_admin/editTruckType/'+item["id"]+'" class="list-group-item list-group-item-action" >'+item['name_en']+'</a>');
                 i++;
              });
            }
          },
        });
    });
    $(".searchInput").blur(function(){
      var form = $(this).parent().parent();
      setTimeout( function(){ 
        form.find(".search-results-list .list-group").empty();
    },200);
    });

    
    $("#randomCode").click(function(e){
      e.preventDefault();
      var number = Math.floor(Math.random() * 90000) + 10000;
      $("#CodeInput").val(number);
      $("#CodeInput").focus();
    });

    $("#show-password").click(function(e){
      e.preventDefault();
      var input = $(this).parent().find("input");
      var button = $(this);

        if(input.attr("type")=="text"){
          input.attr("type","password");
          button.empty();
          button.append('<i class="fas fa-eye-slash"></i>');
        }else{
          input.attr("type","text");        
          button.empty();
          button.append('<i class="fas fa-eye"></i>');
        }
        input.focus();
      
    });
});


function previewImage(input){

	var path = $(this).parent().parent().find("img");

    var file = $(".edit-image input[type=file]").get(0).files[0];
    
    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            //$(".edit-image img").attr("src", reader.result);

            //path.attr("src", reader.result);

        }

        reader.readAsDataURL(file);
    }
}






