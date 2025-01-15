document.addEventListener('DOMContentLoaded', () => {
    const thirdPage = document.querySelector('.new-order-recap');
    const secondPageButton = document.querySelector('.new-order-payment button');

    secondPageButton.addEventListener('click', () => {
        thirdPage.style.display = 'flex';
    })
})