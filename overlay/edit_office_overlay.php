<div id="bloco-overlay" class="bloco-overlay" style="width:610px">
    <form name="edit_office_form" method="post" accept-charset="UTF-8" id="edit_office_form" onsubmit="editarOffice(event)">
        <div class="header">
            <span>Editar Pacote Office</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-office-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-office-1" class="b-line"><label class="label" for="id-edit-office">ID:</label>
                <input id="id-edit-office" name="id-edit-office" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-office-2" class="b-line">
                <input type="checkbox" id="ativo-edit-office" class="checkbox" value="1">
                <label for="ativo-edit-office"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-office-2" class="h-line">Informações básicas:</div>
            <div id="b-line-edit-office-3" class="b-line" style="flex-basis:100%"><span class="label">Pacote:</span>
                <input type="radio" id="office" name="pct-edit-office" class="radio" value="Office" required onclick="selecionaOffice()">
                <label for="office"><span></span>Microsoft Office</label>
                <input type="radio" id="free" name="pct-edit-office" class="radio" value="Free" onclick="selecionaFree()">
                <label for="free"><span></span>Gratuito:
                <input id="nome-edit-office" class="input box" type="text" name="free-edit-office" disabled placeholder="Digite o nome do pacote" style="width:calc(100% - 15px)"></label>
            </div>
        </div>
        <div id="linha-3" class="linha">

        </div>
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-office-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-office-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>