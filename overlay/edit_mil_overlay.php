<div id="bloco-overlay" class="bloco-overlay" style="width:850px">
    <form name="edit_mil_form" method="post" accept-charset="UTF-8" id="edit_mil_form" onsubmit="editarMil(event)">
        <div class="header">
            <span>Editar Militar</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-mil-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-mil-2" class="b-line"><label class="label" for="id-edit-mil">ID:</label>
                <input id="id-edit-mil" name="id-edit-mil" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mil-2" class="b-line">
                <input type="checkbox" id="ativo-edit-mil" class="checkbox" value="1">
                <label for="ativo-edit-mil"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-mil-2" class="h-line">Informações pessoais:</div>
            <div id="b-line-edit-mil-3" class="b-line" style="width:100%"><label class="label" for="nc-edit-mil">Nome completo:</label>
                <input id="nc-edit-mil" name="nc-edit-mil" type="text" class="input" placeholder="Digite o nome completo" style="width:100%" required title="Nome completo">
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-edit-mil-3" class="h-line">Informações complementares:</div>
            <div id="b-line-edit-mil-4" class="b-line"><label class="label" for="pg-edit-mil">Posto/Graduação:</label>
                <input id="pg-edit-mil" name="pg-edit-mil" type="text" class="input openBox" placeholder="Escolha" style="width:250px" required title="Ex.: Capitão, Major, 3º Sargento">
                <div id="suggestions-pg-edit-mil" class="suggestions-box pg-add-mil">
                </div>
                <input id="hidden-pg-edit-mil" name="hidden-pg-edit-mil" type="hidden" value="">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mil-5" class="b-line" style="flex:1"><label class="label" for="ng-edit-mil">Nome de guerra:</label>
                <input id="ng-edit-mil" name="ng-edit-mil" type="text" class="input box" placeholder="Digite o nome de guerra" style="width:100%" required title="Nome de guerra">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-edit-mil-6" class="b-line" style="width:100%"><label class="label" for="sec-edit-mil">Seção:</label>
                <input id="sec-edit-mil" name="sec-edit-mil" type="text" class="input openBox" placeholder="Escolha" style="width:100%" required title="Ex.: STIC, DEP, SCP, SECOD">
                <div id="suggestions-sec-edit-mil" class="suggestions-box sec-add-mil">
                </div>
                <input id="hidden-sec-edit-mil" name="hidden-sec-edit-mil" type="hidden" value="">
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-mil-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-mil-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>