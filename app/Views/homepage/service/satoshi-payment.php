<?php require_once("countries-list.php")?>
<section  class="service-homepage mb-5">
    <div class="wrapper-big-title">
        <h1 class="fw-bold text-uppercase">
            Select the duration of your subscription.
        </h4>
    </div>
</section>

<div class="conatiner">
    <div class="row">
        <div class="col-10 col-lg-6 mx-auto">
            <div class="show-failed"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <?php if(!empty(session('failed'))) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>
                    <?= session('failed')?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


<form id="payment-form" method="POST" action="<?= BASE_URL?>homepage/satoshi_register_process/<?= base64_encode($member->email)?>">
    <section class="satoshi-register-payment">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="row gy-3">
                        <div class="col-6 col-lg-3">
                            <label class="plan-btn">
                                <input type="radio" name="plan" value="1m" />
                                <span>1 Month</span>
                            </label>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label class="plan-btn">
                                <input type="radio" name="plan" value="3m" />
                                <span>3 Months</span>
                            </label>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label class="plan-btn">
                                <input type="radio" name="plan" value="6m" />
                                <span>6 Months</span>
                            </label>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label class="plan-btn">
                                <input type="radio" name="plan" value="1y" checked />
                                <span>1 Year</span>
                            </label>
                        </div>
                    </div>
                </div>    
            </div>

            <h2 class="fw-bold mt-5 mb-4 text-center">Summary</h2>
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="summary-box flex-grow-1 me-2">PRICE</div>
                        </div>
                        <div class="col-6 col-md-8">
                            <div id="current-price" class="summary-box text-end flex-grow-1">
                                € <?= $price['1y']; ?>
                            </div>
                            <input type="hidden" id="price" name="price" value="<?= $price['1y']; ?>">
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="summary-box flex-grow-1 me-2">REFERRAL DISCOUNT</div>
                        </div>
                        <div class="col-6 col-md-8">
                            <div id="current-reff" class="summary-box text-end flex-grow-1">
                                <?= (empty($member->id_referral)) ? '€ 0' : '€ 300' ?>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="summary-box flex-grow-1 me-2">TOTAL PAYMENT</div>

                        </div>
                        <div class="col-6 col-md-8">
                            <div id="total-price" class="summary-box text-end flex-grow-1">
                                <?= (empty($member->id_referral)) ? '€ '.$price['1y'] : '€ '.$price['1y']-300 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="row g-4">
                        <div class="col-10 mx-auto">
                            <div class="mt-3 f-poppins pe-4">
                                <small class="text-black">Please fill your card*</small>
                                <div id="card-element" class="StripeElement"></div>
                                <div class="card-brand" id="card-brand"></div>
                                <div class="text-danger" id="card-errors"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="text" id="cardholder-name" placeholder="Full Name" class="form-control " required>
                        </div>
                        <div class="col-6">
                            <input type="text" id="billing-address-line1"  class="form-control " placeholder="Address Line 1" required>
                        </div>
                        <div class="col-6">
                            <input type="text" id="billing-address-city"  class="form-control " placeholder="City" required>
                        </div>
                        <div class="col-6">
                            <input type="text" id="billing-address-state"  class="form-control " placeholder="State" required>
                        </div>
                        <div class="col-6">
                            <input type="text" id="billing-address-zip"  class="form-control " placeholder="Postal Code" required>
                        </div>
                        <div class="col-6">
                            <select id="billing-address-country" class="form-control " required>
                                <option value>---- Country ----</option>
                                <?php foreach($countries_list  as $dt){?>
                                    <option value="<?=$dt["code"]?>"><?=$dt["name"]?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-center">
                <button id="submit-button" type="submit" class="btn btn-satoshi-price-register fs-6">PAY NOW</button> 
            </div>
        </div>
    </section>
</form>
