
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".filter-btn");
    const products = document.querySelectorAll(".product-card");

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            // retirar active de todas
            buttons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            const category = btn.getAttribute("data-category");

            products.forEach(product => {
                const categories = product.getAttribute("data-categories").split(",");

                // mostrar tudo
                if (category === "") {
                    product.style.display = "block";
                    return;
                }

                // se o produto pertence à categoria clicada
                if (categories.includes(category)) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        });
    });
});
