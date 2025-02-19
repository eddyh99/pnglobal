<?php if (!empty(session('failed'))) { ?>
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
            </div>
            <div class="col-lg-10 mx-auto">

                <h4 class="text-center"><?= $email; ?></h4>

                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Detail</div>

                    <!-- Membership Status -->
                    <div class="label">Membership Status</div>
                    <div class="value">
                        <?= $member->message->membership_status; ?>
                    </div>

                    <!-- Registration date -->
                    <div class="label">Registration date</div>
                    <div class="value">
                        <?php
                        $dateString = $member->message->start_date;
                        $date = new DateTime($dateString);
                        $formattedDate = $date->format('d F Y');
                        echo $formattedDate;
                        ?>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Subscription Status</div>
                    <div class="value"><?= $member->message->subscription_status ?></div>

                    <!-- Subscription Plan -->
                    <div class="label">Subscription Plan</div>
                    <div class="value">
                        <?= $member->message->subscription_plan ?>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Referral Code</div>
                    <div class="value"><?= $member->message->refcode ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upgrade Modal -->
<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content upgrade-member">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="upgradeModalLabel">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-black" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $currentDate = new DateTime();
                $currentDate->modify('+1 month');
                $tgl = $currentDate->format('Y-m-d');
                ?>

                <form method="POST" action="<?= BASE_URL ?>godmode/dashboard/upgrademember">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>You will upgrade this member to FREE</p>
                        <h4 class="my-4"><?= $email; ?></h4>
                        <input type="text" name="expired" id="expired" value="<?= $tgl ?>" class="form-control text-black">
                        <button class="btn-modal-upgrade mb-4 mt-4">Upgrade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>