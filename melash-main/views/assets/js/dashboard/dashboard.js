/*=============================================
Interfaz Dashboard
=============================================*/

var menuToggle = document.getElementById("menu-toggle");
var sidebar = document.getElementById("sidebar-wrapper");
var menuText = $(".menu-text");
var btnPages = $(".btnPages");
var toogle = 0;

/*=============================================
Agrega un listener al botón para abrir/cerrar el menú
=============================================*/

menuToggle.addEventListener("click", function() {

  var isMobile = window.innerWidth <= 768;

  if (isMobile) {

    sidebar.classList.toggle("show");    

  } else {

    if(toogle == 0){

      toogle = 1;
       $(".sidebar-heading:first").css({"min-width":"50px"});
    
    }else{

      toogle = 0;
       $(".sidebar-heading:first").css({"min-width":"225px"});
    
    }
 
    sidebar.classList.toggle("collapsed");
    $(btnPages).toggle();

   } 

  menuText.each((i)=>{

    $(menuText[i]).css({"opacity":0})

    if(!sidebar.classList.contains("collapsed")){
      
      $(menuText[i]).animate({"opacity":1},500)
      
    }else{

      $(menuText[i]).animate({"opacity":0},500)
    
    }

  })
  
});

/*=============================================
Cierra el menú flotante si haces clic en cualquier parte fuera del menú
=============================================*/

document.addEventListener("click", function(event) {

  var isClickInsideMenu = sidebar.contains(event.target) || menuToggle.contains(event.target);
  var isMobile = window.innerWidth <= 768;

  // Si haces clic fuera del menú y el menú está visible en móvil, lo cierra
  if (!isClickInsideMenu && sidebar.classList.contains("show") && isMobile) {
    sidebar.classList.remove("show");
  }

});


/*=============================================
Hacer la tabla responsiva al cambio de ancho del navegador
=============================================*/

$(window).resize(function() {
    updateWidth();
});

function updateWidth() {

  var width = Number($(window).width())-100;

  if (width < 768 && $(".table-responsive").length) {

    var tableResponsive = $(".table-responsive");

    tableResponsive.each((i)=>{

      $(tableResponsive[i]).css({"width":width+"px"});

    })

  }

}

updateWidth();


/*=============================================
Limpiar el campo de icono
=============================================*/

$(document).on("change",".cleanIcon",function(){

  if($(this).val().split('"').length > 0){

    $(this).val($(this).val().split('"')[1]);

  }else{

     $(this).val($(this).val());
  }

})

/*=============================================
Formato de precio
=============================================*/

function money(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}




