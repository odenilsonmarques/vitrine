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

    function getSimpleProductTotal() {
        // Preço (prioriza promocional)
        let priceEl = document.querySelector('.purchase-box ins .woocommerce-Price-amount');

        if (!priceEl) {
            priceEl = document.querySelector('.purchase-box .woocommerce-Price-amount');
        }

        if (!priceEl) return 0;

        const price = parsePrice(priceEl.textContent);
        if (isNaN(price)) return 0;

        // Quantidade
        const qtyInput = document.querySelector('.purchase-box input.qty');
        const qty = qtyInput ? parseInt(qtyInput.value, 10) : 1;

        return price * (qty > 0 ? qty : 1);
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
        const totalEl = document.querySelector('.grouped-total .total-price');
        if (!totalEl) return;

        // Produto agrupado
        if (document.querySelector('.group_table')) {
            totalEl.textContent = formatPrice(getGroupedTotal());
        } else {
            // Produto simples / variável
            totalEl.textContent = formatPrice(getSimpleProductTotal());
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
