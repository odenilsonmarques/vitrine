
document.addEventListener('DOMContentLoaded', function () {

  // Função para coletar os dados do formulário
  // Função para coletar os dados do formulário
  function collectFormData() {
    // ... (Coleta de dados do cliente mantida igual, pois está funcionando)
    const primeiroNome = document.querySelector('#billing-first_name')?.value.trim() || '';
    const sobrenome = document.querySelector('#billing-last_name')?.value.trim() || '';
    const nomeCompleto = `${primeiroNome} ${sobrenome}`.trim();
    const email = document.querySelector('#email')?.value.trim() || '';
    const telefone = document.querySelector('#billing-phone')?.value.trim() || '';
    const endereco = document.querySelector('#billing-address_1')?.value.trim() || '';

    // --- Lógica de coleta de ITENS (CORRIGIDO PARA INCLUIR QUANTIDADE, PREÇO E VARIAÇÃO) ---
    const itensElements = document.querySelectorAll('.wc-block-components-order-summary-item');

    const itens = Array.from(itensElements)
      .map(itemEl => {
        const quantidadeEl = itemEl.querySelector('.wc-block-components-order-summary-item__quantity [aria-hidden="true"]');
        const nomeEl = itemEl.querySelector('.wc-block-components-product-name');
        const precoEl = itemEl.querySelector('.wc-block-components-order-summary-item__total-price .wc-block-formatted-money-amount');
        const metadataEl = itemEl.querySelector('.wc-block-components-product-metadata'); // NOVO: SELETOR DE VARIAÇÃO

        const quantidade = quantidadeEl ? quantidadeEl.innerText.trim() : '1';
        const nome = nomeEl ? nomeEl.innerText.trim() : 'Item não identificado';
        const preco = precoEl ? precoEl.innerText.trim() : 'Preço não encontrado';

        // NOVO: Coleta e formata a variação
        let variacao = '';
        if (metadataEl) {
          // Remove quebras de linha e espaços duplos para ter uma string limpa (ex: Cor: cinza)
          variacao = metadataEl.innerText.replace(/[\n\r]+/g, ', ').replace(/\s\s+/g, ' ').trim();
          if (variacao) {
            // Adiciona a variação entre parênteses
            variacao = ` (${variacao})`;
          }
        }

        // Retorna a string formatada: 2 x Short masculino (Cor: cinza) - R$ 95,00
        return `${quantidade} x ${nome}${variacao} - ${preco}`;
      })
      .join('\n');

    // Coleta do Total Final (mantida a versão correta)
    const total = document.querySelector('.wc-block-components-totals-footer-item .wc-block-formatted-money-amount')?.innerText || '';

    return { nomeCompleto, email, telefone, endereco, itens, total };
  }

  // O restante do código JS (handlePlaceOrderClick e MutationObserver) permanece o mesmo.

  // O restante do código JS (handlePlaceOrderClick e MutationObserver) permanece o mesmo.

  // Função principal para manipular o clique e mostrar o modal
  function handlePlaceOrderClick(e) {
    const placeOrderBtn = e.currentTarget;

    // VERIFICA SE ESTE É O CLIQUE INICIAL (para abrir o modal) ou o clique FINAL (para enviar o pedido)
    if (placeOrderBtn.dataset.allowSubmit === 'true') {
      // Se 'allowSubmit' é true, permite que o checkout do WooCommerce prossiga.
      // Removemos o atributo para que no próximo clique voltemos ao modal.
      placeOrderBtn.dataset.allowSubmit = 'false';
      return;
    }

    // 1. É o clique INICIAL: IMPEDE A AÇÃO PADRÃO
    e.preventDefault();
    e.stopPropagation();

    const data = collectFormData();

    // Validação básica (Opcional, mas útil)
    if (!data.nomeCompleto || !data.telefone || !data.itens || !data.total) {
      // Deixa o WooCommerce lidar com a mensagem de erro
      alert("Por favor, preencha todos os campos obrigatórios do checkout.");
      return;
    }

    // Tenta remover qualquer estado de "carregando"
    placeOrderBtn.disabled = false;
    placeOrderBtn.classList.remove('is-loading');

    // Cria modal (Usando os dados coletados)
    const modal = document.createElement('div');
    modal.id = 'pedidoModal';
    modal.style.cssText = `
          position:fixed;left:0;top:0;right:0;bottom:0;
          background:rgba(0,0,0,0.5);display:flex;
          align-items:center;justify-content:center;
          z-index:99999;
        `;
    modal.innerHTML = `
          <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;box-shadow:0 4px 12px rgba(0,0,0,0.3);">
            <h2 style="margin-top:0;">Confirmar Pedido</h2>
            <h5 style="margin-top:0;">Olá! Meu nome é <strong>${data.nomeCompleto}</strong> e este é o meu pedido realizado na loja Vibe Fit.</h5>
            <p><strong>Cliente:</strong> ${data.nomeCompleto || 'Não informado'}</p>
            <p><strong>Email:</strong> ${data.email || 'Não informado'}</p> 
            <p><strong>Telefone:</strong> ${data.telefone || 'Não informado'}</p>
            <p><strong>Endereço:</strong> ${data.endereco || 'Não informado'}</p>
            <pre style="background:#f9f9f9;padding:10px;border-radius:8px;max-height:200px;overflow:auto;"><strong>${data.itens}</strong></pre>
            <p><strong style="font-size:20px">Total:${data.total}</strong></p>
            <div style="text-align:right;margin-top:16px;">
              <button id="cancelarModal" style="padding:8px 12px;background:#ccc;border:none;border-radius:6px;margin-right:8px;">Cancelar</button>
              <button id="enviarWhatsApp" style="padding:8px 12px;background:#25d366;color:white;border:none;border-radius:6px;">Enviar e Finalizar Pedido</button>
            </div>
          </div>
        `;
    document.body.appendChild(modal);

    // Eventos do modal
    document.getElementById('cancelarModal').addEventListener('click', () => modal.remove());



    document.getElementById('enviarWhatsApp').addEventListener('click', () => {
      // AQUI DEFINIMOS O NOVO CABEÇALHO DA MENSAGEM



      // Cria a mensagem de Abertura com *ASTERISCOS* para negrito no WhatsApp
      const nomeCompleto = `*${data.nomeCompleto}*`;
      const cabecalhoMensagem = `Olá! Meu nome é ${nomeCompleto} e este é o meu pedido realizado na loja Vibe Fit.`;


      const numeroLoja = '5598981061009';

      // CONCATENAMOS O CABEÇALHO COM O RESTANTE DO PEDIDO
      const mensagem = encodeURIComponent(
        `${cabecalhoMensagem}\n\n` +
        `ITENS:\n${data.itens}\n\n` +
        `Total: ${data.total}\n` +
        `Nome: ${data.nomeCompleto}\n` +
        `Email: ${data.email}\n` +
        `Telefone: ${data.telefone}\n` +
        `Endereço: ${data.endereco}`
      );

      // Opcional: Para uma melhor organização no Zap, adicionei a quebra de linha "ITENS:\n"

      // 2. Remove o modal
      modal.remove();

      // 3. Envia o WhatsApp e finaliza o pedido
      window.open(`https://wa.me/${numeroLoja}?text=${mensagem}`, '_blank');

      placeOrderBtn.dataset.allowSubmit = 'true';
      placeOrderBtn.click(); // Dispara o segundo clique para finalizar o pedido no WooCommerce
    });
  }

  // Observador para o botão (mantido o mesmo)
  const observer = new MutationObserver(() => {
    const placeOrderBtn = document.querySelector('.wc-block-components-checkout-place-order-button');
    if (placeOrderBtn && !placeOrderBtn.dataset.listenerAdded) {
      placeOrderBtn.dataset.listenerAdded = true;
      placeOrderBtn.addEventListener('click', handlePlaceOrderClick);
    }
  });

  observer.observe(document.body, { childList: true, subtree: true });
});
