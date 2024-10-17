<div id="bloco-overlay" class="bloco-overlay" style="width:610px">
    <form name="add_office_form" method="post" accept-charset="UTF-8" id="add_office_form" onsubmit="insertOffice(event)">
        <div class="header">
            <span>Adicionar Pacote Office</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-office-1" class="h-line">Informações básicas:</div>
            <div id="b-line-add-office-1" class="b-line" style="flex-basis:100%"><span class="label">Pacote:</span>
                <input type="radio" id="office" name="pct-add-office" class="radio" value="Office" checked required onclick="selecionaOffice()">
                <label for="office"><span></span>Microsoft Office</label>
                <input type="radio" id="free" name="pct-add-office" class="radio" value="Free" onclick="selecionaFree()">
                <label for="free"><span></span>Gratuito:
                <input id="nome-add-office" class="input box" type="text" name="free-add-office" disabled placeholder="Digite o nome do pacote" style="width:calc(100% - 15px)"></label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-office-2" class="h-line">Informações do pacote:</div>
            <div id="b-line-add-office-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-office">Versão:</label>
                <input id="ver-add-office" class="input" type="text" name="ver-add-office" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-add-office-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-office">Edição:</label>
                <input id="ed-add-office" class="input" type="text" name="ed-add-office" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
        </div>
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-office-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-office-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>