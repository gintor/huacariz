$(document).ready(function(){
	l_usuarios(idm);
})

function l_usuarios(id){
  $.ajax({
    type: "post",
    url: base+"callpage/se_li_usuarios.php",
    dataType: "html",
    data: {idm: id},
    beforeSend: function () {
      $("#t_usuarios").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#t_usuarios").html(e);
      $("#t_usuarios").slideDown("slow");
    }
  });
}

function se_fagregar(idmo,acc){
  $('#m_usuario').modal('show');
  $(".tm_usuario").html('<i class="fa fa-plus text-green"></i> Agregar Usuario');
    $.ajax({
    method: "POST",
    url: base+"callpage/se_f_usuario.php",
    data: {idm: idmo, acc: acc},
    dataType: 'html',
    beforeSend: function(){
      $("#f_usuario").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_usuario").hide();
    },
    success: function(d){
      $("#f_usuario").html(d);
      $("#bg_usuario").show();
    }
  });
}

function se_feditar(idmo,acc,idu){
  $('#m_usuario').modal('show');
  switch (acc){
    case "edit":
      var tit='<i class="fa fa-pencil text-green"></i> Editar Usuario';
      break;
    case "perm":
      var tit='<i class="fa fa-key text-green"></i> Permisos Usuario';
      break;
    case "cont":
      var tit='<i class="fa fa-lock text-green"></i> Cambiar Contraseña';
      break;
  }
  $(".tm_usuario").html(tit);
    $.ajax({
    method: "POST",
    url: base+"callpage/se_f_usuario.php",
    data: {idm: idmo, acc: acc, idu: idu},
    dataType: 'html',
    beforeSend: function(){
      $("#f_usuario").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_usuario").hide();
    },
    success: function(d){
      $("#f_usuario").html(d);
      if (acc!="perm") {
        $("#bg_usuario").show();
      }
    }
  });
}

$("#bg_usuario").click(function(){
  var datos = $("#f_usuario").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/se_crud.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#r_usuario").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_usuario").hide();
    },
    success: function(d){
    	if(d.e){
    		$("#f_usuario").html(d.m);
        l_usuarios(idm);
    	}else{
      	$("#r_usuario").html(d.m);
        $("#bg_usuario").show();
      }
    }
  });
});

function g_perusuario(idmo, idu, idmod, niv){
  $.ajax({
    type: "POST",
    url: base+"callpage/se_g_perusuario.php",
    dataType: "json",
    data: {idm:idmo, idu:idu, idmod:idmod, niv:niv.value},
    success: function(d){
      if(d.e){
        alertify.success(d.m);
      }else{
        alertify.error(d.m);
      }
    }
  });
}

