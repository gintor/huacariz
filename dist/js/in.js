$("#f_login").submit(function(e){
    e.preventDefault();
	var datos = $("#f_login").serializeArray();
    $.ajax({
        method: "POST",
        url: "call/login.php",
        data: datos,
        dataType: 'json',
        beforeSend: function(){
            $("#b_login").html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(e){
            $("#r_login").html(e.mensaje);
            $("#pas").val("");
            if(e.exito){
                window.location.replace("inicio/01");
            }
            $("#b_login").html('Ingresar');
        }
    });
})

$("#loc").select2();