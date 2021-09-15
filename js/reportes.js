$(document).ready(function(){
  //select2 para busqueda de clientes
$( "#clientev, #clientep, #clientepa" ).select2({
    placeholder: 'Buscar cliente',
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
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 3
});
})

$('#inipeda, #finpeda').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    startDate: '1/09/2018',
    endDate: '9/09/2018',
  });

$('#iniven, #finven').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
  });
  $('#iniped, #finped').datepicker({
      format: "dd/mm/yyyy",
      language: "es",
      autoclose: true,
      todayHighlight: true,
      startDate: '10/09/2018',
    });

// Buscar PRODUCTOS
  $("#f_reppro").submit(function(e){
   e.preventDefault();
   var datos = $("#f_reppro").serializeArray();
   $.ajax({
         data:  datos,
         url:   base+"callpage/a_repproductos.php",
         type:  "post",
         beforeSend: function () {
           $("#b_rprod").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
         },
         success:  function (response) {
           $("#b_rprod").html("Buscar");
           $("#r_rprod").html(response);
         }
     });
  });
// Fin Buscar PRODUCTOS

// Buscar VENTAS
  $("#f_repped").submit(function(e){
   e.preventDefault();
   var datos = $("#f_repped").serializeArray();
   $.ajax({
         data:  datos,
         url:   base+"callpage/a_reppedidos.php",
         type:  "post",
         beforeSend: function () {
           $("#b_rped").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
         },
         success:  function (response) {
           $("#b_rped").html("Buscar");
           $("#r_rped").html(response);
         }
     });
  });
// Fin Buscar VENTAS
// función llamar formulario detalle VENTAS
function detped(idped){
$.ajax({
 type: "post",
 url: base+"callpage/a_detpedido.php",
 dataType: "html",
 data: { idped : idped},
   beforeSend: function(){
     $("#f_dpedido").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
   },
   success: function(a){
     $("#fo_modal").html(a);
     $("#bg_modal").hide();
     $(".ti_modal").html("Detalle de Venta");
   }
});
};
//fin función llamar formulario detalle VENTAS
//función exportar productos
function bexpopro(){
  var fi=$("#iniven").val();
  var ff=$("#finven").val();
  var lo=$("#local").val();
  if (fi!="" & ff!="" & lo!=""){

    location.href=base+"exportar/exp_productos.php?fi="+fi+"&ff="+ff+"&lo="+lo;

  }else {
    alert("Todos los campos son obligatorios");
  }
}
//fin función exportar productos

//función exportar ventas
function bexpoven(){
  var fi=$("#iniped").val();
  var ff=$("#finped").val();
  var cl=$("#clientep").val();
  var est=$("#est").val();
  if (fi!="" & ff!="" & cl!="" & est!=""){

    location.href=base+"exportar/exp_ventas.php?fi="+fi+"&ff="+ff+"&cl="+cl+"&est="+est;

  }else {
    alert("Todos los campos son obligatorios ya ");
  }
}
//fin función exportar ventas


// Buscar VENTAS ANTIGUAS
  $("#f_reppeda").submit(function(e){
   e.preventDefault();
   var datos = $("#f_reppeda").serializeArray();
   $.ajax({
         data:  datos,
         url:   base+"callpage/a_reppedidosa.php",
         type:  "post",
         beforeSend: function () {
           $("#b_rpeda").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
         },
         success:  function (response) {
           $("#b_rpeda").html("Buscar");
           $("#r_rpeda").html(response);
         }
     });
  });
// Fin Buscar VENTAS ANTIGUAS
// función llamar formulario detalle VENTAS  ANTIGUAS
function detpeda(idped){
$.ajax({
 type: "post",
 url: base+"callpage/a_detpedidoa.php",
 dataType: "html",
 data: { idped : idped},
   beforeSend: function(){
     $("#f_dpedidoa").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
   },
   success: function(a){
     $("#fo_modal").html(a);
     $("#bg_modal").hide();
     $(".ti_modal").html("Detalle de Venta");
   }
});
};
//fin función llamar formulario detalle VENTAS  ANTIGUAS

//función exportar ventas ANTIGUAS
function bexpovena(){
  var fi=$("#inipeda").val();
  var ff=$("#finpeda").val();
  var cl=$("#clientepa").val();
  var est=$("#esta").val();
  if (fi!="" & ff!="" & cl!="" & est!=""){

    location.href=base+"exportar/exp_ventasa.php?fi="+fi+"&ff="+ff+"&cl="+cl+"&est="+est;

  }else {
    alert("Todos los campos son obligatorios");
  }
}
//fin función exportar ventas ANTIGUAS
