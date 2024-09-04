$(document).ready(function() {
   // Delegação de eventos para elementos gerados dinamicamente
   document.addEventListener('focus', function(event) {
      if (event.target.classList.contains('input')) {
         if (event.target.classList.contains('mac')) {
            event.target.dataset.placeholder = event.target.placeholder;
            event.target.placeholder = '__:__:__:__:__:__';
         } else {
            event.target.dataset.placeholder = event.target.placeholder;
            event.target.placeholder = '';
         }
      }
   }, true);

   document.addEventListener('blur', function(event) {
      if (event.target.classList.contains('input')) {
         event.target.placeholder = event.target.dataset.placeholder;
      }
   }, true);
});
