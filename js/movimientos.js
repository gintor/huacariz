$(document).ready(function(){
	$('#mesani').datepicker({
		format: 'mm/yyyy',
		autoclose: true,
		language: "es",
		minViewMode: 1,
		maxViewMode: 2
	});
	var ma=new Date();
	var mao=(ma.getMonth()+1)+"/"+ma.getFullYear();
	l_ingegr(idm,mao);
});

function l_ingegr(idmo,ma){
  $.ajax({
    type: "post",
    url: base+"callpage/mo_li_ingegr.php",
    dataType: "html",
    data: {idm: idmo, ma: ma},
    beforeSend: function () {
      $("#t_ingegr").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#t_ingegr").html(e);
      $("#t_ingegr").slideDown("slow");
    }
  });
};

$("#b_li_ingegr").click(function(){
	var mesani=$("#mesani").val();
	l_ingegr(idm, mesani);
});

function mo_f_ingegr(idmo,acc,idmov){
  if(acc=="edi"){
    $(".modal-dialog").addClass("modal-lg");
  }else{
  	$(".modal-dialog").removeClass("modal-lg");
  }
  $('#m_ingegr').modal('show');
  switch (acc){
    case "edi":
      var tit='<i class="fa fa-pencil text-green"></i> Editar Ingreso Egreso';
      break;
    case "est":
      var tit='<i class="fa fa-toggle-on text-green"></i> Cambiar Estado Ingreso Egreso';
      break;
    case "eli":
      var tit='<i class="fa fa-lock text-green"></i> Eliminar Ingreso Egreso';
      break;
  };
  $(".tm_ingegr").html(tit);
    $.ajax({
    method: "POST",
    url: base+"callpage/mo_f_ingegr.php",
    data: {idm: idmo, acc: acc, idmov: idmov},
    dataType: 'html',
    beforeSend: function(){
      $("#f_ingegr").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_ingegr").hide();
    },
    success: function(d){
      $("#f_ingegr").html(d);
      $("#bg_ingegr").show();
    }
  });
}

$("#bg_ingegr").click(function(){
  var datos = $("#f_ingegr").serializeArray();
  $.ajax({
    method: "POST",
    url: base+"callpage/se_crud_ingegr.php",
    data: datos,
    dataType: 'json',
    beforeSend: function(){
      $("#r_ingegr").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_ingegr").hide();
    },
    success: function(d){
      if(d.e){
        $("#f_ingegr").html(d.m);
        var mesani=$("#mesani").val();
        l_ingegr(idm, mesani);
      }else{
        $("#r_ingegr").html(d.m);
        $("#bg_ingegr").show();
      }
    }
  });
});