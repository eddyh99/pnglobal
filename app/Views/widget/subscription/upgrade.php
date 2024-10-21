<?php if(!empty(session('failed'))) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('failed')?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>
<?php require_once("countries-list.php")?>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <div class="subs">
            <!-- <div class="title-top">
                <h1 class="title">Upgrade Your Plan</h1>
            </div> -->
            <div class="list-subs">
                <form method="POST" id="checking-referral">
                    <div class="position-relative upgrade-plan">
                        <input <?= (!empty($member->id_referral) ? "disabled" : "" )?> type="text" id="referral" name="referral" class="form-control" placeholder="<?= (!empty($member->id_referral) ? "Alredy referral" : "Enter referral" )?> ">
                        <button <?= (!empty($member->id_referral) ? "disabled" : "" )?> type="submit" id="btn-referral-apply" class="btn btn-primary">Apply</button>
                    </div>  
                </form>
            </div>
            <form id="payment-form" action="<?=BASE_URL?>widget/subscription/upgrade_proccess" method="POST">
                <input type="hidden" name="email" value="<?= $member->email; ?>">
                <input type="hidden" name="new_referral" id="new-referral">
                <div class="list-subs mt-3">
                    <label class="card <?= (($member->total_period >= 30) ? "disabled" : "")?> mt-3">
                        <input 
                            id="plan-onemonth"
                            name="subs" 
                            value="<?= (empty($member->id_referral)) ? ($subsprice[0]->price*1).',1 Month Regular' : ($subsprice[0]->ref_price*1).',1 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                            <?= (($member->total_period >= 30) ? "disabled" : "")?>
                        >
                        <div class="plan-details">
                            <div class="plan-header <?= (($member->total_period >= 30) ? "disabled" : "")?>">
                                <h4 class="plan-title">1 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-regular <?= (empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="price-regular <?= (empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*1?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-referral <?= (!empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="price-referral <?= (!empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*1 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card <?= (($member->total_period >= 90) ? "disabled" : "")?> mt-3">
                        <input 
                            id="plan-threemonth"
                            name="subs" 
                            value="<?= (empty($member->id_referral)) ? ($subsprice[0]->price*3).',3 Month Regular' : ($subsprice[0]->ref_price*3).',3 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                            <?= (($member->total_period >= 90) ? "disabled" : "")?>
                        >
                        <div class="plan-details">
                            <div class="plan-header <?= (($member->total_period >= 90) ? "disabled" : "")?>">
                                <h4 class="plan-title">3 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-regular <?= (empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="price-regular <?= (empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*3?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-referral <?= (!empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="price-referral <?= (!empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*3 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card <?= (($member->total_period >= 180) ? "disabled" : "")?> mt-3">
                        <input 
                            id="plan-sixmonth"
                            name="subs" 
                            value="<?= (empty($member->id_referral)) ? ($subsprice[0]->price*6).',6 Month Regular' : ($subsprice[0]->ref_price*6).',6 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                            <?= (($member->total_period >= 180) ? "disabled" : "")?>
                        >
                        <div class="plan-details">
                            <div class="plan-header <?= (($member->total_period >= 180) ? "disabled" : "")?>">
                                <h4 class="plan-title">6 Month</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-regular <?= (empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="price-regular <?= (empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*6?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-referral <?= (!empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="price-referral <?= (!empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*6 ?></span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="card <?= (($member->total_period >= 360) ? "disabled" : "")?> mt-3">
                        <input 
                            id="plan-oneyear"
                            name="subs" 
                            value="<?= (empty($member->id_referral)) ? ($subsprice[0]->price*12).',12 Month Regular' : ($subsprice[0]->ref_price*12).',12 Month With Referral' ?>" 
                            class="radio" 
                            type="radio"
                            <?= (($member->total_period >= 360) ? "disabled" : "")?>
                        >
                        <div class="plan-details">
                            <div class="plan-header <?= (($member->total_period >= 360) ? "disabled" : "")?>">
                                <h4 class="plan-title">1 Year</h4>
                            </div>
                            <div class="plan-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-regular <?= (empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">Regular</span>
                                    <span class="price-regular <?= (empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->price*12?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-referral <?= (!empty($member->id_referral)) ? 'left-active' : 'left-disable' ?>">With referral</span>
                                    <span class="price-referral <?= (!empty($member->id_referral)) ? 'right-active' : 'right-disable' ?>">€ <?= $subsprice[0]->ref_price*12 ?></span>
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
                <div class="d-flex justify-content-center mt-5">
                    <!-- <a href="" class="btn-subs-continue mx-2">Back</a> -->
                    <button type="submit" class="btn-subs-continue mx-2">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
