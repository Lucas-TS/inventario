$(document).ready(function() {
   // Delegação de eventos para elementos gerados dinamicamente
   document.addEventListener('focus', function(event) {
      if (event.target.classList.contains('input')) {
         event.target.dataset.placeholder = event.target.placeholder;
         event.target.placeholder = '';
      }
   }, true); // Use capture phase

   document.addEventListener('blur', function(event) {
      if (event.target.classList.contains('input')) {
         event.target.placeholder = event.target.dataset.placeholder;
      }
   }, true); // Use capture phase
});