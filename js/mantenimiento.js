$(document).ready(function(){
	l_productos(idm);
	l_locales(idm);
	l_entidades(idm);
});

function l_productos(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/ma_li_productos.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_productos").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_productos").html(e);
      $("#d_productos").slideDown("slow");
    }
  });
}
function l_locales(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/ma_li_locales.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_locales").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_locales").html(e);
      $("#d_locales").slideDown("slow");
    }
  });
}
function l_entidades(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/ma_li_entidades.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_entidades").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_entidades").html(e);
      $("#d_entidades").slideDown("slow");
    }
  });
}

//llamar modal y formulario
function ma_f_mante(idmo,acc,idf){
  $('#modal').modal('show');
  switch (acc){
    case "addpro":
      var tit='<i class="fa fa-plus text-red"></i> Agregar producto';
      break;
    case "infopro":
      var tit='<i class="fa fa-info-circle text-red"></i> Info producto';
      break;
    case "estpro":
      var tit='<i class="fa fa-toggle-on text-red"></i> Cambiar estado';
      break;
    case "edipro":
      var tit='<i class="fa fa-pencil text-red"></i> Editar producto';
      break;
    case "addloc":
      var tit='<i class="fa fa-plus text-red"></i> Agregar local';
      break;
    case "estloc":
      var tit='<i class="fa fa-toggle-on text-red"></i> Cambiar estado';
      break;
    case "ediloc":
      var tit='<i class="fa fa-pencil text-red"></i> Editar local';
      break;
    case "addent":
      var tit='<i class="fa fa-plus text-red"></i> Agregar entidad';
      break;
    case "infoent":
      var tit='<i class="fa fa-info-circle text-red"></i> Info entidad';
      break;
    case "estent":
      var tit='<i class="fa fa-toggle-on text-red"></i> Cambiar estado';
      break;
    case "edient":
      var tit='<i class="fa fa-pencil text-red"></i> Editar entidad';
      break;
  };
  
  $(".ti_modal").html(tit);
    $.ajax({
    method: "POST",
    url: base+"callpage/ma_f_mante.php",
    data: {idm: idmo, acc: acc, idf: idf},
    dataType: 'html',
    beforeSend: function(){
      $("#fo_modal").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      $("#fo_modal").html(d);
      if(acc.substr(0,4)!="info"){
        $("#bg_modal").show();
      }
    }
  });
};

$("#bg_modal").click(function(){
  var datos = $("#fo_modal").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/ma_g_mante.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      if(d.e){
        $("#fo_modal").html(d.m);
        l_productos(idm);
        l_locales(idm);
        l_entidades(idm);
      }else{
        $("#d_resultado").html(d.m);
        $("#bg_modal").show();
      }
    }
  });
});
//fin guardar formulario modal