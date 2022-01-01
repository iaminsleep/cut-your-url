document.addEventListener('DOMContentLoaded', () => {
  const clipboard = new ClipboardJS('.copy-btn');
  const myToastEl = document.querySelector('.toast');
  const toastText = myToastEl.querySelector('.toast-body');

  clipboard.on('success', (e) => {
    toastText.textContent = `Ссылка '${e.text}' скопирована в буфер обмена`;

    const myToast = new bootstrap.Toast(myToastEl);
    myToast.show();

    e.clearSelection();
  });

  const addLinkInput = document.querySelector('input[name="link"]');
  addLinkInput.onclick = () => {
    addLinkInput.value = 'https://';
  }
});