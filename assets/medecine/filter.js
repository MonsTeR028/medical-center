const inputSearch = document.getElementById('input-search');
const submitSearch = document.getElementById('submit-search');
const selectCategory = document.getElementById('filter-category');
const selectOrder = document.getElementById('filter-order');
const medicinesContainer = document.getElementById('medicines-container');

if (inputSearch && submitSearch && selectCategory && selectOrder) {
    inputSearch.addEventListener('keyup', (e) => {
        e.preventDefault();

        if (e.key === 'Enter') return updateQueryAndFetchMedicines('search', e.target.value);
    })

    submitSearch.addEventListener('click', (e) => {
        e.preventDefault();
        return updateQueryAndFetchMedicines('search', inputSearch.value);
    });

    selectCategory.addEventListener('change', (e) => {
        return updateQueryAndFetchMedicines('categoryFilter', e.target.value);
    });

    selectOrder.addEventListener('change', (e) => {
        return updateQueryAndFetchMedicines('orderFilter', e.target.value, true);
    });
}

async function updateQueryAndFetchMedicines(key, value, order = false) {
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString);
    if (order) {
        if (value === '') {
            params.delete('orderTarget');
            params.delete('orderBy');
        } else {
            const object = JSON.parse(value);
            params.set('orderTarget', object['column']);
            params.set('orderBy', object['order'])
        }
    } else {
        params.set(key, value);
    }

    if (history.pushState) {
        const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}?${params.toString()}`;
        window.history.pushState({path: newUrl}, '', newUrl);
    }

    const response = await fetch(`/medicines?${params.toString()}&containerOnly=1`, {
        method: 'GET'
    });

    if (!response.ok) return;

    medicinesContainer.innerHTML = await response.text();
}
