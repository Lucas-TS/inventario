<div id="bloco-overlay" class="bloco-overlay" style="width:850px">
    <form name="add_mil_form" method="post" accept-charset="UTF-8" id="add_mil_form" onsubmit="insertMil(event)">
        <div class="header">
            <span>Adicionar Militar</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200); document.getElementById('overlay').innerHTML = '';"<?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-mil-1" class="h-line">Informações pessoais:</div>
            <div id="b-line-add-mil-1" class="b-line" style="width:100%"><label class="label" for="nc-add-mil">Nome completo:</label>
                <input id="nc-add-mil" name="nc-add-mil" type="text" class="input" placeholder="Digite o nome completo" style="width:100%" required title="Nome completo">
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-mil-2" class="h-line">Informações complementares:</div>
            <div id="b-line-add-mil-2" class="b-line"><label class="label" for="pg-add-mil">Posto/Graduação:</label>
                <input id="pg-add-mil" name="pg-add-mil" type="text" class="input openBox" placeholder="Escolha" style="width:250px" required title="Ex.: Capitão, Major, 3º Sargento">
                <div id="suggestions-pg-add-mil" class="suggestions-box pg-add-mil">
                </div>
                <input id="hidden-pg-add-mil" name="hidden-pg-add-mil" type="hidden" value="">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-mil-3" class="b-line" style="flex:1"><label class="label" for="ng-add-mil">Nome de guerra:</label>
                <input id="ng-add-mil" name="ng-add-mil" type="text" class="input box" placeholder="Digite o nome de guerra" style="width:100%" required title="Nome de guerra">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-add-mil-4" class="b-line" style="width:100%"><label class="label" for="sec-add-mil">Seção:</label>
                <input id="sec-add-mil" name="sec-add-mil" type="text" class="input openBox" placeholder="Escolha" style="width:100%" required title="Ex.: STIC, DEP, SCP, SECOD">
                <div id="suggestions-sec-add-mil" class="suggestions-box sec-add-mil">
                </div>
                <input id="hidden-sec-add-mil" name="hidden-sec-add-mil" type="hidden" value="">
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-mil-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-mil-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>