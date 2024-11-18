<nav id="wb_PanelMenu1" style="display:inline-block;width:64px;height:48px;text-align:center;z-index:1;">
    <!-- BOTÃO MENU -->
    <a href="#PanelMenu1_markup" id="PanelMenu1" title="Ocultar/Exibir menu lateral">
        <svg class="button-icon" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 48 C16 43, 17 40, 20 37 L20 37 C23 34, 27 32, 32 32 L224 32 C228 32, 232 34, 235 37 C238 40, 240 43, 240 48 C240 53, 238 57, 235 60 C232 63, 228 64, 224 64 L32 64 C27 64, 23 63, 20 60 C17 57, 16 53, 16 48 Z M16 128 C16 123, 17 120, 20 117 L20 117 C23 114, 27 112, 32 112 L224 112 C228 112, 232 114, 235 117 C238 120, 240 123, 240 128 C240 133, 238 137, 235 140 C232 143, 228 144, 224 144 L32 144 C27 144, 23 143, 20 140 C17 137, 16 133, 16 128 Z M240 208 C240 213, 238 217, 235 220 L235 220 C232 223, 228 224, 224 224 L32 224 C27 224, 23 223, 20 220 C17 217, 16 213, 16 208 C16 203, 17 200, 20 197 C23 194, 27 192, 32 192 L224 192 C228 192, 232 194, 235 197 C238 200, 240 203, 240 208" />
        </svg>
        &nbsp;</a>
    <!-- INÍCIO DO MENU -->
    <div id="PanelMenu1_markup">
        <!-- AVATAR -->
        <div id="PanelMenu1-logo"><img id="avatar" alt="" src="<?php echo $avatar; ?>"></div>
        <ul role="menu" class="menu">
            <!-- Item HOME -->
            <li role="menuitem">
                <a href="index.php" class="nav-link PanelMenu1-effect"><svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M68 32 C68 33, 67 34, 66 35 L66 35 C66 36, 65 36, 64 36 L60 36 L60 56 C60 56, 60 57, 60 57 L60 59 C60 60, 59 62, 58 63 C57 64, 56 64, 55 64 L53 64 C52 64, 52 64, 52 64 C52 64, 52 64, 52 64 L48 64 L45 64 C43 64, 42 64, 41 63 C40 62, 40 60, 40 59 L40 56 L40 48 C40 47, 39 46, 39 45 C38 44, 37 44, 36 44 L28 44 C26 44, 26 44, 25 45 C24 46, 24 47, 24 48 L24 56 L24 59 C24 60, 23 62, 22 63 C21 64, 20 64, 19 64 L16 64 L12 64 C12 64, 11 64, 11 64 C11 64, 11 64, 11 64 C11 64, 11 64, 11 64 L9 64 C7 64, 6 64, 5 63 C4 62, 4 60, 4 59 L4 45 C4 45, 4 45, 4 45 L4 36 L0 36 C-2 36, -2 36, -3 35 C-4 34, -4 33, -4 32 C-4 31, -4 30, -3 29 L29 1 C30 0, 31 0, 32 0 C33 0, 34 0, 34 1 L66 29 C67 30, 68 31, 68 32" />
                    </svg>
                    <span>Home</span></a></li>
            <!-- Item MILITARES -->
            <li role="menuitem">
                <a href="lista.php?tabela=militares" class="nav-link PanelMenu1-effect"><svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 32 C35 32, 37 31, 40 30 L40 30 C42 28, 44 27, 46 24 C47 22, 48 19, 48 16 C48 13, 47 11, 46 8 C44 6, 42 4, 40 2 C37 1, 35 0, 32 0 C29 0, 26 1, 24 2 C21 4, 19 6, 18 8 C16 11, 16 13, 16 16 C16 19, 16 22, 18 24 C19 27, 21 28, 24 30 C26 31, 29 32, 32 32 Z M26 38 C20 38, 14 40, 10 45 L10 45 C6 49, 4 54, 4 60 C4 61, 4 62, 5 63 C5 64, 6 64, 7 64 L56 64 C57 64, 58 64, 59 63 C59 62, 60 61, 60 60 C59 54, 57 49, 53 45 C49 40, 44 38, 37 38 L26 38Z " />
                    </svg>
                    <span>Militares</span>
                </a>
            </li>
            <!-- Item SEÇÕES -->
            <li role="menuitem">
                <a href="lista.php?tabela=secao" class="nav-link PanelMenu1-effect"><svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path  d="M10 0 C13 0, 16 2, 18 5 C20 8, 20 12, 18 15 C16 18, 13 20, 10 20 C6 20, 3 18, 1 15 C-1 12, -1 8, 1 5 C3 2, 6 0, 10 0 Z M56 0 C59 0, 62 2, 64 5 C66 8, 66 12, 64 15 C62 18, 59 20, 56 20 C52 20, 49 18, 47 15 C45 12, 45 8, 47 5 C49 2, 52 0, 56 0 Z M-8 37 C-8 34, -7 30, -4 28 L-4 28 C-2 25, 1 24, 5 24 L10 24 C12 24, 14 24, 16 25 C16 26, 16 27, 16 28 C16 33, 18 37, 21 40 C21 40, 21 40, 21 40 C21 40, 21 40, 21 40 L-6 40 C-7 40, -8 39, -8 37 Z M42 40 C42 40, 42 40, 42 40 L42 40 C42 40, 42 40, 42 40 C46 37, 47 33, 48 28 C48 27, 48 26, 47 25 C49 24, 51 24, 53 24 L58 24 C62 24, 65 25, 68 28 C70 30, 72 34, 72 37 C71 39, 71 40, 69 40 L42 40Z  M20 28 C20 26, 20 24, 21 22 L21 22 C22 20, 24 19, 26 18 C28 17, 30 16, 32 16 C34 16, 36 17, 38 18 C39 19, 41 20, 42 22 C43 24, 44 26, 44 28 C44 30, 43 32, 42 34 C41 36, 39 37, 38 38 C36 39, 34 40, 32 40 C30 40, 28 39, 26 38 C24 37, 22 36, 21 34 C20 32, 20 30, 20 28 Z M8 61 C8 56, 9 52, 13 49 L13 49 C16 46, 20 44, 24 44 L39 44 C44 44, 48 46, 51 49 C54 52, 56 56, 56 61 C55 63, 54 64, 52 64 L11 64 C9 64, 8 63, 8 61" />
                    </svg>
                    <span>Se&#231;&#245;es</span>
                </a>
            </li>
            <!-- Item COMPUTADORES -->
            <li role="menuitem" onclick="exibirSubmenu('pc')">
                <a class="nav-link PanelMenu1-effect" style="cursor:pointer;">
                    <svg class="icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <g><g><rect x="198.531" y="203.755" width="292.571" height="177.633" /></g></g>
                        <g><g><path d="M177.633,412.735v10.449c0,17.312,14.035,31.347,31.347,31.347h271.673c17.312,0,31.347-14.035,31.347-31.347v-10.449H177.633z"/></g></g>
                        <g><g><rect y="266.449" width="104.49" height="188.082" /></g></g>
                        <g><g><polygon points="52.245,57.469 52.245,235.102 135.837,235.102 135.837,297.796 167.184,297.796 167.184,172.408 470.204,172.408 470.204,57.469" /></g></g>
                        <g><g><rect x="135.837" y="329.143" width="31.347" height="52.245" /></g></g>
                    </svg>
                    <span>Computadores</span>
                    <svg id="expandir_pc" class="icon sub" fill="none" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"  d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z" />
                    </svg>
                </a>
                <!-- SUBMENU COMPUTADORES -->
                <ul id="submenu_pc" class="submenu">
                    <!-- Item DESKTOPS -->
                    <li>
                        <a href="lista.php?tabela=computadores">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M40 12 L40 40 L0 40 L0 12 L40 12Z  M0 4 C-3 4, -4 5, -6 6 L-6 6 C-7 8, -8 10, -8 12 L-8 40 C-8 42, -7 44, -6 46 C-4 47, -3 48, 0 48 L14 48 L13 52 L4 52 C2 52, 2 52, 1 53 C0 54, 0 55, 0 56 C0 57, 0 58, 1 59 C2 60, 2 60, 4 60 L36 60 C37 60, 38 60, 39 59 C39 58, 40 57, 40 56 C40 55, 39 54, 39 53 C38 52, 37 52, 36 52 L26 52 L25 48 L40 48 C42 48, 44 47, 45 46 C47 44, 48 42, 48 40 L48 12 C48 10, 47 8, 45 6 C44 5, 42 4, 40 4 L0 4Z  M58 4 C56 4, 55 5, 53 6 L53 6 C52 7, 52 8, 52 10 L52 54 C52 56, 52 57, 53 58 C55 59, 56 60, 58 60 L66 60 C67 60, 69 59, 70 58 C71 57, 72 56, 72 54 L72 10 C72 8, 71 7, 70 6 C69 5, 67 4, 66 4 L58 4Z  M60 12 L64 12 C65 12, 66 13, 66 14 C66 15, 65 16, 64 16 L60 16 C58 16, 58 15, 58 14 C58 13, 58 12, 60 12 Z M58 22 C58 21, 58 20, 60 20 L64 20 C65 20, 66 21, 66 22 C66 23, 65 24, 64 24 L60 24 C58 24, 58 23, 58 22 Z M62 42 C63 42, 64 42, 65 43 L65 43 C65 44, 66 45, 66 46 C66 47, 65 48, 65 49 C64 50, 63 50, 62 50 C60 50, 60 50, 59 49 C58 48, 58 47, 58 46 C58 45, 58 44, 59 43 C60 42, 60 42, 62 42" />
                            </svg>
                            <span>Desktops</span>
                        </a>
                    </li>
                    <!-- Item NOTEBOOKS -->
                    <li>
                        <a href="lista.php?tabela=notebooks">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path class="st0" d="M510.163,392.022l-45.59-57.326V93.611c0-11.662-9.458-21.12-21.12-21.12H68.546c-11.662,0-21.115,9.458-21.115,21.12v241.085L1.837,392.022C0.648,393.517,0,395.367,0,397.287v25.373c0,9.311,7.542,16.849,16.849,16.849h478.302c9.307,0,16.849-7.538,16.849-16.849v-25.373C512,395.367,511.356,393.517,510.163,392.022z M77.226,102.291h357.548v202.606H77.226V102.291z M304.121,419.47h-96.242v-25.478h96.242V419.47z" />
                            </svg>
                            <span>Notebooks</span>
                        </a>
                    </li>
                    <!-- Item SERVIDORES -->
                    <li>
                        <a href="lista.php?tabela=servidores">
                            <span class="guia">└</span>
                            <svg class="icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path class="st0" d="M280,409.076V366.25h-48v42.826c-2.695,2.078-5.094,4.478-7.174,7.174H116.5v48h108.326c7.225,9.365,18.432,15.5,31.174,15.5c12.742,0,23.949-6.135,31.174-15.5H395.5v-48H287.174C285.094,413.554,282.695,411.154,280,409.076z" />
                                <path class="st0" d="M0,32.25v144h512v-144H0z M436,104.25c0,13.254-10.746,24-24,24c-13.254,0-24-10.746-24-24c0-13.256,10.746-24,24-24C425.254,80.25,436,90.994,436,104.25z M48.053,136.143L80,72.25h22.146l9.801,0.106L80,136.25H57.808L48.053,136.143z M112.053,136.143L144,72.25h22.146l9.801,0.106L144,136.25h-22.192L112.053,136.143z M176.053,136.143L208,72.25h22.146l9.801,0.106L208,136.25h-22.192L176.053,136.143z" />
                                <path class="st0" d="M280,190.25h-48v18H0v144h512v-144H280V190.25z M48.053,312.143L80,248.25h22.146l9.801,0.106L80,312.25H57.808L48.053,312.143z M112.053,312.143L144,248.25h22.146l9.801,0.106L144,312.25h-22.192L112.053,312.143z M176.053,312.143L208,248.25h22.146l9.801,0.106L208,312.25h-22.192L176.053,312.143z M388,280.25c0-13.256,10.746-24,24-24c13.254,0,24,10.744,24,24c0,13.254-10.746,24-24,24C398.746,304.25,388,293.504,388,280.25z" />
                            </svg>
                            <span>Servidores</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Item PERIFÉRICOS -->
            <li role="menuitem" onclick="exibirSubmenu('per')">
                <a class="nav-link PanelMenu1-effect" style="cursor:pointer;">
                    <svg class="icon" viewBox="0 -32 576 576" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M528 448H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h480c26.51 0 48 21.49 48 48v288c0 26.51-21.49 48-48 48zM128 180v-40c0-6.627-5.373-12-12-12H76c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm-336 96v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm-336 96v-40c0-6.627-5.373-12-12-12H76c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12zm288 0v-40c0-6.627-5.373-12-12-12H172c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h232c6.627 0 12-5.373 12-12zm96 0v-40c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12z" />
                    </svg>
                    <span>Perif&#233;ricos</span>
                    <svg id="expandir_per" class="icon sub" fill="none" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z" />
                    </svg>
                </a>
                <!-- SUBMENU PERIFÉRICOS -->
                <ul id="submenu_per" class="submenu">
                    <!-- Item MONITORES -->
                    <li>
                        <a href="lista.php?tabela=lista_monitor">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 8 8" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M.34 0a.5.5 0 0 0-.34.5v5a.5.5 0 0 0 .5.5h2.5v1h-1c-.55 0-1 .45-1 1h6c0-.55-.45-1-1-1h-1v-1h2.5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.09 0 .5.5 0 0 0-.06 0zm.66 1h6v4h-6v-4z" />
                            </svg>
                            <span>Monitores</span>
                        </a>
                    </li>
                    <!-- Item IMPRESSORAS -->
                    <li>
                        <a href="lista.php?tabela=lista_impressora">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <rect x="168.084" y="335.709" class="st0" width="175.831" height="20.29" />
                                <rect x="168.084" y="387.871" class="st0" width="175.831" height="20.29" />
                                <rect x="168.084" y="434.242" class="st0" width="83.085" height="20.29" />
                                <path class="st0" d="M488.338,163.731c-8.009-8.029-19.199-13.028-31.44-13.028h-47.304V78.276L331.319,0h-4.798H102.405v150.703H55.102c-12.253,0-23.44,5-31.448,13.028c-8.02,8.013-13.02,19.199-13.012,31.436v169.958c-0.008,12.245,4.983,23.432,13.012,31.453c8.017,8.012,19.208,13.02,31.448,13.004h47.303V512h307.189V409.582h47.304c12.233,0.016,23.419-4.992,31.428-13.004c8.033-7.996,13.04-19.2,13.033-31.453V195.168C501.366,182.922,496.359,171.744,488.338,163.731z M324.587,26.048l57.024,57.041h-57.024V26.048z M386.409,488.819H125.59V398h-0.012v-94.655H386.4v106.238h0.008V488.819z M335.813,230.287c0-9.216,7.475-16.679,16.675-16.679c9.216,0,16.679,7.463,16.679,16.679c0,9.208-7.463,16.671-16.679,16.671C343.289,246.958,335.813,239.495,335.813,230.287zM386.409,150.703H125.59V23.189h175.811v83.074h85.007V150.703z M423.467,246.958c-9.204,0-16.667-7.463-16.667-16.671c0-9.216,7.463-16.679,16.667-16.679c9.212,0,16.675,7.463,16.675,16.679C440.142,239.495,432.679,246.958,423.467,246.958z" />
                            </svg>
                            <span>Impressoras</span>
                        </a>
                    </li>
                    <!-- Item SWITCHES -->
                    <li>
                        <a href="lista.php?tabela=lista_switch">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M33.91,18.47,30.78,8.41A2,2,0,0,0,28.87,7H7.13A2,2,0,0,0,5.22,8.41L2.09,18.48a2,2,0,0,0-.09.59V27a2,2,0,0,0,2,2H32a2,2,0,0,0,2-2V19.06A2,2,0,0,0,33.91,18.47ZM8.92,25H7.12V22h1.8Zm5,0h-1.8V22h1.8Zm5,0h-1.8V22h1.8Zm5,0H22.1V22h1.8Zm5,0H27.1V22h1.8ZM31,19.4H5V18H31Z" class="clr-i-solid clr-i-solid-path-1"></path>
                            </svg>
                            <span>Switches</span>
                        </a>
                    </li>
                    <!-- Item TV'S -->
                    <li>
                        <a href="lista.php?tabela=lista_tv">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 0 3 L 0 15 L 20 15 L 20 3 L 0 3 z M 1 4 L 19 4 L 19 14 L 1 14 L 1 4 z M 5 16 L 5 17 L 15 17 L 15 16 L 5 16 z"/>
                            </svg>
                            <span>TV's</span>
                        </a>
                    </li>
                    <!-- Item PROJETORES -->
                    <li>
                        <a href="lista.php?tabela=lista_projetor">
                            <span class="guia">└</span>
                            <svg class="icon" viewBox="0 0 50.001 50.001" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="38.001" cy="22.483" r="5" />
                                <path d="M44.361,14.828c-1.732-1.443-3.932-2.344-6.36-2.344c-2.41,0-4.591,0.887-6.315,2.307H5.999c-3.3,0-5.999,2.701-5.999,6v8c0,3.299,2.699,6,5.999,6v1.728c0,0.55,0.45,1,1,1h3.308c0.549,0,1-0.45,1-1V34.79h27.386v1.728c0,0.55,0.451,1,1,1h3.309c0.55,0,1-0.45,1-1V34.79c3.3,0,5.999-2.701,5.999-6v-8C50,17.615,47.493,15.019,44.361,14.828z M7.012,28.79c0,0.551-0.762,1-1.692,1c-0.926,0-1.689-0.449-1.689-1v-8c0-0.55,0.764-1,1.689-1c0.931,0,1.692,0.45,1.692,1V28.79zM12.339,28.79c0,0.551-0.757,1-1.688,1c-0.928,0-1.689-0.449-1.689-1v-8c0-0.55,0.762-1,1.689-1c0.932,0,1.688,0.45,1.688,1V28.79z M17.67,28.79c0,0.551-0.764,1-1.689,1c-0.931,0-1.692-0.449-1.692-1v-8c0-0.55,0.762-1,1.692-1c0.926,0,1.689,0.45,1.689,1V28.79z M38.001,29.483c-3.864,0-7.001-3.135-7.001-7c0-3.866,3.137-7,7.001-7c3.865,0,7.001,3.134,7.001,7C45.002,26.349,41.866,29.483,38.001,29.483z" />
                            </svg>
                            <span>Projetores</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Item HARDWARES -->
            <li role="menuitem" onclick="exibirSubmenu('hw')">
                <a class="nav-link PanelMenu1-effect" style="cursor:pointer;">
                    <svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 3 C21 1, 20 0, 19 0 C17 0, 16 1, 16 3 L16 8 C13 8, 12 9, 10 10 C9 12, 8 14, 8 16 L3 16 C1 16, 0 17, 0 19 C0 21, 1 22, 3 22 L8 22 L8 29 L3 29 C1 29, 0 30, 0 32 C0 34, 1 35, 3 35 L8 35 L8 42 L3 42 C1 42, 0 43, 0 45 C0 47, 1 48, 3 48 L8 48 C8 50, 9 52, 10 54 C12 55, 13 56, 16 56 L16 61 C16 63, 17 64, 19 64 C20 64, 21 63, 22 61 L22 56 L29 56 L29 61 C29 63, 30 64, 32 64 C33 64, 34 63, 35 61 L35 56 L42 56 L42 61 C42 63, 43 64, 45 64 C46 64, 47 63, 48 61 L48 56 C50 56, 52 55, 53 54 C55 52, 56 50, 56 48 L61 48 C62 48, 63 47, 64 45 C63 43, 62 42, 61 42 L56 42 L56 35 L61 35 C62 35, 63 34, 64 32 C63 30, 62 29, 61 29 L56 29 L56 22 L61 22 C62 22, 63 21, 64 19 C63 17, 62 16, 61 16 L56 16 C56 14, 55 12, 53 10 C52 9, 50 8, 48 8 L48 3 C47 1, 46 0, 45 0 C43 0, 42 1, 42 3 L42 8 L35 8 L35 3 C34 1, 33 0, 32 0 C30 0, 29 1, 29 3 L29 8 L22 8 L22 3Z  M20 16 L44 16 C45 16, 46 16, 47 17 C47 18, 48 19, 48 20 L48 44 C48 45, 47 46, 47 47 C46 48, 45 48, 44 48 L20 48 C18 48, 18 48, 17 47 C16 46, 16 45, 16 44 L16 20 C16 19, 16 18, 17 17 C18 16, 18 16, 20 16 Z M44 20 L20 20 L20 44 L44 44 L44 20Z " />
                    </svg>
                    <span>Hardwares</span>
                    <svg id="expandir_hw" class="icon sub" fill="none" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z" />
                    </svg>
                </a>
                <!-- SUBMENU HARDWARES -->
                <ul id="submenu_hw" class="submenu">
                    <!-- Item PROCESSADORES -->
                    <li>
                        <a href="lista.php?tabela=lista_processador">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 180 180" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M180,169.531V10.469c-2.931,1.615-6.686,1.187-9.171-1.298c-2.485-2.485-2.914-6.24-1.298-9.171H31.905v2.64c0,2.344-1.899,4.243-4.243,4.243c-2.343,0-4.242-1.899-4.242-4.243V0H10.469c1.616,2.931,1.188,6.686-1.298,9.171C6.685,11.655,2.931,12.084,0,10.469v159.063c2.931-1.615,6.685-1.187,9.171,1.298c2.485,2.485,2.913,6.24,1.298,9.171H23.42v-2.64c0-2.344,1.899-4.243,4.242-4.243c2.344,0,4.243,1.899,4.243,4.243V180h137.626c-1.616-2.931-1.188-6.686,1.298-9.171C173.314,168.345,177.069,167.916,180,169.531zM157.948,136.295c0,11.939-9.714,21.653-21.653,21.653h-22.398c-3.099,0-5.61-2.512-5.61-5.61c0-3.099,2.512-5.61,5.61-5.61h22.398c5.753,0,10.433-4.68,10.433-10.433v-92.59c0-5.753-4.68-10.433-10.433-10.433H43.703c-5.751,0-10.431,4.68-10.431,10.433v92.59c0,5.753,4.679,10.433,10.431,10.433h22.4c3.099,0,5.61,2.512,5.61,5.61c0,3.099-2.512,5.61-5.61,5.61h-22.4c-11.938,0-21.651-9.714-21.651-21.653v-92.59c0-11.94,9.713-21.653,21.651-21.653h92.592c11.939,0,21.653,9.714,21.653,21.653V136.295zM52.521,134.156c-3.681,0-6.678-2.994-6.678-6.681V52.524c0-3.687,2.997-6.681,6.678-6.681h74.954c3.687,0,6.681,2.994,6.681,6.681v74.951c0,3.686-2.994,6.681-6.681,6.681H52.521zM76.316,78.624v4.239h-6.482v-4.676c0-3.116-1.371-4.302-3.554-4.302c-2.181,0-3.554,1.186-3.554,4.302v23.563c0,3.115,1.373,4.237,3.554,4.237c2.183,0,3.554-1.122,3.554-4.237v-6.233h6.482v5.795c0,6.983-3.49,10.973-10.223,10.973c-6.733,0-10.223-3.989-10.223-10.973V78.624c0-6.982,3.49-10.972,10.223-10.972C72.826,67.652,76.316,71.642,76.316,78.624zM90.592,68.151H80.493v43.635h6.856V95.392h3.242c6.856,0,10.223-3.803,10.223-10.783v-5.674C100.814,71.954,97.448,68.151,90.592,68.151zM93.958,85.045c0,3.116-1.186,4.113-3.366,4.113H87.35V74.385h3.242c2.181,0,3.366,0.997,3.366,4.113V85.045zM117.646,68.151h6.483v33.225c0,6.982-3.491,10.972-10.224,10.972c-6.733,0-10.224-3.989-10.224-10.972V68.151h6.857v33.661c0,3.116,1.371,4.238,3.553,4.238c2.183,0,3.554-1.122,3.554-4.238V68.151z" />
                            </svg>
                            <span>Processadores</span>
                        </a>
                    </li>
                    <!-- Item HD'S -->
                    <li>
                        <a href="lista.php?tabela=lista_hd">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 286 286" version="1.1" xmlns="http://www.w3.org/2000/svg" transform="rotate(270)">
                                <path d="M172.559,112.934c0,16.114-13.11,29.225-29.226,29.225c-16.114,0-29.225-13.11-29.225-29.225s13.11-29.225,29.225-29.225C159.448,83.709,172.559,96.819,172.559,112.934zM257,271c0,8.284-6.716,15-15,15H44c-8.284,0-15-6.716-15-15V15c0-8.284,6.716-15,15-15h198c8.284,0,15,6.716,15,15V271zM58.486,43.102c0,7.856,6.369,14.225,14.225,14.225c7.856,0,14.225-6.369,14.225-14.225s-6.369-14.225-14.225-14.225C64.855,28.877,58.486,35.246,58.486,43.102zM86.936,243.114c0-7.856-6.369-14.225-14.225-14.225c-7.856,0-14.225,6.369-14.225,14.225c0,7.856,6.369,14.225,14.225,14.225C80.568,257.339,86.936,250.97,86.936,243.114zM214.187,115.089c0-38.791-31.56-70.35-70.351-70.35s-70.35,31.559-70.35,70.35c0,17.174,6.194,32.923,16.455,45.151l11.858-11.897c4.913-4.929,12.566-5.832,18.489-2.184c5.924,3.647,8.562,10.89,6.373,17.493l-5.925,17.871c7.24,2.525,15.008,3.915,23.099,3.915C182.627,185.438,214.187,153.88,214.187,115.089zM229.186,243.114c0-7.856-6.369-14.225-14.225-14.225c-7.856,0-14.225,6.369-14.225,14.225c0,7.856,6.369,14.225,14.225,14.225C222.817,257.339,229.186,250.97,229.186,243.114zM229.186,43.102c0-7.856-6.369-14.225-14.225-14.225c-7.856,0-14.225,6.369-14.225,14.225s6.369,14.225,14.225,14.225C222.817,57.327,229.186,50.958,229.186,43.102z" />
                            </svg>
                            <span>HD's</span>
                        </a>
                    </li>
                    <!-- Item SSD'S -->
                    <li>
                        <a href="lista.php?tabela=lista_ssd">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M32,6H4A2,2,0,0,0,2,8V28a2,2,0,0,0,2,2H32a2,2,0,0,0,2-2V8A2,2,0,0,0,32,6ZM5.21,8A1.25,1.25,0,1,1,4,9.25,1.25,1.25,0,0,1,5.21,8Zm0,20a1.25,1.25,0,1,1,1.25-1.25A1.25,1.25,0,0,1,5.21,28Zm5.06-5.78a5,5,0,0,1-3.52-1.34l.86-1.06a4,4,0,0,0,2.71,1.11c1,0,1.55-.5,1.55-1.09s-.59-.91-1.91-1.22c-1.7-.4-2.89-.89-2.89-2.44s1.22-2.49,3-2.49a4.58,4.58,0,0,1,3.12,1.15l-.81,1.1A3.68,3.68,0,0,0,10,15a1.25,1.25,0,0,0-1.39,1.08c0,.67.61.91,1.92,1.21,1.72.39,2.87.94,2.87,2.44S12.24,22.22,10.27,22.22Zm7.51,0a5,5,0,0,1-3.52-1.34l.86-1.06a4,4,0,0,0,2.71,1.11c1,0,1.55-.5,1.55-1.09s-.59-.91-1.91-1.22c-1.7-.4-2.89-.89-2.89-2.44s1.23-2.49,3-2.49a4.56,4.56,0,0,1,3.12,1.15l-.81,1.1a3.68,3.68,0,0,0-2.37-1,1.25,1.25,0,0,0-1.39,1.08c0,.67.61.91,1.92,1.21,1.72.39,2.87.94,2.87,2.44S19.75,22.22,17.78,22.22Zm4.58-.14V13.84h2.9c2.72,0,4.64,1.71,4.64,4.12S28,22.08,25.26,22.08ZM30.69,28a1.25,1.25,0,1,1,1.25-1.25A1.25,1.25,0,0,1,30.69,28Zm0-17.5a1.25,1.25,0,1,1,1.25-1.25A1.25,1.25,0,0,1,30.69,10.5Z" class="clr-i-solid clr-i-solid-path-1"></path>
                                <path d="M23.86,15.2h1.56a2.77,2.77,0,1,1,0,5.53H23.86Z" class="clr-i-solid clr-i-solid-path-2"></path>
                            </svg>
                            <span>SSD's</span>
                        </a>
                    </li>
                    <!-- Item PLACAS DE VÍDEO -->
                    <li>
                        <a href="lista.php?tabela=lista_placa_video">
                            <span class="guia">└</span>
                            <svg class="icon" viewBox="0 0 60 60" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.604,41c-0.353-0.396-0.692-0.813-1.017-1.247c-1.9-2.188-3.155-5.362-3.489-8.88C20.028,30.118,20,29.548,20,29s0.028-1.118,0.09-1.794c0.343-3.597,1.598-6.771,3.543-9.016c0.304-0.407,0.629-0.806,0.971-1.19H17c-4.411,0-8,5.383-8,12s3.589,12,8,12H24.604z" />
                                <path d="M41.735,28.024c-0.079-0.15-0.185-0.283-0.299-0.408l-0.26-0.206c-0.153-0.122-0.326-0.215-0.506-0.285c-0.031-0.011-0.062-0.019-0.093-0.029c-0.107-0.036-0.218-0.052-0.329-0.07C40.166,27.015,40.085,27,40,27c-1.103,0-2,0.897-2,2c0,0.957,0.677,1.758,1.577,1.953c0.013,0.003,0.026,0.006,0.038,0.008C39.74,30.986,39.868,31,40,31c0.205,0,0.399-0.04,0.585-0.097l0.08-0.029c0.584-0.207,1.022-0.669,1.218-1.228c0.007-0.021,0.013-0.042,0.02-0.063l0.047-0.361c0.054-0.418-0.025-0.83-0.209-1.187C41.739,28.032,41.737,28.028,41.735,28.024z" />
                                <path d="M44.96,17h-9.92C30.224,18.993,27,23.791,27,29s3.224,10.007,8.04,12h9.92C49.776,39.007,53,34.209,53,29S49.776,18.993,44.96,17zM48.758,35.652l-0.347,0.403l-0.528-0.063c-1.399-0.165-2.881-0.746-4.156-1.379c0.386,0.672,0.848,1.222,1.286,1.591c0.464,0.392,0.683,1.001,0.569,1.591c-0.111,0.586-0.518,1.05-1.085,1.24c-1.361,0.457-3.296,1.001-4.778,1.001c-0.263,0-0.511-0.017-0.738-0.052l-0.525-0.081l-0.227-0.48c-0.63-1.334-0.924-2.989-1.054-4.458c-0.431,0.727-0.691,1.467-0.789,2.076c-0.131,0.815-0.817,1.408-1.634,1.408h-0.001c-0.385,0-0.76-0.14-1.057-0.394c-1.345-1.146-3.07-2.811-3.655-4.238l-0.201-0.492l0.295-0.442c0.948-1.42,2.497-2.677,3.833-3.591c-0.339-0.054-0.682-0.087-1.029-0.087c-0.627,0-1.237,0.091-1.765,0.261c-0.169,0.055-0.345,0.082-0.521,0.082c-0.512,0-0.986-0.229-1.303-0.629c-0.31-0.393-0.42-0.899-0.303-1.39c0.411-1.721,1.113-4.015,2.118-5.182l0.347-0.403l0.528,0.063c1.399,0.165,2.881,0.746,4.156,1.379c-0.386-0.672-0.848-1.222-1.286-1.591c-0.464-0.392-0.683-1.002-0.57-1.592c0.112-0.586,0.519-1.049,1.087-1.239c1.6-0.538,4-1.186,5.516-0.949l0.525,0.081l0.227,0.48c0.63,1.335,0.923,2.99,1.053,4.459c0.432-0.728,0.691-1.467,0.789-2.076c0.132-0.817,0.819-1.409,1.635-1.409c0.385,0,0.76,0.14,1.057,0.394c1.346,1.146,3.072,2.813,3.655,4.238l0.201,0.492l-0.295,0.442c-0.948,1.42-2.496,2.677-3.833,3.591c0.339,0.054,0.683,0.087,1.029,0.087c0.627,0,1.236-0.09,1.764-0.26c0.659-0.213,1.399,0.01,1.825,0.547c0.31,0.393,0.42,0.899,0.303,1.39C50.465,32.191,49.763,34.485,48.758,35.652z" />
                                <path d="M5,12V9c0-0.553-0.447-1-1-1H1C0.447,8,0,8.447,0,9s0.447,1,1,1h2v2v3H0v6h3v3H2c-0.553,0-1,0.447-1,1s0.447,1,1,1h1v1H0v15h3v1H2c-0.553,0-1,0.447-1,1s0.447,1,1,1h1v1v5c0,0.553,0.447,1,1,1s1-0.447,1-1v-5h6v4h26v-4h23V12H5zM3,40H2V29h1V40zM3,19H2v-2h1V19zM7,15c0.552,0,1,0.448,1,1s-0.448,1-1,1s-1-0.448-1-1S6.448,15,7,15zM7,43c-0.552,0-1-0.448-1-1s0.448-1,1-1s1,0.448,1,1S7.552,43,7,43zM7,29c0-7.72,4.486-14,10-14h12.796l-2.095,1.765c-0.91,0.767-1.755,1.668-2.512,2.68c-1.72,1.989-2.805,4.765-3.101,7.872C22.026,28.002,22,28.514,22,29s0.026,0.998,0.082,1.612c0.303,3.179,1.388,5.954,3.063,7.887c0.802,1.068,1.646,1.97,2.557,2.736L29.796,43H17C11.486,43,7,36.72,7,29zM35,48h-1v-1h-2v1h-1v-1h-2v1h-1v-1h-2v1h-1v-1h-2v1h-1v-1h-2v1h-1v-1h-2v1h-1v-1h-2v1h-1v-2h22V48zM45.523,42.93L45.346,43H34.654l-0.178-0.07C28.809,40.682,25,35.084,25,29s3.809-11.682,9.477-13.93L34.654,15h10.691l0.178,0.07C51.191,17.318,55,22.916,55,29S51.191,40.682,45.523,42.93zM56,43c-0.552,0-1-0.448-1-1s0.448-1,1-1s1,0.448,1,1S56.552,43,56,43zM56,17c-0.552,0-1-0.448-1-1s0.448-1,1-1s1,0.448,1,1S56.552,17,56,17z" />
                            </svg>
                            <span>Placas de Vídeo</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Item SOFTWARES -->
            <li role="menuitem" onclick="exibirSubmenu('sw')">
                <a class="nav-link PanelMenu1-effect" style="cursor:pointer;">
                    <svg class="icon" viewBox="0 0 201.928 201.928" xmlns="http://www.w3.org/2000/svg">
                        <path d="M58.401,141.893c0-38.617,31.418-70.035,70.035-70.035c8.248,0,16.164,1.444,23.52,4.075V30.25c0-2.761-2.238-5-5-5h-5.5V10h5.5c2.762,0,5-2.239,5-5c0-2.761-2.238-5-5-5h-128.5c-2.762,0-5,2.239-5,5v25.25v0.25v152c0,2.761,2.238,5,5,5h56.898C64.802,175.236,58.401,159.303,58.401,141.893z M23.456,10h108v15.25h-108V10z M128.437,81.858c-33.104,0-60.035,26.932-60.035,60.035c0,33.103,26.932,60.035,60.035,60.035c33.104,0,60.035-26.932,60.035-60.035C188.472,108.79,161.54,81.858,128.437,81.858z M128.437,171.251c-16.189,0-29.358-13.17-29.358-29.358c0-16.188,13.17-29.358,29.358-29.358c16.188,0,29.358,13.17,29.358,29.358C157.795,158.081,144.625,171.251,128.437,171.251zM128.437,122.535c-10.674,0-19.358,8.684-19.358,19.358s8.685,19.358,19.358,19.358c10.674,0,19.358-8.684,19.358-19.358S139.11,122.535,128.437,122.535z M128.437,149.9c-4.415,0-8.007-3.592-8.007-8.007c0-4.415,3.592-8.007,8.007-8.007c4.415,0,8.007,3.592,8.007,8.007C136.443,146.308,132.852,149.9,128.437,149.9z"/>
                    </svg>
                    <span>Softwares</span>
                    <svg id="expandir_sw" class="icon sub" fill="none" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z" />
                    </svg>
                </a>
                <!-- SUBMENU SOFTWARES -->
                <ul id="submenu_sw" class="submenu">
                    <!-- Item SO -->
                    <li>
                        <a href="lista.php?tabela=lista_so">
                            <span class="guia">├</span>
                            <svg class="icon" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="m 1.0184875,2.699001 4.8889092,-0.665819 0.00214,4.715749 -4.8865803,0.02783 z m 4.8865803,4.593276 0.00379,4.719858 -4.8865803,-0.671832 -2.74e-4,-4.079685 z M 6.497718,1.946081 12.980006,1 l 0,5.688955 -6.482288,0.05146 z M 12.981513,7.336663 12.980013,13 6.4977244,12.085098 6.4886444,7.32606 Z"/>
                            </svg>
                            <span>Sistemas Operacionais</span>
                        </a>
                    </li>
                    <!-- Item OFFICE -->
                    <li>
                        <a href="lista.php?tabela=lista_office">
                            <span class="guia">└</span>
                            <svg class="icon" viewBox="0 0 52 52" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6,40.6L6,40.6L6,40.6z"/>
                                <g>
	                                <line x1="6.1" y1="41" x2="6.1" y2="41"/>
	                                <path d="M6.1,41"/>
	                                <path d="M30.8,49.5c0.6,0.2,1.3,0.2,1.9,0l11.9-3.9c0.8-0.3,1.4-1,1.4-1.9v-36c0-0.6-0.4-1.2-1-1.4L32.9,2.2c-0.7-0.2-1.4-0.2-2,0L7,11.4c-0.6,0.2-1,0.8-1,1.4v27.1c0,0.6,0.4,1.2,1,1.4L30.8,49.5z M32,42.8c0,0.6-0.5,1.1-1,1l-20-2.7c-0.5-0.1-0.9-0.5-0.9-1v-0.4c0-0.4,0.2-0.7,0.7-0.9l3.8-1.8c0.4-0.2,0.6-0.5,0.6-0.9V14.8c0-0.5,0.3-0.9,0.8-1l15-3.4c0.6-0.1,1.2,0.3,1.2,1V42.8z"/>
                                </g>
                            </svg>
                            <span>Pacotes Office</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Item USUARIOS -->
            <?php
            if ($_SESSION['grupo'] == 1)
            {
                echo '<li role="menuitem">';
                echo '<a href="lista.php?tabela=users" class="nav-link PanelMenu1-effect"><svg class="icon" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg">';
                echo '<path fill-rule="evenodd" clip-rule="evenodd" d="M16 5.5C16 8.53757 13.5376 11 10.5 11H7V13H5V15L4 16H0V12L5.16351 6.83649C5.0567 6.40863 5 5.96094 5 5.5C5 2.46243 7.46243 0 10.5 0C13.5376 0 16 2.46243 16 5.5ZM13 4C13 4.55228 12.5523 5 12 5C11.4477 5 11 4.55228 11 4C11 3.44772 11.4477 3 12 3C12.5523 3 13 3.44772 13 4Z"/>';
                echo '</svg>';
                echo '<span>Usuários</span></a></li>';
            }
            ?>
            <!-- Item SAIR -->
            <li role="menuitem">
                <a href="#" class="nav-link PanelMenu1-effect" onclick="exibirOverlay('./overlay/logout_overlay.html')">
                    <svg class="icon" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M63 35 C63 34, 64 33, 64 32 L64 32 C64 31, 63 30, 63 29 L47 13 C46 12, 45 12, 44 12 C43 12, 42 12, 41 13 C40 14, 40 15, 40 16 C40 17, 40 18, 41 19 L50 28 L24 28 C22 28, 22 28, 21 29 C20 30, 20 31, 20 32 C20 33, 20 34, 21 35 C22 36, 22 36, 24 36 L50 36 L41 45 C40 46, 40 47, 40 48 C40 49, 40 50, 41 51 C42 52, 43 52, 44 52 C45 52, 46 52, 47 51 L63 35Z  M20 12 C21 12, 22 12, 23 11 L23 11 C23 10, 24 9, 24 8 C24 7, 23 6, 23 5 C22 4, 21 4, 20 4 L12 4 C8 4, 5 5, 3 8 C1 10, 0 13, 0 16 L0 48 C0 51, 1 54, 3 57 C5 59, 8 60, 12 60 L20 60 C21 60, 22 60, 23 59 C23 58, 24 57, 24 56 C24 55, 23 54, 23 53 C22 52, 21 52, 20 52 L12 52 C10 52, 10 52, 9 51 C8 50, 8 49, 8 48 L8 16 C8 15, 8 14, 9 13 C10 12, 10 12, 12 12 L20 12Z " />
                    </svg>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- FIM DO MENU -->
</nav>