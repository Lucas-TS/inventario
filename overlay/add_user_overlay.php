<div id="bloco-overlay" class="bloco-overlay" style="width:600px">
    <form name="add_user_form" method="post" accept-charset="UTF-8" id="add_user_form" onsubmit="insertUser(event)">
        <div class="header">
            <span>Adicionar Usuário</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-user-1" class="h-line">Informações pessoais:</div>
            <div id="b-line-add-user-1" class="b-line" style="width:100%"><label class="label" for="nc-add-user">Nome completo:</label>
                <input id="nc-add-user" name="nc-add-user" type="text" class="input" placeholder="Digite o nome completo" style="width:100%" required title="Nome completo">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-add-user-2" class="b-line"><label class="label" for="email-add-user">Email:</label>
                <input id="email-add-user" name="email-add-user" type="text" class="input" placeholder="Digite o email" style="width:400px" required title="Email">
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-user-2" class="h-line">Informações de acesso:</div>
            <div id="b-line-add-user-3" class="b-line"><label class="label" for="user-add-user">Usuário:</label>
                <input id="user-add-user" name="user-add-user" type="text" class="input" placeholder="Usuário" style="width:200px" required title="Nome completo">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-add-user-4" class="b-line"><label class="label" for="pw-add-user">Senha:</label>
                <input id="pw-add-user" name="pw-add-user" type="password" class="input" placeholder="Senha" style="width:200px" required title="Email">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-user-5" class="b-line"><label class="label" for="pw2-add-user">Confirmar senha:</label>
                <input id="pw2-add-user" name="pw2-add-user" type="password" class="input" placeholder="Confirmar senha" style="width:200px" required title="Email">
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-add-user-3" class="h-line">Avatar:</div>
            <div id="b-line-add-user-6" class="b-line" style="height:fit-content;align-items:center;">
                <div>
                    <img id="avatar-preview" class="avatar-preview" src="./images/avatar.png">
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="loadFile(event)" style="display: none;">
                </div>
                <div id="gallery" class="gallery">
                    <img src="./images/avatar.png" onclick="selectImage(this)" class="gallery-item" id="avatar1">
                    <img src="./images/avatar2.png" onclick="selectImage(this)" class="gallery-item" id="avatar2">
                    <img src="./images/avatar3.png" onclick="selectImage(this)" class="gallery-item" id="avatar3">
                    <img src="./images/avatar4.png" onclick="selectImage(this)" class="gallery-item" id="avatar4">
                    <img src="./images/avatar5.png" onclick="selectImage(this)" class="gallery-item" id="avatar5">
                    <img src="./images/add.avatar.svg" id="add-avatar-button" onclick="document.getElementById('avatar').click();" class="gallery-item">
                </div>
                <input type="hidden" id="selected-avatar" name="selected-avatar" value="">
            </div>
        </div>
        <div id="linha-4" class="linha">
            <div id="h-line-add-user-4" class="h-line">Grupo:</div>
            <div id="b-line-add-user-7" class="b-line">
                <input id="gp-add-user" class="input openBox" type="text" name="gp-add-user" placeholder="Escolha o grupo" required style="width:250px">
                <div id="suggestions-gp-add-user" class="suggestions-box gp-add-user">
                    <p id="p0" onclick="passarValor('0', 'gp-add-user', '0')">Usuários</p>
                    <p id="p1" onclick="passarValor('1', 'gp-add-user', '1')">Administradores</p>
                </div>
                <input id="hidden-gp-add-user" name="hidden-gp-add-user" type="hidden" value="">
            </div>
        </div>
        <div id="linha-5" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-user-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-user-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>