document.addEventListener('DOMContentLoaded', function () {
    const accountElement = document.querySelector('.account');
    const deconnectContainer = document.querySelector('.deconnect-container');

    if (accountElement && deconnectContainer) {
        accountElement.addEventListener('mouseover', function () {
            deconnectContainer.style.top = '0';
            deconnectContainer.style.transition = 'ease-in-out 0.5s 1s'
        });

        accountElement.addEventListener('mouseleave', function () {
            deconnectContainer.style.top = '-55px';
            deconnectContainer.style.transition = 'ease-in-out 0.5s'
        });

        deconnectContainer.addEventListener('mouseover', function () {
            deconnectContainer.style.top = '0';
        });

        deconnectContainer.addEventListener('mouseleave', function () {
            deconnectContainer.style.top = '-55px';
            deconnectContainer.style.transition = 'ease-in-out 0.5s'
        });
    }
});