/* Scoped shortcode copying, with a selectable text fallback. */
(function () {
 'use strict';
 document.querySelectorAll('.gwnf-settings .gwnf-copy').forEach(function (button) {
  button.hidden = false;
  button.addEventListener('click', async function () {
   var input = document.getElementById(button.dataset.copyTarget);
   var status = document.getElementById('gwnf-copy-status');
   if (!input || !status) { return; }
   status.textContent = '';
   try {
    if (!navigator.clipboard || !window.isSecureContext) { throw new Error('unavailable'); }
    await navigator.clipboard.writeText(input.value);
    status.textContent = button.dataset.copySuccess;
   } catch (error) {
    input.focus();
    input.select();
    status.textContent = button.dataset.copyFailure;
   }
  });
 });
}());
