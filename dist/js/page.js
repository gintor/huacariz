$(document).ready(function(){
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  $(".select2").select2();
  $('[data-toggle="tooltip"]').tooltip();
})

$("#bm_ccontrasenia").click(function(){
  $.ajax({
    url: base+"call/f_ccontrasenia.php",
    dataType: 'html',
    beforeSend: function(){
      $("#f_ccontrasenia").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i> Cargando</h4>');
      $("#b_ccontrasenia").hide();
    },
    success: function(e){
      $("#f_ccontrasenia").html(e);
      $("#b_ccontrasenia").show();
    }
  });
})
$("#b_ccontrasenia").click(function(){
  var datos = $("#f_ccontrasenia").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"call/g_ccontrasenia.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#r_ccontrasenia").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#b_ccontrasenia").hide();
    },
    success: function(e){
      if(e.e){
        $("#f_ccontrasenia").html(e.m);
      }else{
        $("#r_ccontrasenia").html(e.m);
        $("#b_ccontrasenia").show();
      }
    }
  });
})

function lprovincias(id){
  $.ajax({
    method: "POST",
    url: base+"callpage/ge_ubigeo.php",
    data: {iddep: id},
    dataType: 'html',
    beforeSend: function(){
      $("#provincia").html('Cargando...');
    },
    success: function(d){
      $("#provincia").html(d);
      $("#distrito").html('<option value="">DISTRITO</option>');
    }
  });
};

function ldistritos(id){
  $.ajax({
    method: "POST",
    url: base+"callpage/ge_ubigeo.php",
    data: {idpro: id},
    dataType: 'html',
    beforeSend: function(){
      $("#distrito").html('Cargando...');
    },
    success: function(d){
      $("#distrito").html(d);
    }
  });
};

function impcom(com){
  $.ajax({
    type: "post",
    url: base+"print/callprint/impcom.php",//print/callprint
    dataType: "html",
    data: {com: com},
    beforeSend: function () {
      $("#d_impcom").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_impcom").html(e);
    }
  });
}

function imptic(com){
  $.ajax({
    type: "post",
    url: base+"print/callprint/imptic.php",//print/callprint
    dataType: "html",
    data: {com: com},
    beforeSend: function () {
      $("#d_impcom").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_impcom").html(e);
    }
  });
}