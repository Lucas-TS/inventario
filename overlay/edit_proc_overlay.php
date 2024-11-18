<div id="bloco-overlay" class="bloco-overlay">
    <form name="edit_proc_form" method="post" accept-charset="UTF-8" id="add_proc_form" onsubmit="editarProc(event)">
        <div class="header">
            <span>Editar Processador</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-proc-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-proc-1" class="b-line"><label class="label" for="id-edit-proc">ID:</label>
                <input id="id-edit-proc" name="id-edit-proc" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-2" class="b-line">
                <input type="checkbox" id="ativo-edit-proc" class="checkbox" value="1">
                <label for="ativo-edit-proc"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-proc-2" class="h-line">Informações básicas:</div>
            <div id="b-line-edit-proc-3" class="b-line"><label for="marca-edit-proc" class="label">Marca:</label>
                <input id="marca-edit-proc" name="marca-edit-proc" type="text" class="input fixedBox" placeholder="Escolha a marca" style="width:250px" readonly required title="Selecione na lista">
                <div id="suggestions-marca-edit-proc" class="suggestions-box marca-edit-proc">
                    <p id="p1" onclick="passarValor(1,'marca-edit-proc','');">AMD</p>
                    <p id="p2" onclick="passarValor(2,'marca-edit-proc','');">Intel</p>
                </div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-4" class="b-line"><label for="modelo-edit-proc" class="label">Modelo:</label>
                <input id="modelo-edit-proc" name="modelo-edit-proc" type="text" class="input" placeholder="Digite o modelo" style="width:250px" required title="Ex.: Core i5-12400, Ryzen 3 2200G">
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-edit-proc-3" class="h-line">Informações complementares:</div>
            <div id="b-line-edit-proc-5" class="b-line"><label for="ger-edit-proc" class="label">Geração:</label>
                <input id="ger-edit-proc" name="ger-edit-proc" type="number" class="input" placeholder="" style="width:100px" title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-6" class="b-line"><label for="skt-edit-proc" class="label">Socket:</label>
                <input id="skt-edit-proc" name="skt-edit-proc" type="text" class="input box" placeholder="" style="width:100px" required title="Ex.: AM4, AM5, LGA 1155, LGA 1200">
                <div id="suggestions-skt-edit-proc" class="suggestions-box skt-edit-proc"></div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-7" class="b-line"><label for="seg-edit-proc" class="label">Seguimento:</label>
                <input id="seg-edit-proc" name="seg-edit-proc" type="text" class="input fixedBox" placeholder="Escolha" style="width:150px" readonly required title="Selecione na lista">
                <div id="suggestions-seg-edit-proc" class="suggestions-box seg-edit-proc">
                    <p id="p1" onclick="passarValor(1,'seg-edit-proc','');">Desktop</p>
                    <p id="p2" onclick="passarValor(2,'seg-edit-proc','');">Notebook</p>
                    <p id="p3" onclick="passarValor(3,'seg-edit-proc','');">Servidor</p>
                </div>
            </div>
        </div>
        <div id="linha-43" class="linha">
            <div id="h-line-edit-proc-4" class="h-line">Núcleos:</div>
            <div id="b-line-edit-proc-8" class="b-line"><label for="pcores-edit-proc" class="label">P-Cores:</label>
                <input id="pcores-edit-proc" name="pcores-edit-proc" type="number" class="input" placeholder="" style="width:100px" required title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-9" class="b-line"><label for="ecores-edit-proc" class="label">E-Cores:</label>
                <input id="ecores-edit-proc" name="ecores-edit-proc" type="number" class="input" placeholder="" style="width:100px" title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-10" class="b-line"><label for="threads-edit-proc" class="label">Threads:</label>
                <input id="threads-edit-proc" name="threads-edit-proc" type="number" class="input" placeholder="" style="width:100px" required title="Somente número. Ex.: 1, 2, 3, ...">
            </div>
        </div>
        <div id="linha-5" class="linha">
            <div id="h-line-edit-proc-5" class="h-line">Clock:</div>
            <div id="b-line-edit-proc-11" class="b-line"><label for="clock-edit-proc" class="label">Base:</label>
                <input id="clock-edit-proc" name="clock-edit-proc" type="text" class="input" placeholder="" style="width:100px" required title="Somente números com duas casas decimais. Ex.: 150 -> 1.50, 233 -> 2.33, 320 -> 3.20, ...">
                <span style="color:#AAAAAA">&nbsp;Ghz</span>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-proc-12" class="b-line"><label for="turbo-edit-proc" class="label">Máximo (turbo):</label>
                <input id="turbo-edit-proc" name="turbo-edit-proc" type="text" class="input" placeholder="" style="width:100px" title="Somente números com duas casas decimais. Ex.: 366 -> 3.66, 280 -> 2.80, 470 -> 4.70, ...">
                <span style="color:#AAAAAA">&nbsp;Ghz</span>
            </div>
            <div id="h-spacer"></div>
        </div>
        <div id="linha-6" class="linha">
            <div id="h-line-edit-proc-6" class="h-line">Memórias:</div>
            <div id="b-line-edit-proc-13" class="b-line"><span class="label">Tipos:</span>
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
        <div id="linha-7" class="linha">
            <div id="h-line-edit-proc-7" class="h-line">Placa de vídeo:</div>
            <div id="b-line-edit-proc-14" class="b-line">
                <input type="radio" id="off-edit-proc" name="igpu" class="radio" value="0" onclick="desativaModeloIGPU()">
                <label for="off-edit-proc"><span></span>Sem placa de vídeo</label>
                <input type="radio" id="igpu-edit-proc" name="igpu" class="radio" value="modelo" onclick="liberaModeloIGPU()">
                <label for="igpu-edit-proc"><span></span>iGPU:
                <input id="modelo-igpu-edit-proc" class="input box" type="text" name="modelo-igpu-edit-proc" disabled placeholder="Digite o modelo" style="width:250px"></label>
                <div id="suggestions-modelo-igpu-edit-proc" class="suggestions-box modelo-igpu-edit-proc"></div>
            </div>
        </div>
        <div id="linha-8" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-proc-19" class="b-line">
                    <button id="limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-proc-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>