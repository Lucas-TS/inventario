<div id="bloco-overlay" class="bloco-overlay">
    <form name="add_proc_form" method="post" accept-charset="UTF-8" id="add_proc_form" onsubmit="insertProc(event)">
        <div class="header">
            <span>Adicionar Processador</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-proc-1" class="h-line">Informações básicas:</div>
            <div id="b-line-add-proc-1" class="b-line"><label class="label" for="marca">Marca:</label>
                <input id="marca-proc" name="marca" type="text" class="input fixedBox" placeholder="Escolha a marca" style="width:250px" readonly required title="Selecione na lista">
                <div id="suggestions-marca-proc" class="suggestions-box marca-proc">
                    <p id="p1" onclick="passarValor(1,'marca-proc','');">AMD</p>
                    <p id="p2" onclick="passarValor(2,'marca-proc','');">Intel</p>
                </div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-2" class="b-line"><label class="label">Modelo:</label>
                <input id="modelo-proc" name="modelo" type="text" class="input" placeholder="Digite o modelo" style="width:250px" required title="Ex.: Core i5-12400, Ryzen 3 2200G">
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-proc-2" class="h-line">Informações complementares:</div>
            <div id="b-line-add-proc-3" class="b-line"><label class="label">Geração:</label>
                <input id="ger-proc" name="ger" type="number" class="input" placeholder="" style="width:100px" title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-4" class="b-line"><label class="label">Socket:</label>
                <input id="skt-proc" name="skt" type="text" class="input box" placeholder="" style="width:100px" required title="Ex.: AM4, AM5, LGA 1155, LGA 1200">
                <div id="suggestions-skt-proc" class="suggestions-box skt-proc"></div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-5" class="b-line"><label class="label">Seguimento:</label>
                <input id="seg-proc" name="seg" type="text" class="input fixedBox" placeholder="Escolha" style="width:150px" readonly required title="Selecione na lista">
                <div id="suggestions-seg-proc" class="suggestions-box seg-proc">
                    <p id="p1" onclick="passarValor(1,'seg-proc','');">Desktop</p>
                    <p id="p2" onclick="passarValor(2,'seg-proc','');">Notebook</p>
                    <p id="p3" onclick="passarValor(3,'seg-proc','');">Servidor</p>
                </div>
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-add-proc-3" class="h-line">Núcleos:</div>
            <div id="b-line-add-proc-6" class="b-line"><label class="label">P-Cores:</label>
                <input id="pcores-proc" name="pcores" type="number" class="input" placeholder="" style="width:100px" required title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-7" class="b-line"><label class="label">E-Cores:</label>
                <input id="ecores-proc" name="ecores" type="number" class="input" placeholder="" style="width:100px" title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-8" class="b-line"><label class="label">Threads:</label>
                <input id="threads-proc" name="threads" type="number" class="input" placeholder="" style="width:100px" required title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
        </div>
        <div id="linha-4" class="linha">
            <div id="h-line-add-proc-4" class="h-line">Clock:</div>
            <div id="b-line-add-proc-9" class="b-line"><label class="label">Base:</label>
                <input id="clock-proc" name="clock" type="text" class="input" placeholder="" style="width:100px" required title="Somente números com duas casas decimais. Ex.: 150 -> 1.50, 233 -> 2.33, 320 -> 3.20, ...">
                <span style="color:#AAAAAA">&nbsp;Ghz</span>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-10" class="b-line"><label class="label">Máximo (turbo):</label>
                <input id="turbo-proc" name="turbo" type="text" class="input" placeholder="" style="width:100px" title="Somente números com duas casas decimais. Ex.: 366 -> 3.66, 280 -> 2.80, 470 -> 4.70, ...">
                <span style="color:#AAAAAA">&nbsp;Ghz</span>
            </div>
            <div id="h-spacer"></div>
        </div>
        <div id="linha-5" class="linha">
            <div id="h-line-add-proc-5" class="h-line">Memórias:</div>
            <div id="b-line-add-proc-11" class="b-line"><label class="label">Tipos:</label>
                <input type="checkbox" id="DDR" class="checkbox" value="DDR">
                <label for="DDR"><span></span> DDR</label>
                <input type="checkbox" id="DDR2" class="checkbox" value="DDR2">
                <label for="DDR2"><span></span> DDR2</label>
                <input type="checkbox" id="DDR3" class="checkbox" value="DDR3">
                <label for="DDR3"><span></span> DDR3</label>
                <input type="checkbox" id="DDR4" class="checkbox" value="DDR4">
                <label for="DDR4"><span></span> DDR4</label>
                <input type="checkbox" id="DDR5" class="checkbox" value="DDR5">
                <label for="DDR5"><span></span> DDR5</label>
            </div>
        </div>
        <div id="linha-6" class="linha">
            <div id="h-line-add-proc-6" class="h-line">Placa de vídeo:</div>
            <div id="b-line-add-proc-11" class="b-line">
                <input type="radio" id="off-proc" name="igpu" class="radio" value="0" onclick="desativaModeloIGPU()">
                <label for="off-proc"><span></span>Sem placa de vídeo</label>
                <input type="radio" id="igpu-proc" name="igpu" class="radio" value="modelo" onclick="liberaModeloIGPU()">
                <label for="igpu-proc"><span></span>iGPU:
                <input id="modelo-igpu-proc" class="input box" type="text" name="modelo-igpu-proc" disabled placeholder="Digite o modelo" style="width:250px"></label>
                <div id="suggestions-modelo-igpu-proc" class="suggestions-box modelo-igpu-proc"></div>
            </div>
        </div>
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-proc-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-proc-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>