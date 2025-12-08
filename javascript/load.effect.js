document.addEventListener("DOMContentLoaded", function (event) {
  TimerStartTimer1();
});

$(document).ready(function () {
  $("a[href*='#content']").click(function (event) {
    event.preventDefault();
    $("html, body")
      .stop()
      .animate({ scrollTop: $("#content").offset().top }, 600, "easeOutSine");
  });
  $("#PanelMenu1").panel({
    animate: true,
    animationDuration: 200,
    animationEasing: "linear",
    dismissible: false,
    display: "push",
    position: "left",
    toggle: true,
  });
  const caminho = window.location.pathname;
  const nomePagina = caminho.substring(caminho.lastIndexOf("/") + 1);
  if (nomePagina !== "index.php") {
    ShowObjectWithEffect("FlexContainer1", 1, "dropup", 200);
    ShowObjectWithEffect("content", 1, "dropright", 200);
    ShowObjectWithEffect("FlexContainer2", 1, "dropdown", 200);
  }
});

var wb_Timer1;
function TimerStartTimer1() {
  wb_Timer1 = setTimeout(function () {
    var event = null;
    var panel = document.getElementById("PanelMenu1");
    if (panel) {
      ShowPanel("PanelMenu1", event);
    }
  }, 10);
}

function TimerStopTimer1() {
  clearTimeout(wb_Timer1);
}

$(document).ready(function () {
  $(document).on("click", function (event) {
    // Se o clique for fora do menu-item e do submenu, fecha todos os submenus abertos
    if (!$(event.target).closest(".menuitem, .submenu").length) {
      $(".submenu").stop(true, true).slideUp(300);
      $(".icon.sub").removeClass("ativado"); // Mantém a rotação do ícone
    }
  });
});

function exibirSubmenu(item) {
  var submenu = $("#submenu_" + item);
  var icon = $("#expandir_" + item);

  // Fecha outros submenus antes de abrir o atual
  $(".submenu").not(submenu).stop(true, true).slideUp(300);
  $(".icon.sub").not(icon).removeClass("ativado");

  // Alterna o submenu atual
  submenu.stop(true, true).slideToggle(300);
  icon.toggleClass("ativado"); // Mantém a rotação do ícone
}