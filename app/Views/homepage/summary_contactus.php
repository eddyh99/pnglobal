<div class="contact-us wrapper">
    <div class="row">
        <div class="col-4 d-none d-lg-block bg-contact-wrap position-relative">
            <div class="bg-contact">
                <div class="h-100 w-50 mx-auto text-white d-flex flex-column justify-content-center align-items-center">
                    <img class="img-fluid" src="<?= base_url()?>assets/img/logo.png" alt="logo">       
                    <div>
                        <p class="fs-5 text-center text-white fw-bold text-uppercase"  style="letter-spacing: 8px;">
                            Transforming visions <br>
                            <span  style="color: #BFA573;">
                                into success
                            </span>
                        </p>    
                    </div>            
                </div>

            </div>
            
        </div>
        <div class="col-12 col-lg-8 my-5 pt-3 px-5">
            <?php if (@isset($_SESSION["error_email"])) { ?>
                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="notif-login f-poppins"><?= $_SESSION["error_email"] ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            <?php } ?>

            <form id="payment-form" action="<?= base_url()?>homepage/contactus_proccess" method="POST">
                <div class="img-fluid">
                    <h1 class="fw-bold f-cormorant">Summary Meeting</h1>
                    <p class="me-0 pe-0 me-md-5 pe-md-5">
                        This is summary for your schedule meeting, before we accept please confirm your payment of <?= FEEMEETING?>
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
        
                    <div class="mt-5 f-poppins">
                        <button type="submit" class="btn btn-navbar px-4 px-md-5 py-3 f-outfit d-block mx-auto mx-lg-1">CONFIRM</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>


