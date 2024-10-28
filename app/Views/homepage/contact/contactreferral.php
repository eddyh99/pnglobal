<div class="contact wrapper" style="margin-top: 96px;">
    <div class="row">
        <div class="col-5 d-none d-lg-block bg-contact-wrap position-relative">
            <div class="bg-contact d-flex flex-column justify-content-between align-items-center">
                <div class="logo mx-auto">
                    <img class="img-fluid" src="<?= BASE_URL ?>assets/img/logo.png" alt="logo">
                    <div class="text">
                        <p>
                            Asset <br>
                            <span  style="color: #BFA573;">
                                Management
                            </span>
                        </p>    
                    </div>               
                </div>
                <div class="bg-dollar">
                    <img src="<?= BASE_URL?>assets/img/bg-contactus.png" alt="bg-contactus">
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7 mb-5 pt-3 px-5">  
            <?php if(!empty(session('success'))) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>
                        <?= session('success')?>
                    </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <?php if(!empty(session('failed'))) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>
                        <?= session('failed')?>
                    </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="d-flex justify-content-end">
                <a href="<?= BASE_URL?>">
                    <svg width="42" height="43" viewBox="0 0 42 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="2.25" width="40.25" height="40.25" rx="9.5" fill="black" stroke="#BFA573"/>
                        <path d="M10.913 31L18.511 20.618V24.446L11.145 14.238H17.409L21.73 20.473L19.062 20.502L23.325 14.238H29.357L22.02 24.214V20.473L29.705 31H23.296L18.946 24.475H21.556L17.293 31H10.913Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <form id="contact-form" action="<?= BASE_URL ?>homepage/contactreferral_proccess" method="POST" enctype="multipart/form-data">
                <div class="img-fluid wrapper-field">
                    <h3 class="fw-bold f-odor mb-3">Contact Form</h3>
                    <p>
                        It will be our unquestionable judgment to grant or not to grant and revoke the referral code. ONCE THE REQUEST HAS BEEN APPROVED YOU WILL RECEIVE AN EMAIL WITH YOUR PERSONAL REFERRAL CODE.
                    </p>
                    <p>
                        Guide to the Referral Program and Collection Criteria
                    </p>
                    <p>
                        he referral program provides an exclusive opportunity to enhance your earnings by attracting new subscribers to our service. The mechanism is structured as follows:
                    </p>
                    <ol>
                        <li>
                            Referral Income: Every time a user signs up using your referral code and proceeds to pay, you will be entitled to a fixed income equal to €25 for each month covered by the subscription signed by the new user. Referral payments will be disbursed on the 20th of the month following the completion of a dispute-free validation period. For instance, if a quarterly subscription is activated on September 8th and no disputes arise by October 30th, the referral compensation will be credited on November 20th.
                        </li>
                        <li>
                            Compensation Calculation: The compensation you accrue will be directly proportional to the duration of the subscription chosen by the user. For illustration, if the user opts for a six-month subscription, your earnings will amount to €150, which corresponds to €25 multiplied by the 6-month subscription period.
                        </li>
                        <li>
                            Subscription Plan Upgrade: If the user chooses to upgrade his subscription plan to a higher level, your compensation will be recalculated based on his new subscription configuration. For example, if the user initially signs up for a quarterly subscription and after one month updates it to a six-monthly subscription, the overall period will be 9 months (first quarterly subscription plus the second six-monthly subscription), subtracting the month from the duration of the subscription. already passed. Consequently, the referral income will be calculated on the new number of months minus the month already paid.
                        </li>
                    </ol>
                    <div class="bg-field">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-2 f-poppins pe-4">
                                <label for="fname">Full Name</label> <br>
                                <input id="fname" name="fname" class="inp-fname mt-1 img-fluid w-100" type="text" required placeholder="First Name">
                            </div>
                            <div class="mt-2 f-poppins">
                                <input id="lname" name="lname" class="inp-fname mt-1 img-fluid w-100" type="text" required placeholder="Last Name">
                            </div>
                        </div>
                        <div class="mt-3 f-poppins pe-4">
                            <label class="label-email" for="email">Email </label><br>
                            <input id="email" class="inp-email mt-1 img-fluid" name="email" type="email" required placeholder="Enter email address"> <br>
                        </div>
                        <div class="mt-3 f-poppins">
                            <label class="label-email" for="phone">Whatsapp mobile number *</label> <br>
                            <input name="whatsapp" id="telephone" autocomplate="false" class="whatsapp nohp-select input-nohp" type="tel" required>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-3 f-poppins pe-4">
                                <label for="mtongue">Mother Tongue</label> <br>
                                <input id="mtongue" name="mtongue" class="inp-fname mt-1 img-fluid w-100" type="text" required >
                            </div>
                            <div class="mt-3 f-poppins">
                                <label for="language">Language used for posting</label> <br>
                                <input id="language" name="language" class="inp-fname mt-1 img-fluid w-100" type="text" required>
                            </div>
                        </div>
                        <div class="mt-3 f-poppins">
                            <label for="country">Country of residence</label> <br>
                            <input id="country" name="country" class="inp-fname mt-1 img-fluid" type="text" required>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-3 f-poppins pe-4">
                                <label for="instagram">Instagram profile (Link)</label> <br>
                                <input id="instagram" name="instagram" class="inp-fname mt-1 img-fluid w-100" type="text" >
                            </div>
                            <div class="mt-3 f-poppins">
                                <label for="tiktok">TikTok profile (Link)</label> <br>
                                <input id="tiktok" name="tiktok" class="inp-fname mt-1 img-fluid w-100" type="text">
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-3 f-poppins pe-4">
                                <label for="fprofile">Facebook profile (Link)</label> <br>
                                <input id="fprofile" name="fprofile" class="inp-fname mt-1 img-fluid w-100" type="text" >
                            </div>
                            <div class="mt-3 f-poppins">
                                <label for="fgroup">Facebook group (Link)</label> <br>
                                <input id="fgroup" name="fgroup" class="inp-fname mt-1 img-fluid w-100" type="text">
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-3 f-poppins pe-4">
                                <label for="fpage">Facebook  page (Link)</label> <br>
                                <input id="fpage" name="fpage" class="inp-fname mt-1 img-fluid w-100" type="text">
                            </div>
                            <div class="mt-3 f-poppins">
                                <label for="linkedin">Linkedin profile (Link)</label> <br>
                                <input id="linkedin" name="linkedin" class="inp-fname mt-1 img-fluid w-100" type="text">
                            </div>
                        </div>
                        <div class="mt-3 f-poppins">
                            <label for="discord">Discord profie (Link)</label> <br>
                            <input id="discord" name="discord" class="inp-fname mt-1 img-fluid" type="text">
                        </div>          
                        <div class="mt-3 f-poppins">
                            <label for="fname">Upload a valid identity document (PDF)</label><br>
                            <input type="file" id="identity-ref" name="identity" accept="application/pdf" hidden/ required>
                            <label for="identity-ref" class="inp-file-identity p-2">+ Upload</label>
                            <span id="file-chosen">No file chosen</span>
                        </div>          
                        <div class="mt-5 f-poppins">
                            <button type="submit" class="btn btn-footer-contactform">CONFIRM</button>
                        </div>
                    </div>
                    
                </div>
            </form>
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

