const inputSearch = document.getElementById('input-search');
const submitSearch = document.getElementById('submit-search');
const medicinesContainer = document.getElementById('medicines-container');

if (inputSearch && submitSearch) {
    inputSearch.addEventListener('keyup', (e) => {
        e.preventDefault();

        if (e.key === 'Enter') return updateQueryAndFetchMedicines('search', e.target.value);
    })

    submitSearch.addEventListener('click', (e) => {
        e.preventDefault();
        return updateQueryAndFetchMedicines('search', inputSearch.value);
    });
}

async function updateQueryAndFetchMedicines(key, value) {
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString);
    params.set(key, value);

    if (history.pushState) {
        const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}?${params.toString()}`;
        window.history.pushState({path: newUrl}, '', newUrl);
    }

    const response = await fetch(`/medicines?${query}&containerOnly=1`, {
        method: 'GET'
    });

    if(!response.ok) return;

    medicinesContainer.innerHTML = await response.text();
}
