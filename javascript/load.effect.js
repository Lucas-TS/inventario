document.addEventListener('DOMContentLoaded', function (event) {
   TimerStartTimer1();
});

$(document).ready(function () {
   ShowObjectWithEffect('FlexContainer1', 1, 'dropup', 200);
   $("a[href*='#content']").click(function (event) {
      event.preventDefault();
      $('html, body').stop().animate({ scrollTop: $('#content').offset().top }, 600, 'easeOutSine');
   });
   ShowObjectWithEffect('content', 1, 'dropright', 200);
   $("#PanelMenu1").panel({ animate: true, animationDuration: 200, animationEasing: 'linear', dismissible: false, display: 'push', position: 'left', toggle: true });
   ShowObjectWithEffect('FlexContainer2', 1, 'dropdown', 200);
});

var wb_Timer1;
function TimerStartTimer1() {
   wb_Timer1 = setTimeout(function () {
       var event = null;
       var panel = document.getElementById('PanelMenu1');
       if (panel) {
           ShowPanel('PanelMenu1', event);
       }
   }, 10);
}


function TimerStopTimer1() {
   clearTimeout(wb_Timer1);
}

function exibirSubmenu(item) {
   // Seleciona o submenu correspondente ao item clicado
   var submenu = $('#submenu_' + item);
   var icon = $('#expandir_' + item);

   // Verifica se o submenu já está visível
   var isVisible = submenu.hasClass('visivel');

   // Oculta todos os submenus
   $('.submenu').removeClass('visivel');
   $('.icon.sub').removeClass('visivel');

   // Se o submenu não estava visível, exibe-o
   if (!isVisible) {
       submenu.addClass('visivel');
       icon.addClass('visivel');
   }
}

// Fecha o submenu quando clicar fora do menu
$(document).on('click', function (event) {
   if (!$(event.target).closest('.menuitem').length) {
      $('.submenu').removeClass('visivel');
      $('.icon.sub').removeClass('visivel');
   }
});