    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="custom-card">
                    <p class="text-uppercase mb-0">MONTH</p>
                    <h2 id="month" class="mt-2 fw-bold">Loading ...</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-card">
                    <p class="text-uppercase mb-0">AVERAGE % MONTH</p>
                    <h2 id="average_month" class="mt-2 fw-bold">Loading ...</h2>
                </div>
            </div>
        </div>

        <div class="card shadow-sm p-4">
            <h4 class="card-title mb-4 fw-bold">HEDGEFUND RESULT</h4>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <label for="selectMonth" class="form-label mb-0 fs-6">Select Month</label>
                        <input type="month" id="selectMonth" class="form-control form-control-sm" />
                    </div>
                </div>
                <div class="ms-auto">
                    <input type="text" id="searchBox" class="form-control form-control-sm" placeholder="SEARCH" />
                </div>
            </div>

            <table id="myTable" class="table table-striped table-hover table-custom" style="width:100%">
                <thead>
                    <tr>
                        <th>BUY PRICE</th>
                        <th>SELL PRICE</th>
                        <th>NET HISTORICAL CUSTOMER %</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>