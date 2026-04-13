const input = document.getElementById('live-search');
const resultsBox = document.getElementById('live-search-results');

let timeout = null;

input.addEventListener('keyup', function () {
    clearTimeout(timeout);

    const term = this.value;

    timeout = setTimeout(() => {

        if (term.length < 2) {
            resultsBox.innerHTML = '';
            return;
        }

        fetch(`/wp-admin/admin-ajax.php?action=live_search&term=${term}`)
            .then(res => res.json())
            .then(data => {

                if (!data.length) {
                    resultsBox.innerHTML = '<p>Nenhum produto encontrado</p>';
                    return;
                }

                resultsBox.innerHTML = data.map(item => `
                    <a href="${item.link}" class="search-item">
                        <img src="${item.image}" width="40">
                        <span>${item.title}</span>
                    </a>
                `).join('');

            });

    }, 300); // debounce

});


// fecha os resultados quando clicar fora
document.addEventListener('click', function (e) {
    const wrapper = document.querySelector('.search-wrapper');

    if (!wrapper.contains(e.target)) {
        resultsBox.innerHTML = '';
    }
});