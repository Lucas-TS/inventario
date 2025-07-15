<div id="bloco-overlay" class="bloco-overlay" style="width:700px">
    <form name="edit_mon_form" method="post" accept-charset="UTF-8" id="edit_mon_form" onsubmit="editarMon(event)">
        <div class="header">
            <span>Editar Monitor</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200); document.getElementById('overlay').innerHTML = '';"<?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-mon-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-mon-1" class="b-line"><label class="label" for="id-edit-mon">ID:</label>
                <input id="id-edit-mon" name="id-edit-mon" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-2" class="b-line">
                <input type="checkbox" id="ativo-edit-mon" class="checkbox" value="1">
                <label for="ativo-edit-mon"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-mon-2" class="h-line">Informações básicas:</div>
            <div id="b-line-edit-mon-3" class="b-line"><label class="label" for="marca-edit-mon">Marca:</label>
                <input id="marca-edit-mon" name="marca-edit-mon" type="text" class="input box" placeholder="Escolha ou digite a marca" style="width:250px" required title="Selecione na lista ou digite uma nova">
                <div id="suggestions-marca-edit-mon" class="suggestions-box marca-edit-mon">
                </div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-4" class="b-line"><label class="label" for="modelo-edit-mon">Modelo:</label>
                <input id="modelo-edit-mon" name="modelo-edit-mon" type="text" class="input" placeholder="Digite o modelo" style="width:250px" required title="Ex.: SyncMaster 540B, E970swn, E2270swn, FLATRON W1943C">
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-edit-mon-3" class="h-line">Tela:</div>
            <div id="b-line-edit-mon-5" class="b-line"><label class="label" for="tam-edit-mon">Tamanho:</label>
                <input id="tam-edit-mon" name="tam-edit-mon" type="text" class="input" placeholder="Digite" style="width:100px" title="Somente números com uma casa decimal. Ex.: 150 -> 15.0, 238 -> 23.8, 185 -> 18.5, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-6" class="b-line"><label class="label" for="resh-edit-mon">Resolução:</label>
                <input id="resh-edit-mon" name="resh-edit-mon" type="number" class="input" placeholder="Horizontal" style="width:100px" required title="Somente números (normalmente o maior)
Ex.: 1024, 1280, 1920, 1440, ...">
                <label class="label" for="resv-edit-mon">&nbsp;X&nbsp;</label>
                <input id="resv-edit-mon" name="resv-edit-mon" type="number" class="input" placeholder="Vertical" style="width:100px" required title="Somente números (normalmente o menor)
Ex.: 768, 720, 1080, 900, ...">
            </div>
        </div>
        <div id="linha-4" class="linha" style="justify-content:space-between">
            <div id="h-line-edit-mon-4" class="h-line">Conexões:</div>
            <div id="b-line-edit-mon-7" class="b-line"><label class="label" for="qtde-hdmi">HDMI:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-hdmi" type="number" title="Numero de portas HDMI" name="qtde-hdmi" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-8" class="b-line"><label class="label" for="qtde-dp">DisplayPort:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-dp" type="number" title="Numero de portas DP" name="qtde-dp" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-9" class="b-line"><label class="label" for="qtde-dvi">DVI:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-dvi" type="number" title="Numero de portas DVI" name="qtde-dvi" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
            
            <div id="b-line-edit-mon-10" class="b-line"><label class="label" for="qtde-vga">VGA:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-vga" type="number" title="Numero de portas VGA" name="qtde-vga" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-11" class="b-line"><label class="label" for="qtde-usb">USB:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-usb" type="number" title="Numero de portas USB" name="qtde-usb" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-mon-12" class="b-line"><label class="label" for="qtde-p2">P2:</label>
                <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'saude')"><?php include '../images/menos.svg'; ?></button>
                <input id="qtde-p2" type="number" title="Numero de portas P2 (áudio)" name="qtde-p2" data-tipo="saude" class="conexoes input" placeholder='Quantidade' value="0" style="width:59px;text-align:center;"><span></span>
                <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'saude')"><?php include '../images/add.svg'; ?></button>
            </div>
        </div>
        <div id="linha-5" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-mon-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-mon-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>