document.querySelectorAll('.card button').forEach((button) => {
  button.addEventListener('click', () => {
    button.classList.add('loading');
  });
});
