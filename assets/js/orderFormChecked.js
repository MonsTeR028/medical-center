document.addEventListener('DOMContentLoaded', () => {
    // Sélectionnez les deux groupes de formulaires
    const mainForm = document.querySelector('.new-order-form > form');
    const mainFormRadios = mainForm.querySelectorAll('input[type="radio"]');
    const radioAlone = document.querySelector('input[value="new-adress"]');
    const buttonNext = mainForm.querySelector('button');
    const buttonNewNext = document.querySelector('.new-order-new-adress button');
    const allInputNewForm = document.querySelectorAll('.new-order-new-adress-form > form input');

    radioAlone.addEventListener('click', () => {
        mainFormRadios.forEach(radio => {
            console.log(radio.checked);
            radio.checked = false;
            buttonNewNext.style.display = 'block';
            buttonNewNext.disabled = false;
            buttonNext.disabled = true;
            buttonNext.style.display = 'none';
            allInputNewForm.forEach(input => {
                input.disabled = false;
            })
        })
    })

    mainFormRadios.forEach(radio => {
        radio.addEventListener('click', () => {
            radioAlone.checked = false;
            buttonNext.style.display = 'block';
            buttonNext.disabled = false;
            buttonNewNext.disabled = true;
            buttonNewNext.style.display = 'none';
            allInputNewForm.forEach(input => {
                input.disabled = true;
            })
        })
    })


});