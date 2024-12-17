const inputSearch = document.getElementById('input-search');
const submitSearch = document.getElementById('submit-search');
const medicinesContainer = document.getElementById('medicines-container');

if (inputSearch && submitSearch) {
    inputSearch.addEventListener('keyup', (e) => {
        e.preventDefault();
        if (e.key === 'Enter') return searchMedicine(e.target.value);
    })

    submitSearch.addEventListener('click', (e) => {
        e.preventDefault();
        return searchMedicine(inputSearch.value);
    });
}

async function searchMedicine(input) {
    const response = await fetch(`/medicines?search=${input}&containerOnly=1`, {
        method: 'GET'
    });

    if(!response.ok) return;

    medicinesContainer.innerHTML = await response.text();

    if (history.pushState) {
        const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}?search=${input}`;
        window.history.pushState({path:newUrl},'',newUrl);
    }
}