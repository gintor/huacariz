$('#fecv, #inie, #fine').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
});

$("#b_validar").click(function(){
	//var fecv=$("#fecv").val();
  $.ajax({
    type: "post",
    url: base+"callpage/fa_validar.php",
    dataType: "html",
    data: {idm: idm},//fecv: fecv,
    beforeSend: function () {
      $("#r_validar").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#r_validar").html(e);
      $("#r_validar").slideDown("slow");
    }
  });
})

$("#b_estados").click(function(){
	var inie=$("#inie").val();
	var fine=$("#fine").val();
  $.ajax({
    type: "post",
    url: base+"callpage/fa_estados.php",
    dataType: "html",
    data: {inie: inie, fine: fine, idm: idm},
    beforeSend: function () {
      $("#r_estados").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#r_estados").html(e);
      $("#r_estados").slideDown("slow");
    }
  });
})