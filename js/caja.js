$(document).ready(function(){
	$('#fec').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
		language: "es",
		minViewMode: 0,
		maxViewMode: 2,
		todayHighlight: true
	});

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	if(dd<10){
	    dd='0'+dd;
	} 
	if(mm<10){
	    mm='0'+mm;
	} 
	var today = dd+'/'+mm+'/'+yyyy;

	l_cajas(idm,today);

});


function l_cajas(idm,fec){
  $.ajax({
    type: "post",
    url: base+"callpage/ca_li_cajas.php",
    dataType: "html",
    data: {idm: idm, fec: fec},
    beforeSend: function () {
      $("#d_cajas").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_cajas").html(e);
      $("#d_cajas").slideDown("slow");
    }
  });
}

$("#f_bcajas").submit(function(e){
	e.preventDefault();
	var f=$("#fec").val();
	l_cajas(idm,f);
});

function ca_f_caja(idmo,acc,idf){
  $('#modal').modal('show');
  switch (acc){
    case "addcaj":
      var tit='<i class="fa fa-plus text-red"></i> Abrir Caja';
      break;
    case "elicaj":
      var tit='<i class="fa fa-trash text-red"></i> Eliminar Caja';
      break;
    case "cobdes":
      var tit='<i class="fa fa-money text-red"></i> Cobrar';
      break;
    case "addmov":
      var tit='<i class="fa fa-expand text-red"></i> Agregar movimiento';
      break;
    case "canven":
      var tit='<i class="fa fa-ban text-red"></i> Cancelar venta';
      break;
    case "cercaj":
      var tit='<i class="fa fa-archive text-red"></i> Cerrar Caja';
      break;
    case "infoven":
      var tit='<i class="fa fa-info-circle text-red"></i> Info venta';
      break;
  };
  $(".ti_modal").html(tit);
  var idca=$("#idca").val();
    $.ajax({
    method: "POST",
    url: base+"callpage/ca_f_caja.php",
    data: {idm: idmo, acc: acc, idf: idf, idca:idca},
    dataType: 'html',
    beforeSend: function(){
      $("#fo_modal").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
      $("#d_bimpcom").html('');
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
    url: base+"callpage/ca_g_caja.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#d_resultado").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_modal").hide();
      $("#d_bimpcom").html('');
    },
    success: function(d){
      if(d.e){
        $("#fo_modal").html(d.m);
        if(d.t==1){
          imptic(d.c);
          imptic(d.c);
        }else if(d.t==2 || d.t==3){
          $("#d_bimpcom").html('<button type="button" class="btn bg-orange" onclick="impcom(\''+d.c+'\');"><i class="fa fa-print"></i></button>');
        }
        var f=$("#fec").val();
        var idca=$("#idca").val();
        if(f!=undefined){
          l_cajas(idm,f);
        }
        if(idca!=undefined){
          ca_l_ventas(idm, idca);
        }
      }else{
        $("#d_resultado").html(d.m);
        $("#bg_modal").show();
      }
    }
  });
});

function ca_l_ventas(idm,idc){
  $.ajax({
    type: "post",
    url: base+"callpage/ca_li_ventas.php",
    dataType: "html",
    data: {idm: idm, idc: idc},
    beforeSend: function () {
      $("#d_cajas").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_cajas").html(e);
      $("#d_cajas").slideDown("slow");
    }
  });
};