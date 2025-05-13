<div class="contact wrapper" style="margin-top: 77px;">
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
        <div class="col-12 col-lg-7 my-2 pt-3 px-5">  
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
            <form id="formbooking" action="<?= BASE_URL ?>homepage/booking_summary" method="POST">
                <input type="hidden" name="subject" value="<?= $subject?>">
                <input type="hidden" name="original_service" value="<?= isset($_GET['service']) ? $_GET['service'] : '' ?>">
                <div class="img-fluid wrapper-field">
                    <h1 class="fw-bold f-cormorant">Booking Consultation</h1>
                    <p class="me-0 pe-0 me-md-5 pe-md-5">
                        Fill out the form below to request a personalized consultation. <br>
                        One of our experts will contact you as soon as possible to discuss your needs and provide you with a tailored solution.
                    </p>
                    <div class="bg-field">
                        <div class="px-2" style="width: fit-content;margin: 0 auto;">


                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end gap-2">
                            <div class="mt-5 f-poppins w-100">
                                <label for="fname">Full Name</label> <br>
                                <input id="fname" name="fname" class="inp-fname mt-1 img-fluid" type="text" required placeholder="Name">
                            </div>
                            <div class="mt-5 f-poppins w-100">
                                <input id="lname" name="lname" class="inp-fname mt-1 img-fluid" type="text" required placeholder="Last Name">
                            </div>
                        </div>
    
                        <div class="mt-5 f-poppins">
                            <label class="label-email" for="email">Email <span>(Default)</span></label> <br>
                            <input id="email" class="inp-email mt-1 img-fluid" name="email[]" type="email" required placeholder="Enter email address"> <br>
                            <div class="mt-3 add-more pe-auto" id="addemail">
                                + Add more emails
                            </div>
                        </div>
    
                        <div class="mt-5 f-poppins">
                            <label class="label-email" for="phone">Whatsapp mobile number *</label> <br>
                            <input name="whatsapp" id="telephone" autocomplate="false" class="whatsapp mt-1 nohp-select input-nohp" type="tel" required>
                        </div>
                        <br>
                        <div class="mt-4 f-poppins">
                            <label class="label-desc" for="desc">Description</label> <br>
                            <textarea class="textarea-desc img-fluid mt-1" id="desc" name="desc" type="text" placeholder="Enter description"></textarea>
                        </div>
                        <div class="mt-5 f-poppins">
                            <label for="timezone">Select Your Time Zone:</label>
                            <select name="timezone" class="form-select inp-date img-fluid" id="timezone">
                                <?php 
                                    $timezones = DateTimeZone::listIdentifiers();
                                    foreach ($timezones as $timezoneIdentifier): 
                                    // Set the timezone
                                    $timezone = new DateTimeZone($timezoneIdentifier);
                                    // Create a DateTime object with the specified timezone
                                    $dateTime = new DateTime('now', $timezone);
                                    // Get the timezone offset in seconds
                                    $offsetSeconds = $timezone->getOffset($dateTime);
                                    // Convert the offset from seconds to hours and minutes
                                    $offsetHours = intdiv($offsetSeconds, 3600);
                                    $offsetMinutes = ($offsetSeconds % 3600) / 60;
                                    // Format the offset to include a plus or minus sign and leading zeros
                                    $offsetFormatted = sprintf("%+03d:%02d", $offsetHours, $offsetMinutes);
                                ?>
                                    <option <?= ($timezoneIdentifier == 'Asia/Makassar') ? 'selected' : ''?> value="<?= $timezoneIdentifier ?>">
                                        <?= $timezoneIdentifier . ' UTC'.$offsetFormatted?>
                                    </option>
                                <?php 
                                    endforeach; 
                                ?>
                            </select>
                        </div>
                        <div class="mt-5 f-poppins">
                            <label for="schedule">Select Slot Schedule:</label>
                            <select name="schedule" class="form-control schedule-select2 img-fluid" id="schedule">
                            </select>
                        </div>     
                        <!-- Temporarily disabled referral section
                        <div class="mt-5 f-poppins">
                            <label class="label-email" for="referral">Referral Code</label> <br>
                            <input id="referral" class="inp-email mt-1 img-fluid" name="referral" type="text" placeholder="Enter referral code (optional)"> <br>
                            <small>Without Referral : 350 EUR, With Referral : 250 EUR</small>
                        </div>          
                        -->
                        <div class="mt-5 f-poppins">
                            <button type="submit" class="btn btn-footer-contactform">CONFIRM</button>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>


