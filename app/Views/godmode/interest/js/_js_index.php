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

    .locked-input {
        color: gray !important;
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

<script>
    const tbody = document.querySelector("#history-table tbody");
    const amount = document.getElementById("amount");
    const calculateBtn = document.getElementById('calculateBtn');
    const form = document.querySelector('form');
    const lockLabel = document.getElementById('lock-label');


    const userRole = "<?= $role ?>";
    const BASE_SAVE = "<?= base_url('godmode/interest/save') ?>";
    const BASE_CREATE = "<?= base_url('godmode/interest/create') ?>";
    const BASE_HISTORY = "<?= base_url('godmode/interest/history') ?>";

    // Tambahkan event listener untuk form submit
    form.addEventListener('submit', function(e) {
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

    // Tampilkan pesan default saat pertama kali load
    tbody.innerHTML = `<tr><td colspan="2" class="text-center">No Calculation</td></tr>`;


    document.getElementById("amount").addEventListener("input", hitung);

    function hitung() {
        const input = parseFloat(document.getElementById("amount").value);
        tbody.innerHTML = "";

        if (isNaN(input) || input <= 0) {
            // Jika input kosong atau invalid, tampilkan pesan default
            tbody.innerHTML = `<tr><td colspan="2" class="text-center">No Calculation</td></tr>`;
            return;
        }

        let nilai = input;
        for (let i = 1; i <= 96; i++) {
            if (i <= 12) {
                nilai += (nilai * 1.5 / 100);
            } else if (i <= 36) {
                nilai += (nilai * 1 / 100);
            } else if (i <= 42) {
                nilai += (nilai * 10 / 100);
            } else if (i <= 48) {
                nilai += (nilai * 20 / 100);
            } else if (i <= 60) {
                nilai += (nilai * 1.5 / 100);
            } else if (i <= 84) {
                nilai += (nilai * 1 / 100);
            } else if (i <= 90) {
                nilai += (nilai * 10 / 100);
            } else {
                nilai += (nilai * 20 / 100);
            }

            let highlight = "";
            if ([12, 48, 96].includes(i)) {
                highlight = 'style="background:lightgreen; color:black;"';
            }

            const row = `<tr ${highlight}>
                <td class="text-center">Calculate : ${i}</td>
                <td class="text-center">${nilai.toFixed(6)}</td>
            </tr>`;
            tbody.innerHTML += row;
        }
    }

    // 🔹 Load history data
    fetch(BASE_HISTORY)
        .then(res => res.json())
        .then(resp => {
            if (resp.status === 404 && userRole != 'superadmin') {
                lockLabel?.remove();
            }

            if (resp.status === 200 && resp.result && resp.result.data) {
                const d = resp.result.data;

                if (d.lock_amount === "0" && userRole !== "superadmin") {
                    lockLabel?.remove();
                }

                // Kalau ada data → SAVE
                form.action = BASE_SAVE;
                calculateBtn.textContent = "Update Calculate";

                // tambahkan input hidden id jika belum ada
                let hiddenId = document.getElementById('interest_id');
                if (!hiddenId) {
                    hiddenId = document.createElement('input');
                    hiddenId.type = "hidden";
                    hiddenId.name = "id";
                    hiddenId.id = "interest_id";
                    form.appendChild(hiddenId);
                }
                hiddenId.value = d.id;

                // Prefill form
                amount.value = d.amount ?? '';

                if (userRole != 'superadmin') {
                    // console.log(d.lock_amount);
                    //const lockAmountInput = document.querySelector('input[name="lock_amount"]');
                    const amountInput = document.getElementById('amount');

                    //if (lockAmountInput) {
                    if (d.lock_amount === "1") {
                        // Lock amount → disable input dan tandai
                        //lockAmountInput.remove();
                        amountInput.disabled = true;
                        amountInput.classList.add('locked-input');
                        calculateBtn.disabled = true;
                    } else {
                        // Jika tidak dikunci → hapus checkbox
                        //lockAmountInput.parentElement.remove();
                    }
                    //}
                }

                // isi chckbox jika rolenya superadmin
                if (userRole === 'superadmin') {
                    document.querySelector('[name="lock_amount"]').checked = d.lock_amount === "1";
                }
                hitung()
            } else {
                // Kalau tidak ada data → CREATE
                calculateBtn.textContent = "Calculate & Save";
                form.action = BASE_CREATE;
            }
        })
        .catch(err => {
            console.error('Error fetching history:', err);
            form.action = BASE_CREATE; // fallback
        });
</script>