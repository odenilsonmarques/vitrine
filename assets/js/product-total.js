document.addEventListener('DOMContentLoaded', function () {

    function formatPrice(value) {
        return value.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    function parsePrice(text) {
        return parseFloat(
            text
                .replace(/\s/g, '')
                .replace('R$', '')
                .replace(/\./g, '')
                .replace(',', '.')
        );
    }


    function getGroupedTotal() {
        let total = 0;

        document.querySelectorAll('.group_table tr').forEach(function (row) {
            const qtyInput = row.querySelector('input.qty');
            if (!qtyInput) return;

            const qty = parseInt(qtyInput.value, 10);
            if (!qty || qty <= 0) return;

            let priceEl = row.querySelector(
                '.woocommerce-grouped-product-list-item__price ins .woocommerce-Price-amount'
            );

            if (!priceEl) {
                priceEl = row.querySelector(
                    '.woocommerce-grouped-product-list-item__price .woocommerce-Price-amount'
                );
            }

            if (!priceEl) return;

            const price = parsePrice(priceEl.textContent);
            if (!isNaN(price)) {
                total += price * qty;
            }
        });

        return total;
    }

    function updateTotal() {
        const totalBox = document.querySelector('.grouped-total');
        if (!totalBox) return;

        // Se for produto agrupado → mostrar total
        if (document.querySelector('.group_table')) {
            const priceEl = totalBox.querySelector('.total-price');
            priceEl.textContent = formatPrice(getGroupedTotal());
            totalBox.style.display = 'flex';
        } else {
            // Produto simples ou variável → esconder total
            totalBox.style.display = 'none';
        }
    }


    // Eventos
    document.addEventListener('input', function (e) {
        if (
            e.target.matches('.group_table input.qty') ||
            e.target.matches('.purchase-box input.qty') ||
            e.target.matches('form.variations_form select')
        ) {
            updateTotal();
        }
    });

    // Inicial
    updateTotal();
});
