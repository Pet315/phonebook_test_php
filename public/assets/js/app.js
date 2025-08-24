document.addEventListener('DOMContentLoaded', () => {
  const addForm = document.getElementById('add-contact-form');
  if (!addForm) return;

  addForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(addForm);
    const resp = await fetch('/contacts/create', {
      method: 'POST',
      body: formData
    });
    const data = await resp.json();
    const alertBox = document.getElementById('ajax-alert');
    if (data.success) {
      alertBox.className = 'alert alert-success';
      alertBox.textContent = 'Контакт додано';
      alertBox.style.display = 'block';
      // Optionally append to list
      setTimeout(() => location.reload(), 600);
    } else {
      alertBox.className = 'alert alert-danger';
      alertBox.textContent = data.error || 'Помилка';
      alertBox.style.display = 'block';
    }
  });
});
