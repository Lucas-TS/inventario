$(document).ready(function(){
   // Função para aplicar máscaras
   function applyMasks() {
       // Máscara para MAC Address
       $('#input-mac').mask('AA:AA:AA:AA:AA:AA', {
           translation: {
               'A': { pattern: /[A-Fa-f0-9]/ }
           },
           onKeyPress: function(value, e, field, options) {
               field.val(value.toUpperCase());
           }
       });

       // Máscara para Serial
       $('#serial-so').mask('AAAAA-AAAAA-AAAAA-AAAAA-AAAAA', {
           translation: {
               'A': { pattern: /[A-Za-z0-9]/ }
           },
           onKeyPress: function(value, e, field, options) {
               field.val(value.toUpperCase());
           }
       });

       // Transformar texto em caixa alta para o campo #input-hn
       $('#input-hn').on('input', function() {
           this.value = this.value.toUpperCase();
       });
   }

   // Aplicar máscaras inicialmente
   applyMasks();

   // Configurar MutationObserver para monitorar mudanças no DOM
   const observer = new MutationObserver(function(mutations) {
       mutations.forEach(function(mutation) {
           if (mutation.addedNodes.length) {
               $(mutation.addedNodes).each(function() {
                   if ($(this).is('#input-mac, #serial-so, #input-hn')) {
                       applyMasks();
                   }
               });
           }
       });
   });

   // Iniciar observação no body
   observer.observe(document.body, {
       childList: true,
       subtree: true
   });
});
