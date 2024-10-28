<?php require_once("countries-list.php")?>
<div class="contact wrapper" style="margin-top: 96px;">
    <div class="row">
    <div class="col-5 d-none d-lg-block bg-contact-wrap position-relative">
            <div class="bg-contact d-flex flex-column justify-content-between align-items-center">
                <div class="logo mx-auto">
                    <img class="img-fluid" src="<?= BASE_URL ?>assets/img/logo.png" alt="logo">
                    <div class="text">
                        <p>
                            Transforming visions <br>
                            <span  style="color: #BFA573;">
                                into success
                            </span>
                        </p>    
                    </div>               
                </div>
                <div class="bg-dollar">
                    <img src="<?= BASE_URL?>assets/img/bg-contactus.png" alt="bg-contactus">
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7 my-5 pt-3 px-5">
            <?php if (@isset($_SESSION["error_email"])) { ?>
                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="notif-login f-poppins"><?= $_SESSION["error_email"] ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            <?php } ?>

            <form id="payment-form" action="<?= BASE_URL?>homepage/booking_proccess" method="POST">
                <div class="img-fluid">
                    <h1 class="fw-bold f-cormorant">Summary Meeting</h1>
                    <p class="me-0 pe-0 me-md-5 pe-md-2">
                        This is summary for your schedule meeting, before we accept please confirm your payment of <?= (empty($_SESSION["referral"]) ? "EUR 200" : FEEMEETING )?>
                    </p>
                    <div class="mt-5 f-poppins pe-4">
                        <label for="fname">Full Name</label> <br>
                        <label class="fw-bold">
                            <?= $_SESSION['client']['fname']?> 
                            <?= $_SESSION['client']['lname']?>
                        </label>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="fname">Whatsapp mobile number </label> <br>
                        <label class="fw-bold">
                            <?= $_SESSION['client']['whatsapp']?> 
                        </label>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="fname">Email </label> <br>
                        <ul>
                            <?php foreach($_SESSION['client']['email'] as $email):?>
                                <li class="fw-bold">
                                    <?= $email?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="fname">Timezone </label> <br>
                        <label class="fw-bold">
                            <?= $_SESSION['client']['timezone']?> 
                            
                        </label>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="fname">Schedule</label> <br>
                        <label class="fw-bold">
                            <?php
                                $date = explode('#', $_SESSION['client']['datetime']);
                                $date = explode(' ', $date[0]);
                                echo $date[0];
                            ?>
                        </label><br>
                        <label class="fw-bold">
                            <?php
                                $date = explode('#', $_SESSION['client']['datetime']);
                                $date = explode(' ', $date[0]);
                                echo $date[1];
                            ?>
                            Until 
                            <?php
                                $date = explode('#', $_SESSION['client']['datetime']);
                                $date = explode(' ', $date[1]);
                                echo $date[1];
                            ?>
                        </label>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="fname">Description </label> <br>
                        <label class="fw-bold me-4">
                            <?= $_SESSION['client']['description']?> 
                        </label>
                    </div>

                    <div class="mt-3 f-poppins pe-4">
                        <small>Please fill your card*</small>
                        <div id="card-element" class="StripeElement"></div>
                        <div class="card-brand" id="card-brand"></div>
                    </div>
                    <div class="mt-3 f-poppins pe-4">
                        <label for="cardholder-name">Cardholder's Name</label>
                        <input type="text" id="cardholder-name" placeholder="Full Name" class="form-control" required>
                    </div>
                    
                    <div class="mt-3 f-poppins pe-4">
                        <label for="billing-address-line1">Billing Address</label>
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
        
                    <div class="mt-5 f-poppins">
                        <button type="submit" id="submit-button" class="btn btn-footer-contactform">CONFIRM</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spinner for Loading form -->
<div class="modal fade" id="loadingcontent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-body">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


