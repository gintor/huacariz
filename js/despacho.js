$(document).ready(function(){

  l_despachos(idm);
  l_prodes(idm);

  //select2 para busqueda de clientes
  $( "#cli" ).select2({
      placeholder: 'BUSCAR CLIENTE',   
      ajax: {
          url: base+"callpage/ge_clientes.php",
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term // search term
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      },
      minimumInputLength: 3
  });
  //select2 para busqueda de productos
  $( "#pro0" ).select2({
      placeholder: 'BUSCAR PRODUCTO',   
      ajax: {
          url: base+"callpage/ge_productos.php",
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term // search term
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      },
      minimumInputLength: 3
  });


});


function l_despachos(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/de_li_despachos.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_despachos").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_despachos").html(e);
      $("#d_despachos").slideDown("slow");
    }
  });
}

function l_prodes(idm){
  $.ajax({
    type: "post",
    url: base+"callpage/de_li_prodes.php",
    dataType: "html",
    data: {idm: idm},
    beforeSend: function () {
      $("#d_prodes").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_prodes").html(e);
    }
  });
}

function de_f_despacho(idmo,acc,idf){
  $('#modal').modal('show');
  switch (acc){
    case "edides":
      var tit='<i class="fa fa-pencil text-red"></i> Editar Despacho';
      break;
    case "elides":
      var tit='<i class="fa fa-trash text-red"></i> Eliminar Despacho';
      break;
  };
  
  $(".ti_modal").html(tit);
    $.ajax({
    method: "POST",
    url: base+"callpage/de_f_despacho.php",
    data: {idm: idmo, acc: acc, idf: idf},
    dataType: 'html',
    beforeSend: function(){
      $("#fo_modal").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      $("#fo_modal").html(d);
      if(acc!="edides"){
        $("#bg_modal").show();
      }
      if(acc=="edides"){
        l_prodesedi(idm, idf);
      }
    }
  });
};

function prodes(idm, acc, idf){
  if(acc!="eli" && acc!="des"){
    if(acc=="can"){
      var lcan=$("#lcan"+idf).val();
      var can=prompt("Ingrese la nueva cantidad",lcan);
    }else{
      var can=$("#can"+idf).val();
    }
    if(idf==0){
      var idf=$("#pro"+idf).val();
    }
      if(can!=null){
        if(idf!=null){
          $.ajax({
            method: "POST",
            url: base+"callpage/de_prodes.php",
            data: {idm: idm, acc: acc, idf: idf, can: can},
            dataType: 'json',
            success: function(d){
              if(d.e){
                alertify.success(d.m);
                l_prodes(idm);
                $("#can0").val("1");
              }else{
                alertify.warning('Error');
              }
            }
          });
        }else{
          alert("Elija un producto");
        }
      }
  }else if(acc=="eli" || acc=="des"){
    var can=0;
    $.ajax({
      method: "POST",
      url: base+"callpage/de_prodes.php",
      data: {idm: idm, acc: acc, idf: idf, can: can},
      dataType: 'json',
      success: function(d){
        if(d.e){
          alertify.success(d.m);
          l_prodes(idm);
          $("#can0").val("1");
        }else{
          alertify.warning('Error');
        }
      }
    });
  }
}

//guarda el despacho
$("#bg_despacho").click(function(){
  var datos = $("#f_despacho").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/de_g_despacho.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#r_prodes").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_despacho").hide();
    },
    success: function(d){
      if(d.e){
        $("#r_prodes").html(d.m);
        l_prodes(idm);
        l_despachos(idm);
        $("#cli").html("");
        $("#pro0").html("");
        $("#d_descprodes").html("");
      }else{
        $("#r_prodes").html(d.m);
      }
      $("#bg_despacho").show();
    }
  });
});

//confirma la eliminación de un despacho
$("#bg_modal").click(function(){
  var datos = $("#fo_modal").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/de_g_despacho.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
    },
    success: function(d){
      if(d.e){
        $("#fo_modal").html(d.m);
        //l_prodes(idm);
        l_despachos(idm);
        $("#bg_modal").hide();
      }else{
        $("#d_resultado").html(d.m);
        $("#bg_modal").show();
      }
    }
  });
});

function l_prodesedi(idm, idv){
  $.ajax({
    type: "post",
    url: base+"callpage/de_li_prodesedi.php",
    dataType: "html",
    data: {idm: idm, idv: idv},
    beforeSend: function () {
      $("#de_despro").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#de_despro").html(e);
    }
  });
}

function prodesediadd(idm, idv){
  var prod=$("#prod").val();
  var cant=$("#cant").val();
  $.ajax({
    method: "POST",
    url: base+"callpage/de_g_prodesediadd.php",
    data: {idm: idm, idv: idv, prod: prod, cant: cant},
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#b_prodesedi").hide();
    },
    success: function(d){
      if(d.e){
        $("#d_resultado").html(d.m);
        l_prodesedi(idm, idv);
      }else{
        $("#d_resultado").html(d.m);
      }
      $("#b_prodesedi").show();
      $("#cant").val("1");
    }
  });
}

function prodesedican(idm, idv, iddv){
  var lcan=$("#cant"+iddv).val();
  var can=prompt("Ingrese la nueva cantidad",lcan);
  if(can!=null){
    $.ajax({
      method: "POST",
      url: base+"callpage/de_g_prodesedican.php",
      data: {idm: idm, iddv: iddv, cant: can},
      dataType: 'json',
      beforeSend: function(){
        $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      },
      success: function(d){
        if(d.e){
          $("#d_resultado").html(d.m);
          l_prodesedi(idm, idv);
        }else{
          $("#d_resultado").html(d.m);
        }
      }
    });
  }
}

function prodesedieli(idm, idv, iddv){
  $.ajax({
    method: "POST",
    url: base+"callpage/de_g_prodesedieli.php",
    data: {idm: idm, iddv: iddv},
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success: function(d){
      if(d.e){
        $("#d_resultado").html(d.m);
        l_prodesedi(idm, idv);
      }else{
        $("#d_resultado").html(d.m);
      }
    }
  });
}

function prodesedicli(idm, idv, cli){
  $.ajax({
    method: "POST",
    url: base+"callpage/de_g_prodesedicli.php",
    data: {idm: idm, idv: idv, cli: cli},
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success: function(d){
      if(d.e){
        $("#d_resultado").html(d.m);
        l_despachos(idm);
        l_prodesedi(idm, idv);
      }else{
        $("#d_resultado").html(d.m);
      }
    }
  });
}

//funciones mantenimiento
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

function descli(cli){
    $.ajax({
    method: "POST",
    url: base+"callpage/de_mdescuento.php",
    data: {idm: idm, cli: cli},
    dataType: 'json',
    beforeSend: function(){
      $("#d_descprodes").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success: function(d){

        $("#d_descprodes").html(d.m);

    }
  });
}