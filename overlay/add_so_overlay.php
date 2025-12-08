<div id="bloco-overlay" class="bloco-overlay" style="width:610px">
    <form name="add_so_form" method="post" accept-charset="UTF-8" id="add_so_form" onsubmit="insertSO(event)">
        <div class="header">
            <span>Adicionar Sistema Operacional</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200); document.getElementById('overlay').innerHTML = '';"<?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-so-1" class="h-line">Informações básicas:</div>
            <div id="b-line-add-so-1" class="b-line" style="flex-basis:100%"><span class="label">Kernel:</span>
                <input type="radio" id="add-windows" name="knl-add-so" class="radio" value="Windows" checked required onclick="selecionaWindows()">
                <label for="add-windows"><span></span>Windows</label>
                <input type="radio" id="add-linux" name="knl-add-so" class="radio" value="Linux" onclick="selecionaLinux()">
                <label for="add-linux"><span></span>Linux</label>
                <!--<input type="radio" id="outro" name="knl-add-so" class="radio" value="modelo" onclick="selecionaOutro()">
                <label for="outro"><span></span>Outro:
                <input id="outro-add-so" class="input" type="text" name="outro-add-so" disabled placeholder="Digite o nome do kernel" style="width:calc(100% - 12px)"></label>-->
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-so-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-add-so-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-so">Versão:</label>
                <input id="ver-add-so" class="input" type="text" name="ver-add-so" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-add-so-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-so">Edição:</label>
                <input id="ed-add-so" class="input" type="text" name="ed-add-so" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
            <div id="b-line-add-so-4" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-add-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-add-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        </div>
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-so-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-so-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>