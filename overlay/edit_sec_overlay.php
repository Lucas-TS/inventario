<div id="bloco-overlay" class="bloco-overlay" style="width:850px">
    <form name="add_sec_form" method="post" accept-charset="UTF-8" id="add_sec_form" onsubmit="editarSec(event)">
        <div class="header">
            <span>Adicionar Seção</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-sec-1" class="h-line">Informações:</div>
            <div id="b-line-add-sec-1" class="b-line"><label class="label" for="sigla-add-sec">Sigla:</label>
                <input id="sigla-add-sec" name="sigla-add-sec" type="text" class="input" placeholder="Digite a sigla" style="width:150px" required title="Ex.: STIC, SECOD, DP, DAEC">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-sec-2" class="b-line" style="flex:1"><label class="label" for="nome-add-sec">Nome completo:</label>
                <input id="nome-add-sec" name="nome-add-sec" type="text" class="input" placeholder="Digite o nome completo da seção" style="width:100%" required title="Nome da seção">
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-sec-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-sec-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>