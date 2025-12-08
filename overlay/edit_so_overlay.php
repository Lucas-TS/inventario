<div id="bloco-overlay" class="bloco-overlay" style="width:610px">
    <form name="edit_so_form" method="post" accept-charset="UTF-8" id="edit_so_form" onsubmit="editarSo(event)">
        <div class="header">
            <span>Editar Sistema Operacional</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200); document.getElementById('overlay').innerHTML = '';"<?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-so-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-so-1" class="b-line"><label class="label" for="id-edit-so">ID:</label>
                <input id="id-edit-so" name="id-edit-so" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-so-2" class="b-line">
                <input type="checkbox" id="ativo-edit-so" class="checkbox" value="1">
                <label for="ativo-edit-so"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-so-2" class="h-line">Informações básicas:</div>
            <div id="b-line-edit-so-3" class="b-line" style="flex-basis:100%"><span class="label">Kernel:</span>
                <input type="radio" id="edit-windows" name="knl-edit-so" class="radio" value="Windows" required onclick="selecionaWindows()">
                <label for="edit-windows"><span></span>Windows</label>
                <input type="radio" id="edit-linux" name="knl-edit-so" class="radio" value="Linux" onclick="selecionaLinux()">
                <label for="edit-linux"><span></span>Linux</label>
                <!--<input type="radio" id="outro" name="knl-edit-so" class="radio" value="modelo" onclick="selecionaOutro()">
                <label for="outro"><span></span>Outro:
                <input id="outro-edit-so" class="input" type="text" name="outro-edit-so" disabled placeholder="Digite o nome do kernel" style="width:calc(100% - 12px)"></label>-->
            </div>
        </div>
        <div id="linha-3" class="linha">

        </div>
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-so-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-so-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>