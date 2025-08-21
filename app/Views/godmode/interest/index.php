<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>
<!-- Page Content  -->
<div class="content-page">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="send-signals">
                    <form id="calcForm" action="" method="post">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Calculator Interest</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="amount">Amount</label>
                                        <div class="d-flex">
                                            <input type="number" id="amount" name="amount" class="form-control  no-spinner" placeholder="1000" step="any">
                                            <label class="d-flex align-items-center gap-1 ml-2" id="lock-label">
                                                <?php if ($_SESSION["logged_user"]->role=="superadmin"):?>                                                
                                                    <input type="checkbox" name="lock_amount" value="1">
                                                <?php endif;?>
                                                <p class="mb-0">🔒</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral d-flex justify-content-center mt-4">
                                        <button type="submit" id="calculateBtn" class="btn btn-primary">Calculate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center">
                        <table id="history-table" class="table table-striped" style="width:65%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th class="text-center">Calculate</th>
                                    <th class="text-center">Result</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>