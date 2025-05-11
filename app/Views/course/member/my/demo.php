<?= view($menu); ?>
<div class="container-fluid bg-dark text-white">
    <div class="row h-100">
        <!-- Sidebar Order Book -->
        <div class="col-3 bg-secondary p-3">
            <h5>Order Book</h5>
            <!-- Konten order book -->
        </div>

        <!-- Main Content -->
        <div class="col bg-black p-3 d-flex flex-column">
            <!-- Tab Header -->
            <div class="row mb-3">
                <div class="col">Spot</div>
                <div class="col">My Trades</div>
            </div>

            <!-- Order Section -->
            <div class="row flex-grow-1 overflow-auto">
                <div class="col">
                    <!-- Konten order panjang di sini -->
                    order
                </div>
            </div>
        </div>
    </div>
</div>
