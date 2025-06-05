<div id="bloco-overlay" class="bloco-overlay" style="width:600px">
    <form name="edit_user_form" method="post" accept-charset="UTF-8" id="edit_user_form" onsubmit="editarUser(event)">
        <div class="header">
            <span>Adicionar Usuário</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-user-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-user-1" class="b-line"><label class="label" for="id-edit-user">ID:</label>
                <input id="id-edit-user" name="id-edit-user" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-user-2" class="b-line">
                <input type="checkbox" id="ativo-edit-user" class="checkbox" value="1">
                <label for="ativo-edit-user"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-user-2" class="h-line">Informações pessoais:</div>
            <div id="b-line-edit-user-3" class="b-line" style="width:100%"><label class="label" for="nc-edit-user">Nome completo:</label>
                <input id="nc-edit-user" name="nc-edit-user" type="text" class="input" placeholder="Digite o nome completo" autocomplete="fullname" style="width:100%" required title="Nome completo">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-edit-user-4" class="b-line"><label class="label" for="email-edit-user">Email:</label>
                <input id="email-edit-user" name="email-edit-user" type="text" class="input" placeholder="Digite o email" autocomplete="email" style="width:400px" required title="Email">
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-edit-user-3" class="h-line">Informações de acesso:</div>
            <div id="b-line-edit-user-5" class="b-line"><label class="label" for="user-edit-user">Usuário:</label>
                <input id="user-edit-user" name="user-edit-user" type="text" class="input" placeholder="Usuário" autocomplete="username" style="width:200px" required readonly title="Nome completo">
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-edit-user-6" class="b-line"><label class="label" for="pw-edit-user">Nova senha:</label>
                <input id="pw-edit-user" name="pw-edit-user" type="password" class="input" placeholder="Nova senha" autocomplete="new-password" style="width:200px" title="Email">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-user-7" class="b-line"><label class="label" for="pw2-edit-user">Confirmar nova senha:</label>
                <input id="pw2-edit-user" name="pw2-edit-user" type="password" class="input" placeholder="Confirmar nova senha" autocomplete="new-password" style="width:200px" title="Email">
            </div>
        </div>
        <div id="linha-4" class="linha">
            <div id="h-line-edit-user-4" class="h-line">Avatar:</div>
            <div id="b-line-edit-user-8" class="b-line" style="height:fit-content;align-items:center;">
                <div>
                    <img id="avatar-preview" class="avatar-preview" src="./images/avatar.png">
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="loadFile(event)" style="display: none;">
                </div>
                <div id="gallery" class="gallery">
                    <div id="gallery-left" class="gallery-left" onclick="scrollGallery(-1)">
                        <a class="gallery-arrow""><?php include '../images/seta.svg'; ?></a>
                    </div>
                    <div id="gallery-list" class="gallery-list">
                    <?php
                    $imagesDir = '../images/';
                    $images = glob($imagesDir . 'avatar*.png'); // Filtra os arquivos seguindo o padrão avatar#.png
                    foreach ($images as $index => $image) {
                        echo '<img src="' . str_replace('../', './', $image) . '" onclick="selectImage(this)" class="gallery-item" id="avatar' . ($index + 1) . '">';
                    }
                    ?>
                    </div>
                    <div id="gallery-right" class="gallery-right" onclick="scrollGallery(1)">
                        <a class="gallery-arrow"><?php include '../images/seta.svg'; ?></a>
                    </div>
                    <div style="width:17px"></div>
                    <img src="./images/add.avatar.svg" id="add-avatar-button" onclick="document.getElementById('avatar').click();" class="gallery-item">
                </div>
                <input type="hidden" id="selected-avatar" name="selected-avatar" value="">
            </div>
        </div>
        <div id="linha-5" class="linha">
            <div id="h-line-edit-user-5" class="h-line">Grupo:</div>
            <div id="b-line-edit-user-9" class="b-line">
                <input id="gp-edit-user" class="input openBox" type="text" name="gp-edit-user" placeholder="Escolha o grupo" required style="width:250px">
                <div id="suggestions-gp-edit-user" class="suggestions-box gp-edit-user">
                    <p id="p0" onclick="passarValor('0', 'gp-edit-user', '0')">Usuários</p>
                    <p id="p1" onclick="passarValor('1', 'gp-edit-user', '1')">Administradores</p>
                </div>
                <input id="hidden-gp-edit-user" name="hidden-gp-edit-user" type="hidden" value="">
            </div>
        </div>
        <div id="linha-6" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-user-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-user-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>