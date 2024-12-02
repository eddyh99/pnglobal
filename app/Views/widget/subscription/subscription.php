<?php if(!empty(session('failed'))) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('failed')?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>
<?php require_once("countries-list.php")?>
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
                            value="<?= (empty($ref)) ? ($subsprice[3]->price).',12 Year Regular' : ($subsprice[3]->ref_price).',12 Year With Referral' ?>" 
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
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[3]->price?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[3]->ref_price ?></span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[2]->price).',6 Month Regular' : ($subsprice[2]->ref_price).',6 Month With Referral' ?>" 
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
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[2]->price?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[2]->ref_price ?></span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[1]->price).',3 Month Regular' : ($subsprice[1]->ref_price).',3 Month With Referral' ?>" 
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
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[1]->price?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[1]->ref_price ?></span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card mt-3">
                        <input 
                            name="subs" 
                            value="<?= (empty($ref)) ? ($subsprice[0]->price).',1 Month Regular' : ($subsprice[0]->ref_price).',1 Month With Referral' ?>" 
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
                                    <span class="<?= (empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="<?= (!empty($ref)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="<?= (!empty($ref)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price ?></span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <div class="mt-3 f-poppins pe-4">
                        <small class="text-white">Please fill your card*</small>
                        <div id="card-element" class="StripeElement"></div>
                        <div class="card-brand" id="card-brand"></div>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label class="text-white" for="cardholder-name">Cardholder's Name</label>
                        <input type="text" id="cardholder-name" placeholder="Full Name" class="form-control" required>
                    </div>
                    
                    <div class="mt-3 f-poppins pe-4">
                        <label class="text-white" for="billing-address-line1">Billing Address</label>
                        <input type="text" id="billing-address-line1"  class="form-control mt-1" placeholder="Address Line 1" required>
                        <input type="text" id="billing-address-city"  class="form-control mt-1" placeholder="City" required>
                        <input type="text" id="billing-address-state"  class="form-control mt-1" placeholder="State" required>
                        <input type="text" id="billing-address-zip"  class="form-control mt-1" placeholder="Postal Code" required>
                        <select id="billing-address-country" class="form-control mt-1" required>
                            <option value>---- Country ----</option>
                            <?php foreach($countries_list  as $dt){?>
                                <option value="<?=$dt["code"]?>"><?=$dt["name"]?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="text-danger" id="card-errors"></div>
                <div class="d-flex justify-content-center mt-5">
                    <!-- <a href="" class="btn-subs-continue mx-2">Back</a> -->
                    <button type="submit" id="submit-button" class="btn-subs-continue mx-2">
                        Continue
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
