<div id="add_proc" class="bloco" onclick="event.stopPropagation();" onkeyup="event.stopPropagation();">
   <form name="add_proc_form" method="post" accept-charset="UTF-8" action="includes/add_proc.php" id="add_proc_form">
      <div class="header">
         <span>Adicionar Processador</span>
         <div id="botoes">
            <div id="b-line-fim-1" class="b-line">
               <button id="limpar" type="reset"><?php include '../images/erase.svg'; ?></button>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-fim-2" class="b-line">
               <button id="enviar" type="submit"><?php include '../images/ok.svg'; ?></button>
            </div>
         </div>
      </div>
      <div id="linha-1" class="linha">
         <div id="h-line-1" class="h-line">Informações básicas:</div>
         <div id="b-line-1" class="b-line"><label class="label" for="marca">Marca:</label>
            <input id="marca-proc" name="marca" type="text" class="input openBox" placeholder="Digite a marca" style="width:250px">
            <div id="suggestions-marca-proc" class="suggestions-box marca-proc">
               <p id="p1" onclick="passarValor(1,'marca-proc','');">AMD</p>
               <p id="p1" onclick="passarValor(2,'marca-proc','');">Intel</p>
            </div>
         </div>
         <div id="h-spacer"></div>
         <div id="b-line-2" class="b-line"><label class="label" for="modelo">Modelo:</label>
            <input id="modelo-proc" name="modelo" type="text" class="input" placeholder="Digite o modelo" style="width:250px">
         </div>
   </form>
   <script>
      document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        const suggestionsDiv = document.querySelector(`.suggestions-${input.id}`);

        if (suggestionsDiv) {
            input.addEventListener('click', () => handleInputEvent(input, suggestionsDiv));
            input.addEventListener('keyup', () => handleInputEvent(input, suggestionsDiv));

            document.addEventListener('click', (event) => {
                if (!input.contains(event.target) && !suggestionsDiv.contains(event.target)) {
                    suggestionsDiv.classList.remove('visivel');
                }
            });

            suggestionsDiv.addEventListener('click', (event) => {
                if (event.target.tagName === 'P') {
                    suggestionsDiv.classList.remove('visivel');
                }
            });
        }
    });

    function handleInputEvent(input, suggestionsDiv) {
        const paragraphs = suggestionsDiv.querySelectorAll('p');
        let matchFound = false;

        paragraphs.forEach(p => {
            if (p.textContent === input.value) {
                matchFound = true;
            }
        });

        if (!matchFound) {
            suggestionsDiv.classList.add('visivel');
        } else {
            suggestionsDiv.classList.remove('visivel');
        }
    }
});

   </script>
</div>