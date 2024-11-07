<?php if(!empty(session('failed'))) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('failed')?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="payment-form" action="<?=BASE_URL?>widget/subscription/subsproccess?mail=<?= $email?>" method="POST">
            <div class="subs">
                <div class="title-top">
                    <h1 class="title">Subscribe</h1>
                    <span class="desc">Please choose your subscription</span>
                </div>
                <div class="list-subs">
                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[0]->price*1).',1 Month Regular' : ($subsprice[0]->ref_price*1).',1 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                        >
                        <div class="plan-details">
                            <div class="plan-header">
                                <h4 class="plan-title">1 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="<?= (empty($ref)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*1?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*1 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[0]->price*3).',3 Month Regular' : ($subsprice[0]->ref_price*3).',3 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                        >
                        <div class="plan-details">
                            <div class="plan-header">
                                <h4 class="plan-title">3 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="<?= (empty($ref)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*3?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*3 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[0]->price*6).',6 Month Regular' : ($subsprice[0]->ref_price*6).',6 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                        >
                        <div class="plan-details">
                            <div class="plan-header">
                                <h4 class="plan-title">6 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="<?= (empty($ref)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*6?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*6 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[0]->price*12).',1 Year Regular' : ($subsprice[0]->ref_price*12).',1 Year With Referral' ?>" 
                            class="radio" 
                            type="radio"
                            checked
                        >
                        <div class="plan-details">
                            <div class="plan-header">
                                <h4 class="plan-title">1 Year</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="<?= (empty($ref)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*12?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*12 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <div class="mt-3 f-poppins">
                        <small class="text-white">Please fill your card*</small>
                        <div id="card-element" class="StripeElement"></div>
                        <div class="card-brand" id="card-brand"></div>
                    </div>
                    <div class="text-white mt-2" id="card-errors"></div>
                </div>
                <div class="text-danger" id="card-errors"></div>
                <div class="d-flex justify-content-center mt-5">
                    <!-- <a href="" class="btn-subs-continue mx-2">Back</a> -->
                    <button type="submit" class="btn-subs-continue mx-2">
                        Continue
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
