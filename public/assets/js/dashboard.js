let updateButtons = document
    .getElementsByClassName('open-form-button');

let cancelButtons = document
    .getElementsByClassName('close-form-button');

let feedback = document.getElementById('feedback');

for (let i = 0; i < updateButtons.length; i++) {
    updateButtons[i].addEventListener('click', () => {
        updateButtons[i].parentElement.parentElement.classList.add('d-none');
        updateButtons[i].parentElement.parentElement.nextElementSibling.classList.remove('d-none');
    });
}

for (let i = 0; i < cancelButtons.length; i++) {
    cancelButtons[i].addEventListener('click', () => {
        cancelButtons[i].parentElement.parentElement.classList.add('d-none');
        cancelButtons[i].parentElement.parentElement.previousElementSibling.classList.remove('d-none');
    });
}

if(feedback !== null) {
    setTimeout(() => {
        feedback
            .classList
            .add('d-none');
    }, 4000);
}