document.addEventListener('DOMContentLoaded', () => {
    const medicineAddButtons = document.querySelectorAll('.medicine-add');
    const formulaire = document.querySelector('.medicine-float');
    const formulaireInput = document.querySelector('.medicine-form-cart input[name="purchase_quantity[quantity]"]');
    const pNom = document.querySelector('.medicine-float-item-name');
    const pPrice = document.querySelector('.medicine-float-item-price');
    const pImage = document.querySelector('.medicine-float-item-image');
    const pStock = document.querySelector('.medicine-float-item-stock');
    const inputId = document.querySelector('#purchase_quantity_id')
    const formulaireClose = document.querySelector('.medicine-float > button');
    const formulaireContainer = document.querySelector('.medicine-float-container');

    medicineAddButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const stock = button.getAttribute('data-stock');
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            const image = button.getAttribute('data-image');
            const id = button.getAttribute('data-id');
            formulaireInput.setAttribute('max', stock);
            formulaireInput.value = 1;
            inputId.value = id;
            pNom.innerText = name;
            pPrice.innerText = price + '€';
            pImage.setAttribute('src', image);
            pStock.innerText = 'En stock (' + stock + ')'
            formulaireInput.addEventListener('click', () => {
                pPrice.innerText = price*formulaireInput.value + '€';
            })
            formulaireContainer.style.display = 'block';
            formulaireClose.addEventListener('click', () => {
                formulaireContainer.style.display = 'none';
            })
            notFormulaire.addEventListener('click', () => {
                formulaireContainer.style.display = 'none';
            })
        });
    });
});
