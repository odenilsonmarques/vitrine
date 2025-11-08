document.addEventListener("DOMContentLoaded", function () {
    const productList = document.getElementById("product-list");

    function fetchProdutos(categoryId) {
        fetch(ajax_object.ajax_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `action=filter_products&category_id=${categoryId}`
        })
            .then(response => response.text())
            .then(data => {
                productList.innerHTML = data;
            });
    }

    // Botões do desktop
    document.querySelectorAll(".filter-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            const categoryId = this.getAttribute("data-category");

            // Visual feedback
            document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            // Atualiza select no mobile (opcional)
            const select = document.getElementById("category-select");
            if (select) select.value = categoryId;

            fetchProdutos(categoryId);
        });
    });

    // Select do mobile
    const select = document.getElementById("category-select");
    if (select) {
        select.addEventListener("change", function () {
            const categoryId = this.value;

            // Remove classe active dos botões (opcional)
            document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active"));

            fetchProdutos(categoryId);
        });
    }
});
