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
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <a href="javascript:void(0);" class="tab-item" data-tab="pn-global">PN GLOBAL</a>
            <a href="javascript:void(0);" class="tab-item" data-tab="satoshi-signal">SATOSHI SIGNAL</a>
        </div>

        <!-- Tab Contents -->
        <div id="pn-global" class="tab-content" style="display: none;">
            <div class="row content-body">
                <div class="col-lg-12 px-2">
                    <div class="dash-statistics">
                        <a href="<?= BASE_URL ?>godmode/dashboard" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Total Member</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$totalmemberpnglobal ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "free_member" || base64_decode(@$_GET["type"]) == "referral_member") ? "disable" : "active") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="<?= BASE_URL ?>godmode/dashboard?type=<?= base64_encode("free_member") ?>" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Free Member</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$freememberpnglobal ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "free_member") ? "active" : "disable") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Subscriber</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$subscriberpnglobal ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "referral_member") ? "active" : "disable") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Signal Sent</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$signalpnglobal ?></h1>
                                        </div>
                                    </div>
                                    <div class="disable"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php if (base64_decode(@$_GET["type"]) != "free_member") { ?>
                    <div class="col-lg-12 dash-table-totalmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Total Member</h4>
                        <table id="table_totalmember" class="table table-striped" style="width:100%">
                            <thead class="thead_totalmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>REF CODE</th>
                                    <!-- <th>REG. DATE</th> -->
                                    <th>STATUS</th>
                                    <th>SUBSCRIPTION</th>
                                    <th>REFERRAL</th>
                                    <th>CAPITAL</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } else if (base64_decode(@$_GET["type"]) == "free_member") { ?>
                    <div class="col-lg-12 dash-table-freemember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Free Member</h4>
                        <table id="table_freemember" class="table table-striped" style="width:100%">
                            <thead class="thead_freemember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>REF CODE</th>
                                    <th>START DATE</th>
                                    <th>END DATE</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } else if (base64_decode(@$_GET["type"]) == "referral_member") { ?>
                    <div class="col-lg-12 dash-table-referralmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Referral Member</h4>
                        <table id="table_referralmember" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>TOTAL REFERRAL</th>
                                    <th>MONTHLY REFERRAL</th>
                                    <th>UNPAID SUBSCRIPTIONS</th>
                                    <th>UNPAID COMMISSION</th>
                                    <th>UNPAID COMMISSION PREVIOUS MONTH</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="satoshi-signal" class="tab-content" style="display: none;">
            <div class="row content-body">
                <div class="col-lg-12 px-2">
                    <div class="dash-statistics">
                        <a href="<?= BASE_URL ?>godmode/dashboard" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Total Member</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$totalmembersatoshi ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "free_member" || base64_decode(@$_GET["type"]) == "referral_member") ? "disable" : "active") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="<?= BASE_URL ?>godmode/dashboard?type=<?= base64_encode("free_member") ?>" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Free Member</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$freemembersatoshi ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "free_member") ? "active" : "disable") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="<?= BASE_URL ?>godmode/subscriber" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Subscriber</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$subscriptionsatoshi ?></h1>
                                        </div>
                                    </div>
                                    <div class="<?= ((base64_decode(@$_GET["type"]) == "referral_member") ? "active" : "disable") ?>"></div>
                                </div>
                            </div>
                        </a>
                        <a href="<?= BASE_URL ?>godmode/message" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Message</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$messagesatoshi ?></h1>
                                        </div>
                                    </div>
                                    <div class="disable"></div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="statistics">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <div>
                                            <h5 class="text-black">Signal Sent</h5>
                                        </div>
                                        <div class="mt-3 w-100 d-flex justify-content-end">
                                            <h1 class="text-black fw-bold"><?= @$signalsatoshi ?></h1>
                                        </div>
                                    </div>
                                    <div class="disable"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php if (base64_decode(@$_GET["type"]) != "free_member" && base64_decode(@$_GET["type"]) != "referral_member") { ?>
                    <div class="col-lg-12 dash-table-totalmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Total Member</h4>
                        <table id="table_totalmember" class="table table-striped" style="width:100%">
                            <thead class="thead_totalmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>REF CODE</th>
                                    <th>REG. DATE</th>
                                    <th>STATUS</th>
                                    <th>SUBSCRIPTION</th>
                                    <th>REFERRAL</th>
                                    <th>UNPAID</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } else if (base64_decode(@$_GET["type"]) == "free_member") { ?>
                    <div class="col-lg-12 dash-table-freemember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Free Member</h4>
                        <table id="table_freemember" class="table table-striped" style="width:100%">
                            <thead class="thead_freemember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>REGISTRATION DATE</th>
                                    <th>END DATE</th>
                                    <th>STATUS</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } else if (base64_decode(@$_GET["type"]) == "referral_member") { ?>
                    <div class="col-lg-12 dash-table-referralmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Referral Member</h4>
                        <table id="table_referralmember" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>TOTAL REFERRAL</th>
                                    <th>MONTHLY REFERRAL</th>
                                    <th>UNPAID SUBSCRIPTIONS</th>
                                    <th>UNPAID COMMISSION</th>
                                    <th>UNPAID COMMISSION PREVIOUS MONTH</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>