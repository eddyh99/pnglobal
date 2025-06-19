<style>
   /* For Chrome, Safari, Edge, Opera */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    
    /* For Firefox */
    .no-spinner {
      -moz-appearance: textfield;
    }
    

    .input-group-text {
      background-color: transparent !important;
      border: none; /* optional: remove border */
      color: inherit; /* optional: keep text color consistent */
    }
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
    
    .nav-tabs .nav-link {
        background-color: var(--dark-bg);
        color: var(--gold);
        border: 1px solid var(--gold);
        margin-bottom: 3px !important; /* default Bootstrap behavior to overlap border */
        padding-bottom: 0.75rem; /* Increase space inside the tab */
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
    let stopchange = false;
    const slider = document.getElementById('btcSlider');
    const slider2 = document.getElementById('btcSlider2');
    const priceInput = document.getElementById('price');
    const qtyInput = document.getElementById('qtybtc');
    const qtyInput2 = document.getElementById('qtybtc2');
    const usdtLabel = document.getElementById('usdtAmount');
    const balance = <?=$balance->available_balance?>;
    const qtyBTC = <?=$balance->btc_qty?>;
    
    priceSocket.onmessage = function(event) {
        const trade = JSON.parse(event.data);
        const price = parseFloat(trade.p).toFixed(2);
        const priceEl = document.getElementById('price-ticker');
        
        if (!stopchange){
            $("#price").val(price);
            $("#price2").val(price);
            $('#market-price').val(price);
        }
        if (lastPrice !== null) {
            priceEl.style.color = price > lastPrice ? 'limegreen' : 'red';
        }
        priceEl.innerText = price;
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
    
    document.querySelectorAll('#spotTab .nav-link').forEach(tab => {
      tab.addEventListener('click', function (e) {
        e.preventDefault();
    
        const type = this.getAttribute('data-type');
        document.getElementById('buytype').value = type;
        document.getElementById('selltype').value = type;
    
        // Toggle tab active class (optional if using Bootstrap's JS)
        document.querySelectorAll('#spotTab .nav-link').forEach(el => el.classList.remove('active'));
        this.classList.add('active');
    
        // Show/hide the price input
        const priceWrapper = document.getElementById('priceWrapper');
        const priceWrapper2 = document.getElementById('priceWrapper2');
        const usdtLabel2 = document.getElementById('usdtLabel2');
        if (type === 'market') {
          priceWrapper.style.display = 'none';
          priceWrapper2.style.display = 'none';
          usdtLabel2.style.display = 'none';
        } else {
          priceWrapper.style.display = '';
          priceWrapper2.style.display = '';
          usdtLabel2.style.display = '';
        }
      });
    });

    
    document.getElementById('tpSL1').addEventListener('change', function () {
        const isChecked = this.checked;
        document.getElementById('tplimit').readOnly = !isChecked;
        document.getElementById('sllimit').readOnly = !isChecked;
        document.getElementById('tplimit').value='';
        document.getElementById('sllimit').value='';
    });

    document.getElementById('tpSL2').addEventListener('change', function () {
        const isChecked = this.checked;
        document.getElementById('tplimit2').readOnly = !isChecked;
        document.getElementById('sllimit2').readOnly = !isChecked;
        document.getElementById('tplimit2').value='';
        document.getElementById('sllimit2').value='';
    });
    
    function floorToDecimal(value, decimals) {
        const factor = Math.pow(10, decimals);
        return Math.floor(value * factor) / factor;
    }
    
    $("#price").on("input",function(){
        stopchange=true;
        const price = parseFloat(this.value.replace(",", ".")); // use `this` for current input
        if (isNaN(price) || price <= 0) return;
    
        const maxBtc =  floorToDecimal(balance / price, 6);
        $("#maxbuy").text(maxBtc);
    });
    
    slider.max = balance;
    
    slider.addEventListener('input', () => {
        const usdt = parseFloat(slider.value);
        usdtLabel.value = usdt;
    
        if ($("#buytype").val()=="limit"){
            stopchange = true;
            // ✅ Normalize once
            const rawPrice = $("#price").val().replace(",", ".");
            const price = parseFloat(rawPrice);
        
            const btc = price > 0 ? floorToDecimal(usdt / price, 6) : 0;
            console.log(btc);
            $("#qtybtc").val(btc);
        
            if (!isNaN(balance) && price > 0) {
                const maxBtc = floorToDecimal(balance / price, 6);
                $("#maxbuy").text(maxBtc);
            } else {
                $("#maxbuy").text("0");
            }
        }
    });


    
    priceInput.addEventListener('input', function (e) {
        const value = e.target.value;
    
        // Allow only max 2 decimals
        const regex = /^\d*\.?\d{0,2}$/;
    
        if (!regex.test(value)) {
          // Strip extra digits beyond 2 decimals
          const parts = value.split(".");
          if (parts.length === 2) {
            e.target.value = parts[0] + "." + parts[1].slice(0, 2);
          } else {
            e.target.value = parts[0];
          }
        }
      });
      
      function enforceBtcInput(e) {
        const value = e.target.value;
        const max = parseFloat(qtyInput.max);
    
        // Allow only up to 6 decimal places
        const regex = /^\d*\.?\d{0,6}$/;
        if (!regex.test(value)) {
          e.target.value = value.slice(0, -1);
          return;
        }
    
        // Enforce max value
        if (parseFloat(value) > max) {
          e.target.value = max.toFixed(6);
        }
      }
      
      // When price is blurred or changed, validate & update BTC
      priceInput.addEventListener('blur', validateAndRecalculate);
      priceInput.addEventListener('change', validateAndRecalculate);
    
      // When BTC is manually entered and blurred, validate limit
      qtyInput.addEventListener('blur', validateBtcLimit);
    
      function validateAndRecalculate() {
        let value = priceInput.value;
    
        // Ensure only max 2 decimals for price
        if (!/^\d*\.?\d{0,2}$/.test(value)) {
          const parts = value.split(".");
          value = parts[0] + (parts[1] ? "." + parts[1].slice(0, 2) : "");
        }
    
        priceInput.value = value;
    
        // Recalculate BTC from slider + price
        const usdt = parseFloat(slider.value);
        const price = parseFloat(priceInput.value);
        if (!isNaN(usdt) && price > 0) {
          const btc = (usdt / price).toFixed(6);
          qtyInput.value = btc;
        }
    
        // Also revalidate BTC in case price change makes it too expensive
        validateBtcLimit();
      }
    
      function validateBtcLimit() {
        const price = parseFloat(priceInput.value);
        let btc = parseFloat(qtyInput.value);
    
        if (isNaN(btc) || price <= 0) return;
    
        const cost = btc * price;
    
        if (cost > balance) {
          const maxBtc = (balance / price).toFixed(6);
          qtyInput.value = maxBtc;
        }
      }


    // sell side

    slider2.max = qtyBTC;
    
    slider2.addEventListener('input', () => {
        const btc = parseFloat(slider2.value);
        console.log(btc);
        
        qtyInput2.value = btc;
    
        if ($("#selltype").val()=="limit"){
            stopchange = true;
            // ✅ Normalize once
            const rawPrice = $("#price").val().replace(",", ".");
            const price = parseFloat(rawPrice);
        
            const usdt = price > 0 ? floorToDecimal(btc * price, 6) : 0;
            $("#usdtAmount2").val(usdt);
        
            // if (!isNaN(qtyBTC) && price > 0) {
            //     const maxUsdt = floorToDecimal(btc * price, 6);
            //     $("#maxbuy").text(maxBtc);
            // } else {
            //     $("#maxbuy").text("0");
            // }
        }
    });
</script>