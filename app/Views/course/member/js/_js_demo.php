<style>
    :root {
        --gold: #d4af37;
        --dark-bg: #0d0d0d;
        --panel-bg: #1a1a1a;
    }

    body {
        background-color: var(--dark-bg);
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }

    .order-book,
    .spot,
    .trades {
        background-color: var(--panel-bg);
        border: 1px solid var(--gold);
        border-radius: 10px;
        padding: 15px;
        height: 90vh;
        overflow-y: auto;
    }

    .order-book .bid {
        color: #00ff00;
    }

    .order-book .ask {
        color: #ff3333;
    }

    .highlight-price {
        color: var(--gold);
        font-weight: bold;
    }

    .form-control,
    .btn,
    .nav-tabs .nav-link {
        background-color: var(--dark-bg);
        color: var(--gold);
        border: 1px solid var(--gold);
    }

    .form-control:focus,
    .btn:focus {
        box-shadow: none;
        border-color: var(--gold);
    }

    .form-label,
    .nav-tabs .nav-link.active {
        color: var(--gold);
    }

    .tab-content {
        padding-top: 10px;
    }

    .my-trades {
        font-size: 0.85rem;
    }

    .text-white-labels {
        color: white;
        font-size: 0.85rem;
    }

    .range-slider {
        accent-color: var(--gold);
    }
</style>
<script>
    const priceSocket = new WebSocket('wss://stream.binance.com:9443/ws/btcusdt@trade');
    let lastPrice = null;

    priceSocket.onmessage = function(event) {
        const trade = JSON.parse(event.data);
        const price = parseFloat(trade.p).toFixed(2);
        const priceEl = document.getElementById('price-ticker');

        if (lastPrice !== null) {
            priceEl.style.color = price > lastPrice ? 'limegreen' : 'red';
        }
        priceEl.innerText = price + ' USDT';
        lastPrice = price;
    };

    const ws = new WebSocket('wss://stream.binance.com:9443/ws/btcusdt@depth20@100ms');

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        const bids = data.bids.slice(0, 20);
        const asks = data.asks.slice(0, 20);

        // --- Calculate Total Volumes ---
        const totalBidVolume = bids.reduce((sum, bid) => sum + parseFloat(bid[1]), 0);
        const totalAskVolume = asks.reduce((sum, ask) => sum + parseFloat(ask[1]), 0);
        const totalVolume = totalBidVolume + totalAskVolume;

        // --- Calculate Percentages ---
        const buyPercent = totalVolume === 0 ? 50 : (totalBidVolume / totalVolume) * 100;
        const sellPercent = 100 - buyPercent;

        // --- Update Progress Bars ---
        document.getElementById('buy-bar').style.width = buyPercent.toFixed(2) + '%';
        document.getElementById('sell-bar').style.width = sellPercent.toFixed(2) + '%';

        // --- Update Text Labels ---
        document.getElementById('buy-strength').textContent = buyPercent.toFixed(2) + '%';
        document.getElementById('sell-strength').textContent = sellPercent.toFixed(2) + '%';

        // --- Update Order Book Rows ---
        const container = document.getElementById('orderbook-rows');
        container.innerHTML = '';
        for (let i = 0; i < 20; i++) {
            const bid = bids[i] || ['-', '-'];
            const ask = asks[i] || ['-', '-'];

            const row = document.createElement('div');
            row.className = 'd-flex justify-content-between mb-1';
            row.innerHTML = `
      <span class="text-success">${parseFloat(bid[0]).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
      <span class="text-danger">${parseFloat(ask[0]).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
    `;
            container.appendChild(row);
        }
    };

    ws.onerror = (err) => console.error('WebSocket Error:', err);
</script>