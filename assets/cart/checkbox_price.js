document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="item"]');
    const checkoutButton = document.getElementById('checkout-button');
    const noSelectionButton = document.getElementById('no-selection-button');

    const updateCart = () => {
        let totalPrice = 0;
        let selectedCount = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                totalPrice += price;
                selectedCount = selectedCount + quantity;
            }
        });

        // Mise à jour du bouton "Passer commande"
        checkoutButton.textContent = `Passer commande (${selectedCount} articles) : ${totalPrice.toFixed(2)} €`;
        checkoutButton.hidden = selectedCount === 0;

        // Affiche ou cache le bouton "Aucun article sélectionné"
        noSelectionButton.hidden = selectedCount > 0;
    };

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCart);
    });

    // Initialisation de l'état des boutons
    updateCart();
});
