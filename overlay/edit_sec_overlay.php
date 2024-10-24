<div id="bloco-overlay" class="bloco-overlay" style="width:850px">
    <form name="edit_sec_form" method="post" accept-charset="UTF-8" id="edit_sec_form" onsubmit="editarSec(event)">
        <div class="header">
            <span>Editar Seção</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-sec-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-sec-2" class="b-line"><label class="label" for="id-edit-sec">ID:</label>
                <input id="id-edit-sec" name="id-edit-sec" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-sec-2" class="b-line">
                <input type="checkbox" id="ativo-edit-sec" class="checkbox" value="1">
                <label for="ativo-edit-sec"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-sec-3" class="h-line">Informações básicas:</div>
            <div id="b-line-edit-sec-4" class="b-line"><label class="label" for="sigla-edit-sec">Sigla:</label>
                <input id="sigla-edit-sec" name="sigla-edit-sec" type="text" class="input" placeholder="Digite a sigla" style="width:150px" required title="Ex.: STIC, SECOD, DP, DAEC">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-sec-5" class="b-line" style="flex:1"><label class="label" for="nome-edit-sec">Nome completo:</label>
                <input id="nome-edit-sec" name="nome-edit-sec" type="text" class="input" placeholder="Digite o nome completo da seção" style="width:100%" required title="Nome da seção">
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-sec-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-sec-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>