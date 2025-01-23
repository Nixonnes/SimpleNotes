
// Удаление заметки

document.querySelectorAll('.delete-note').forEach(button=> {
    button.addEventListener("click", function () {
        const NoteId = this.getAttribute('data-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (confirm("Вы действительно хотите удалить заметку?")) {
            fetch(`/notes/${NoteId}/delete`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': csrfToken,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    _method: 'DELETE' // Эмулируем DELETE через _method
                })
            }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.querySelector(`.note[data-id="${NoteId}"]`).remove();
                        displayFlashMessage(data.message, 'success');
                    } else {
                        displayFlashMessage(data.message, 'error');
                    }
                }).catch(error => {
                displayFlashMessage('Произошла ошибка при удалении', 'error');
                console.error(error);
            });
        }
    });
});


function displayFlashMessage(message, type = 'success') {
    const flashContainer = document.querySelector('.flash-container');
    if (!flashContainer) {
        console.error('Flash container not found');
        return;
    }

    const flashMessage = document.createElement('div');
    flashMessage.className = `flash-message flash-${type}`;
    flashMessage.textContent = message;

    flashContainer.appendChild(flashMessage);

    setTimeout(() => {
        flashMessage.remove();
    }, 3000); // Удалить сообщение через 3 секунды
}
