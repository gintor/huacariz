$(document).ready(function(){
	l_usuarios(idm);
});

function l_usuarios(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/ac_li_usuarios.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_usuarios").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_usuarios").html(e);
    }
  });
}

//llamar fomulario a modal
function ac_f_accesos(idmo,acc,idf){
  $('#modal').modal('show');
  switch (acc){
    case "addusu":
      var tit='<i class="fa fa-plus text-red"></i> Agregar usuario';
      break;
    case "conusu":
      var tit='<i class="fa fa-unlock-alt text-red"></i> Cambiar contraseña';
      break;
    case "estusu":
      var tit='<i class="fa fa-toggle-on text-red"></i> Cambiar estado';
      break;
    case "accusu":
      var tit='<i class="fa fa-key text-red"></i> Accesos usuario';
      break;
  };
  
  $(".ti_modal").html(tit);
    $.ajax({
    method: "POST",
    url: base+"callpage/ac_f_accesos.php",
    data: {idm: idmo, acc: acc, idf: idf},
    dataType: 'html',
    beforeSend: function(){
      $("#fo_modal").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      $("#fo_modal").html(d);
      if(acc!="accusu"){
        $("#bg_modal").show();
      }
    }
  });
};

$("#bg_modal").click(function(){
  var datos = $("#fo_modal").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/ac_g_accesos.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      if(d.e){
        $("#fo_modal").html(d.m);
        l_usuarios(idm);
      }else{
        $("#d_resultado").html(d.m);
        $("#bg_modal").show();
      }
    }
  });
});

function g_accusuario(idmo, idu, idmod, niv){
  $.ajax({
    type: "POST",
    url: base+"callpage/ac_g_accusuario.php",
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