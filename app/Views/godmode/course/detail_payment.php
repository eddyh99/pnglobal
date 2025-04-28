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

<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                    <a class="text-white" href="<?= BASE_URL?>godmode/course/user">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <h4 class="text-center"><?= $user->email; ?></h4>

                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Detail</div>
                    
                    <!-- Membership Status -->
                    <div class="label">Status Payment</div>
                    <div class="value">
                        <span>
                            <?= $user->payment_status ?>
                        </span>
                        <a 
                            href="<?= BASE_URL ?>godmode/course/setuser_paid/<?= base64_encode($user->email) ?>"
                            id="btncancel"
                            class="upgrade-btn">  
                            Set Paid
                        </a>
                    </div>
                    
                    <!-- Registration date -->
                    <div class="label">Amount</div>
                    <div class="value">
                        <?= number_format($user->amount, 0) ?>
                    </div>

                     <!-- Payment Type -->
                     <div class="label">Payment Type</div>
                    <div class="value">
                        <?= $user->payment_type ?? '-' ?>
                    </div>

                     <!-- Payment Type -->
                     <div class="label">Url Payment</div>
                    <div class="value">
                        https://xxxxxx.pnglobal.com?amount=<?= $user->amount ?>
                        <button 
                            href="#"
                            id="btncancel"
                            class="upgrade-btn">  
                            Share
                        </button>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>