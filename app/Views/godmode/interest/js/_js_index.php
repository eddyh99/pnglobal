<!-- <script>
    function hitung() {
        const input = parseFloat(document.getElementById("amount").value);
        const tbody = document.querySelector("#history-table tbody");
        tbody.innerHTML = "";

        let nilai = input;
        for (let i = 1; i <= 96; i++) {
            if (i <= 12) {
                nilai = nilai + (nilai / 100 * 1.5);
            } else if (i <= 36) {
                nilai = nilai + (nilai / 100 * 1);
            } else if (i <= 42) {
                nilai = nilai + (nilai / 100 * 10);
            } else if (i <= 48) {
                nilai = nilai + (nilai / 100 * 20);
            } else if (i <= 60) {
                nilai = nilai + (nilai / 100 * 1.5);
            } else if (i <= 84) {
                nilai = nilai + (nilai / 100 * 1);
            } else if (i <= 90) {
                nilai = nilai + (nilai / 100 * 10);
            } else {
                nilai = nilai + (nilai / 100 * 20);
            }

            let highlight = "";
            if (i === 12 || i === 48 || i === 96) {
                highlight = 'style="background:lightgreen;"';
            } else if (i === 36 || i === 42 || i === 60 || i === 84 || i === 90) {
                highlight = 'style="background:red;"';
            }


            const row = `<tr ${highlight}>
        <td> Calculate :${i}</td>
        <td>${nilai.toFixed(6)}</td>
      </tr>`;
            tbody.innerHTML += row;
        }
    }
</script> -->

<!-- <script>
    document.getElementById("calcForm").addEventListener("submit", function(e) {
        e.preventDefault(); // stop page reload
        hitung();
    });

    function hitung() {
        const input = parseFloat(document.getElementById("amount").value);
        if (isNaN(input) || input <= 0) {
            alert("Please enter a valid amount!");
            return;
        }

        const tbody = document.querySelector("#history-table tbody");
        tbody.innerHTML = "";

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
            } else if ([36, 42, 60, 84, 90].includes(i)) {
                highlight = 'style="background:red; color:black;"';
            }

            const row = `<tr ${highlight}>
                <td>Calculate : ${i}</td>
                <td>${nilai.toFixed(6)}</td>
            </tr>`;
            tbody.innerHTML += row;
        }
    }
</script> -->

<!-- <script>
    document.getElementById("amount").addEventListener("input", hitung);

    function hitung() {
        const input = parseFloat(document.getElementById("amount").value);
        const tbody = document.querySelector("#history-table tbody");
        tbody.innerHTML = "";

        if (isNaN(input) || input <= 0) {
            return; // jangan hitung kalau kosong atau tidak valid
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
                <td>Calculate : ${i}</td>
                <td>${nilai.toFixed(6)}</td>
            </tr>`;
            tbody.innerHTML += row;
        }
    }
</script> -->

<script>
    const tbody = document.querySelector("#history-table tbody");

    // Tampilkan pesan default saat pertama kali load
    tbody.innerHTML = `<tr><td colspan="2" class="text-center">Belum ada calculation</td></tr>`;

    document.getElementById("amount").addEventListener("input", hitung);

    function hitung() {
        const input = parseFloat(document.getElementById("amount").value);
        tbody.innerHTML = "";

        if (isNaN(input) || input <= 0) {
            // Jika input kosong atau invalid, tampilkan pesan default
            tbody.innerHTML = `<tr><td colspan="2" class="text-center">Belum ada calculation</td></tr>`;
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
</script>