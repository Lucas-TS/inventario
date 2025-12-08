<?php require 'includes/valida_sessao.php'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Sistema de Inventário de Computadores</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/inventario.css" rel="stylesheet">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script src="javascript/jquery.mask.min.js"></script>
<script src="javascript/panel.min.js"></script>
<script src="javascript/wwb19.min.js"></script>
<script src="javascript/load.effect.js"></script>
<script src="javascript/load.svg.js"></script>
<script src="javascript/cookies.js"></script>
<script src="javascript/cria.tabela.js"></script>
<script src="javascript/avatar.js"></script>
<script src="javascript/chart.js"></script>
<script src="javascript/chart.labels.js"></script>

</head>
<body>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content" style="visibility:hidden;" class="content-index">
      <div id="cards-container" class="cards-container">
         <div id="bloco-card-vazio-1" class="card-vazio">
            <div id="card-pequeno-1" class="card">
               <div class=titulo-card-pequeno>
                  <span>
                     <svg class="icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <g><g><rect x="198.531" y="203.755" width="292.571" height="177.633" /></g></g>
                        <g><g><path d="M177.633,412.735v10.449c0,17.312,14.035,31.347,31.347,31.347h271.673c17.312,0,31.347-14.035,31.347-31.347v-10.449H177.633z"/></g></g>
                        <g><g><rect y="266.449" width="104.49" height="188.082" /></g></g>
                        <g><g><polygon points="52.245,57.469 52.245,235.102 135.837,235.102 135.837,297.796 167.184,297.796 167.184,172.408 470.204,172.408 470.204,57.469" /></g></g>
                        <g><g><rect x="135.837" y="329.143" width="31.347" height="52.245" /></g></g>
                     </svg>
                    Computadores
                  </span>
               </div>
               <div class=texto-card-pequeno>
                  <span id="span-computadores"></span>
               </div>
            </div>
            <div id="card-pequeno-2" class="card">
               <div class=titulo-card-pequeno>
                  <span>
                     <svg class="icon" viewBox="0 -32 576 576" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M528 448H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h480c26.51 0 48 21.49 48 48v288c0 26.51-21.49 48-48 48zM128 180v-40c0-6.627-5.373-12-12-12H76c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm-336 96v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm-336 96v-40c0-6.627-5.373-12-12-12H76c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm288 0v-40c0-6.627-5.373-12-12-12H172c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h232c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12z" />
                    </svg>
                    Periféricos
                  </span>
               </div>
               <div class=texto-card-pequeno>
                  <span id="span-perifericos"></span>
               </div>
            </div>
            <div id="card-pequeno-3" class="card">
               <div class=titulo-card-pequeno>
                  <span>
                     <svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 3 C21 1, 20 0, 19 0 C17 0, 16 1, 16 3 L16 8 C13 8, 12 9, 10 10 C9 12, 8 14, 8 16 L3 16 C1 16, 0 17, 0 19 C0 21, 1 22, 3 22 L8 22 L8 29 L3 29 C1 29, 0 30, 0 32 C0 34, 1 35, 3 35 L8 35 L8 42 L3 42 C1 42, 0 43, 0 45 C0 47, 1 48, 3 48 L8 48 C8 50, 9 52, 10 54 C12 55, 13 56, 16 56 L16 61 C16 63, 17 64, 19 64 C20 64, 21 63, 22 61 L22 56 L29 56 L29 61 C29 63, 30 64, 32 64 C33 64, 34 63, 35 61 L35 56 L42 56 L42 61 C42 63, 43 64, 45 64 C46 64, 47 63, 48 61 L48 56 C50 56, 52 55, 53 54 C55 52, 56 50, 56 48 L61 48 C62 48, 63 47, 64 45 C63 43, 62 42, 61 42 L56 42 L56 35 L61 35 C62 35, 63 34, 64 32 C63 30, 62 29, 61 29 L56 29 L56 22 L61 22 C62 22, 63 21, 64 19 C63 17, 62 16, 61 16 L56 16 C56 14, 55 12, 53 10 C52 9, 50 8, 48 8 L48 3 C47 1, 46 0, 45 0 C43 0, 42 1, 42 3 L42 8 L35 8 L35 3 C34 1, 33 0, 32 0 C30 0, 29 1, 29 3 L29 8 L22 8 L22 3Z  M20 16 L44 16 C45 16, 46 16, 47 17 C47 18, 48 19, 48 20 L48 44 C48 45, 47 46, 47 47 C46 48, 45 48, 44 48 L20 48 C18 48, 18 48, 17 47 C16 46, 16 45, 16 44 L16 20 C16 19, 16 18, 17 17 C18 16, 18 16, 20 16 Z M44 20 L20 20 L20 44 L44 44 L44 20Z " />
                     </svg>
                     Hardwares
                  </span>
               </div>
               <div class=texto-card-pequeno>
                  <span id="span-hardwares"></span>
               </div>
            </div>
            <div id="card-pequeno-4" class="card">
               <div class=titulo-card-pequeno>
                  <span>
                     <svg class="icon" viewBox="0 0 201.928 201.928" xmlns="http://www.w3.org/2000/svg">
                        <path d="M58.401,141.893c0-38.617,31.418-70.035,70.035-70.035c8.248,0,16.164,1.444,23.52,4.075V30.25c0-2.761-2.238-5-5-5h-5.5V10h5.5c2.762,0,5-2.239,5-5c0-2.761-2.238-5-5-5h-128.5c-2.762,0-5,2.239-5,5v25.25v0.25v152c0,2.761,2.238,5,5,5h56.898C64.802,175.236,58.401,159.303,58.401,141.893z M23.456,10h108v15.25h-108V10z M128.437,81.858c-33.104,0-60.035,26.932-60.035,60.035c0,33.103,26.932,60.035,60.035,60.035c33.104,0,60.035-26.932,60.035-60.035C188.472,108.79,161.54,81.858,128.437,81.858z M128.437,171.251c-16.189,0-29.358-13.17-29.358-29.358c0-16.188,13.17-29.358,29.358-29.358c16.188,0,29.358,13.17,29.358,29.358C157.795,158.081,144.625,171.251,128.437,171.251zM128.437,122.535c-10.674,0-19.358,8.684-19.358,19.358s8.685,19.358,19.358,19.358c10.674,0,19.358-8.684,19.358-19.358S139.11,122.535,128.437,122.535z M128.437,149.9c-4.415,0-8.007-3.592-8.007-8.007c0-4.415,3.592-8.007,8.007-8.007c4.415,0,8.007,3.592,8.007,8.007C136.443,146.308,132.852,149.9,128.437,149.9z"/>
                     </svg>
                     Softwares
                  </span>
               </div>
               <div class=texto-card-pequeno>
                  <span id="span-softwares"></span>
               </div>
            </div>
         </div>
         <div id="bloco-card-1" class="card">
         </div>
         <div id="bloco-card-2" class="card">
         </div>
         <div id="bloco-card-3" class="card">
         </div>
         <div id="bloco-card-4" class="card">
         </div>
         <div id="bloco-card-vazio-2" class="card-vazio">
            <div id="card-pequeno-5" class="card">
               <div class="titulo-card-pequeno link-card">
                  <a href="./add_pc.php" class="link-card">
                     <svg viewBox="0 0 1075 634" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" class="link-icon">
                        <path d="m51.23999,0.01003l204.91,0c28.3,-0.01 51.24,28.37 51.24,63.37l0,506.95c0,34.99 -22.94,63.37 -51.23,63.37l-204.92,0c-28.28,0 -51.23,-28.38 -51.23,-63.37l-0.01,-506.95c0.01,-35 22.96,-63.38 51.25,-63.38l-0.01,0.01zm0,63.37l0,63.37l204.91,0l0,-63.37l-204.91,0zm204.91,126.74l-204.91,0l0,63.38l204.91,-0.02l0,-63.36zm0,316.85l-51.22,0l0,63.37l51.22,0l0,-63.37zm819,-253.43l0,162.72c0,20.14 -16.32,36.47 -36.46,36.47l-286.07,0l0,107.96l104.93,0c20.08,0 36.51,16.43 36.51,36.5c0,20.08 -16.43,36.51 -36.51,36.51l-285.04,0c-20.08,0 -36.51,-16.43 -36.51,-36.51c0,-20.07 16.43,-36.5 36.51,-36.5l104.93,0l0,-107.96l-286.08,0c-20.13,0 -36.45,-16.33 -36.45,-36.47l0,-379.79c0,-20.14 16.32,-36.47 36.45,-36.47l430.25,0c32.86,0 32.86,51.46 0,51.46l-415.26,0l0,349.82l617.35,0l0,-147.74c0,-32.85 51.45,-32.86 51.45,0z"/>
                        <path d="m922.85999,228.03003l0,-75.74l-75.74,0c-14.03,0 -25.51,-11.48 -25.51,-25.52c0,-14.03 11.48,-25.51 25.51,-25.51l75.74,0l0,-75.74c0,-14.04 11.48,-25.52 25.52,-25.52c14.03,0 25.52,11.48 25.52,25.52l0,75.74l75.73,0c14.04,0 25.52,11.48 25.52,25.51c0,14.04 -11.48,25.52 -25.52,25.52l-75.73,0l0,75.74c0,14.03 -11.49,25.51 -25.52,25.51c-14.04,0 -25.52,-11.48 -25.52,-25.51z"/>
                     </svg>
                     <span class="span-card-pequeno">
                        Adicionar Computador
                     </span>
                  </a>
               </div>
            </div>
            <div id="card-pequeno-6" class="card">
               <div class="titulo-card-pequeno link-card">
                  <a href="./add_notebook.php" class="link-card">
                     <svg viewBox="0 0 2500 1792" xmlns="http://www.w3.org/2000/svg" clip-rule="evenodd" class="link-icon">
                        <path d="m2490.71,1560.01001l-222.57,-279.88l0,-563.21c0,-92.92 -145.49,-92.92 -145.49,0l0,417.73l-1745.62,0l0,-989.16l1174.19,0c92.91,0 92.91,-145.49 0,-145.49l-1216.56,0c-56.94,0 -103.09,46.17 -103.09,103.11l0,1177.02l-222.6,279.88c-5.8,7.3 -8.97,16.33 -8.97,25.7l0,123.88c0,45.46 36.82,82.26 82.26,82.26l2335.16,0c45.44,0 82.26,-36.8 82.26,-82.26l0,-123.88c0,-9.37 -3.14,-18.4 -8.97,-25.7zm-1005.93,134.01l-469.87,0l0,-124.39l469.87,0l0,124.39z"/>
                        <path d="m1837.52,644.76001l0,-214.15l-214.15,0c-39.69,0 -72.15,-32.47 -72.15,-72.15c0,-39.69 32.46,-72.16 72.15,-72.16l214.15,0l0,-214.15c0,-39.68 32.47,-72.15 72.16,-72.15c39.68,0 72.15,32.47 72.15,72.15l0,214.15l214.15,0c39.69,0 72.16,32.47 72.16,72.16c0,39.68 -32.47,72.15 -72.16,72.15l-214.15,0l0,214.15c0,39.69 -32.47,72.16 -72.15,72.16c-39.69,0 -72.16,-32.47 -72.16,-72.16z"/>
                     </svg>
                     <span class="span-card-pequeno">
                        Adicionar Notebook
                     </span>
                  </a>
               </div>
            </div>
            <div id="card-pequeno-7" class="card">
               <div class="titulo-card-pequeno link-card">
                  <a class="link-card">
                     <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="link-icon">
                        <path fill="none" d="M20 14V7C20 5.34315 18.6569 4 17 4H12M20 14L13.5 20M20 14H15.5C14.3954 14 13.5 14.8954 13.5 16V20M13.5 20H7C5.34315 20 4 18.6569 4 17V12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill="none" d="M7 4V7M7 10V7M7 7H4M7 7H10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                     <span class="span-card-pequeno">
                        Nova Ordem de Serviço
                     </span>
                  </a>
               </div>
            </div>
            <div id="card-pequeno-8" class="card">
               <div class="titulo-card-pequeno link-card">
                  <a href="#" class="link-card" onclick="exibirOverlayEditar(<?php echo $_SESSION['id']; ?>, 'avatar')">
                     <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" class="link-icon" stroke-width="0">
                        <path d="m7 7.88c2.18 0 3.94-1.76 3.94-3.94s-1.76-3.94-3.94-3.94c-2.17 0-3.94 1.76-3.94 3.94 0 2.17 1.77 3.94 3.94 3.94zm1.09 3.24c-.26-.52-.17-1.17.26-1.6l.28-.27c.05-.05.12-.08.18-.12h-4.31c-2.48.01-4.5 2.02-4.5 4.5 0 .12.01.25.03.38h7.95c-.44-.23-.74-.68-.74-1.21v-.4c0-.57.35-1.07.85-1.28zm6.76.7h-.98c-.06-.19-.14-.36-.24-.53l.65-.65c.15-.15.15-.4 0-.55l-.27-.27c-.15-.15-.4-.15-.55 0l-.66.66c-.18-.1-.37-.18-.58-.23v-.86c0-.21-.17-.39-.39-.39h-.39c-.21 0-.39.17-.39.39v.85c-.22.06-.43.15-.63.26l-.54-.54c-.15-.15-.4-.15-.55 0l-.28.27c-.15.15-.15.4 0 .55l.56.56c-.12.21-.21.43-.26.67h-.72c-.22 0-.39.17-.39.39v.39c0 .21.17.39.39.39h.78c.07.23.18.45.31.65l-.53.53c-.15.15-.15.4 0 .55l.27.27c.15.15.4.15.55 0l.59-.59c.2.1.41.17.64.21v.81c0 .21.17.39.39.39h.39c.21 0 .39-.17.39-.39v-.91c.2-.07.38-.16.55-.28l.63.63c.15.15.4.15.55 0l.27-.27c.15-.15.15-.4 0-.55l-.69-.69c.08-.17.15-.35.19-.55h.93c.22 0 .39-.17.39-.39v-.39c.01-.22-.17-.39-.38-.39zm-3.21 1.65c-.54 0-.97-.43-.97-.97s.44-.97.97-.97c.54 0 .97.43.97.97s-.43.97-.97.97z"/>
                     </svg>
                     <span class="span-card-pequeno">
                        Editar Perfil
                     </span>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="overlay" onclick="handleOverlayClick(event);clearTimeout(closeTimeout);">
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
<script src="javascript/cards.js"></script>
<script src="javascript/apagar.item.js"></script>
<script src="javascript/overlay.js"></script>
<script src="javascript/masks.js"></script>
<script src="javascript/more.less.js"></script>
<script src="javascript/events.js"></script>
</html>