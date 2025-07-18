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
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <a class="text-white" href="<?= BASE_URL ?>/godmode/onetoone/dashboard">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <h4 class="text-center"><?= $member->email ?></h4>

                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember mt-5">
                        <h4 class="text-white my-3 text-uppercase fw-bold">PAYMENT</h4>

                        <table class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>NO</th>
                                    <th>STATUS</th>
                                    <th>INVOICE DATE</th>
                                    <th>INVOICE LINK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($payment as $data) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->status_invoice ?></td>
                                        <td><?= date('Y-m-d', strtotime($data->invoice_date)) ?></td>
                                        <td><a href="<?= $data->link_invoice ?>" target="_blank">Invoice Link</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>