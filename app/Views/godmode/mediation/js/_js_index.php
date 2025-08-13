<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('calcTable');

        function hitung(prezzoBuy, prezzoSell) {
            let commBuy = prezzoBuy * 0.001; // 0.1% dari buy
            let commSell = prezzoSell * 0.001; // 0.1% dari sell
            let totComm = commBuy + commSell;
            let net = prezzoSell - prezzoBuy - commBuy - commSell;
            let percent = (net / prezzoBuy) * 100;
            let percentSuCap = percent / 2 / 4;
            return {
                commBuy,
                commSell,
                totComm,
                net,
                percent,
                percentSuCap
            };
        }

        function buatRow(prezzoBuy, prezzoSell, type = 'combo') {
            let {
                commBuy,
                commSell,
                totComm,
                net,
                percent,
                percentSuCap
            } = hitung(prezzoBuy, prezzoSell);
            let tr = document.createElement('tr');
            tr.className = type;
            tr.innerHTML = `
            <td>${prezzoBuy.toFixed(0)}</td>
            <td>${prezzoSell.toFixed(0)}</td>
            <td>${commBuy.toFixed(2)}</td>
            <td>${commSell.toFixed(2)}</td>
            <td>${totComm.toFixed(2)}</td>
            <td>${net.toFixed(2)}</td>
            <td style="color: green;">${percent.toFixed(9)}%</td>
            <td>${percentSuCap.toFixed(9)}</td>
        `;
            return tr;
        }

        function buatSpacer() {
            let spacer = document.createElement('tr');
            spacer.className = 'combo-spacer';
            spacer.innerHTML = `<td colspan="8" style="height:60px;background:transparent"></td>`;
            return spacer;
        }

        function updateTable() {
            // Hapus semua baris combo lama & spacer lama
            tableBody.querySelectorAll('.combo, .combo-spacer').forEach(row => row.remove());

            let buyValues = [];
            let sellValues = [];
            let rows = Array.from(tableBody.querySelectorAll('tr'));
            rows.forEach((r, idx) => {
                let buy = parseFloat(r.querySelector('.buy-input')?.value) || 0;
                let sell = parseFloat(r.querySelector('.sell-input')?.value) || 0;
                if (buy > 0 && sell > 0) {
                    buyValues[idx] = buy;
                    sellValues[idx] = sell;
                    r.insertAdjacentElement('afterend', buatSpacer());
                    let hasil = hitung(buy, sell);
                    r.querySelector('.comm-buy').textContent = hasil.commBuy.toFixed(2);
                    r.querySelector('.comm-sell').textContent = hasil.commSell.toFixed(2);
                    r.querySelector('.tot-comm').textContent = hasil.totComm.toFixed(2);
                    r.querySelector('.net').textContent = hasil.net.toFixed(2);
                    r.querySelector('.percent').textContent = hasil.percent.toFixed(9) + '%';
                    r.querySelector('.percent-su-cap').textContent = hasil.percentSuCap.toFixed(9);


                    // Tambah baris tambahan combo + spacer sesuai baris input
                    if (idx === 1) {
                        // r.insertAdjacentElement('afterend', buatSpacer());
                        let avgBuy = (buyValues[0] + buyValues[1]) / 2;
                        r.insertAdjacentElement('afterend', buatRow(avgBuy, sellValues[1]));
                    }
                    if (idx === 2) {
                        // r.insertAdjacentElement('afterend', buatSpacer());
                        let row2 = buatRow((buyValues[0] + buyValues[1] + buyValues[2]) / 3, sellValues[2]);
                        let row3 = buatRow((buyValues[1] + buyValues[2]) / 2, sellValues[2]);
                        r.insertAdjacentElement('afterend', row3);
                        r.insertAdjacentElement('afterend', row2);
                    }
                    if (idx === 3) {
                        // r.insertAdjacentElement('afterend', buatSpacer());
                        let row2 = buatRow((buyValues[1] + buyValues[2] + buyValues[3]) / 3, sellValues[3]);
                        let row3 = buatRow((buyValues[2] + buyValues[3]) / 2, sellValues[3]);
                        let row1 = buatRow((buyValues[0] + buyValues[1] + buyValues[2] + buyValues[3]) / 4, sellValues[3]);
                        r.insertAdjacentElement('afterend', row3);
                        r.insertAdjacentElement('afterend', row2);
                        r.insertAdjacentElement('afterend', row1);
                    }
                } else {
                    r.querySelector('.comm-buy').textContent = '';
                    r.querySelector('.comm-sell').textContent = '';
                    r.querySelector('.tot-comm').textContent = '';
                    r.querySelector('.net').textContent = '';
                    r.querySelector('.percent').textContent = '';
                    r.querySelector('.percent-su-cap').textContent = '';
                }
            });
        }

        tableBody.addEventListener('input', function(e) {
            if (e.target.classList.contains('buy-input') || e.target.classList.contains('sell-input')) {
                updateTable();
            }
        });
    });
</script>