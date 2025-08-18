<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('calcTable');
        const calcBtn = document.getElementById('calcBtn');
        const calcForm = document.getElementById('calcForm');

        // Ambil role user dari server
        const userRole = "<?= $role ?>"; // superadmin / admin

        const BASE_SAVE = "<?= base_url('godmode/mediation/save') ?>";
        const BASE_CREATE = "<?= base_url('godmode/mediation/create') ?>";

        calcForm.addEventListener('submit', function(e) {
            const checkboxes = this.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                if (!cb.checked) {
                    // Buat input hidden sementara dengan value 0
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = cb.name;
                    hidden.value = '0';
                    this.appendChild(hidden);
                }
            });
        });

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

        // Fetch data JSON dan masukkan ke input
        // fetch("<?= BASE_URL ?>/godmode/mediation/history")
        //     .then(res => res.json())
        //     .then(response => {
        //         const data = response.result?.data; // ambil data di dalam result
        //         // console.log("Fetched data:", data);
        //         if (Array.isArray(data) && data.length > 0) {
        //             data = dataArray[0];
        //         }

        //         if (!data) {
        //             // Data kosong atau 404 → tombol "Calculate", form action "create"
        //             calcBtn.textContent = "Calculate";
        //             calcForm.action = BASE_CREATE;
        //             return;
        //         }

        //         // Data ada → tombol "Update Calculate Data", form action "save"
        //         calcBtn.textContent = "Update Calculate Data";
        //         calcForm.action = BASE_SAVE;

        //         let idInput = document.querySelector('input[name="id"]');
        //         if (!idInput) {
        //             idInput = document.createElement('input');
        //             idInput.type = 'hidden';
        //             idInput.name = 'id';
        //             calcForm.appendChild(idInput);
        //         }
        //         idInput.value = data.id;
        //         for (let key in data) {
        //             const value = data[key];
        //             const input = document.querySelector(`input[name="${key}"]`);
        //             if (input) {
        //                 if (input.type === "checkbox") {
        //                     input.checked = value == 1; // non-strict comparison
        //                     // atau
        //                     input.checked = String(value) === "1";
        //                 } else {
        //                     input.value = value;
        //                 }
        //             }
        //         }

        //         updateTable();
        //     })
        //     .catch(err => {
        //         console.error("Error fetch/parse JSON:", err);
        //         calcBtn.textContent = "Calculate";
        //         calcForm.action = BASE_CREATE;
        //     });

        // Fetch data JSON dan masukkan ke input
        fetch("<?= BASE_URL ?>/godmode/mediation/history")
            .then(res => res.json())
            .then(response => {
                let data = response.result?.data;

                if (!data) {
                    calcBtn.textContent = "Calculate";
                    calcForm.action = BASE_CREATE;
                    return;
                }

                calcBtn.textContent = "Update Calculate Data";
                calcForm.action = BASE_SAVE;

                let idInput = document.querySelector('input[name="id"]');
                if (!idInput) {
                    idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    calcForm.appendChild(idInput);
                }
                idInput.value = data.id;

                // Set semua input dan checkbox
                for (let key in data) {
                    const value = data[key];
                    const input = document.querySelector(`input[name="${key}"]`);
                    if (input) {
                        if (input.type === "checkbox") {
                            input.checked = String(value) === "1";
                        } else {
                            input.value = value;
                            input.disabled = false; // reset dulu
                        }
                    }
                }

                // Logic untuk admin
                if (userRole !== "superadmin") {
                    for (let i = 1; i <= 4; i++) {
                        const buyLock = data[`lock_buy${i}`];
                        const sellLock = data[`lock_sell${i}`];

                        const buyInput = document.querySelector(`input[name="prezzo_buy${i}"]`);
                        const sellInput = document.querySelector(`input[name="prezzo_sell${i}"]`);

                        if (buyInput) buyInput.disabled = buyLock === "1";
                        if (sellInput) sellInput.disabled = sellLock === "1";

                        // Manipulasi tampilan gembok untuk admin
                        const buyLabel = document.querySelector(`input[name="lock_buy${i}"]`)?.parentElement;
                        const sellLabel = document.querySelector(`input[name="lock_sell${i}"]`)?.parentElement;

                        if (buyLabel) buyLabel.innerHTML = buyLock === "1" ? "🔒" : "";
                        if (sellLabel) sellLabel.innerHTML = sellLock === "1" ? "🔒" : "";
                    }
                }

                // Sembunyikan tombol jika bukan superadmin
                if (userRole !== "superadmin") {
                    const btnWrapper = calcBtn.closest('.d-flex');
                    if (btnWrapper) {
                        btnWrapper.remove(); // hapus seluruh div wrapper beserta tombolnya
                    }
                }


                updateTable();
            })
            .catch(err => {
                console.error("Error fetch/parse JSON:", err);
                calcBtn.textContent = "Calculate";
                calcForm.action = BASE_CREATE;
            });
    });
</script>