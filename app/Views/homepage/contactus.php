<div class="contact-us wrapper">
    <div class="row">
        <div class="col-4 d-none d-lg-block bg-contact-wrap position-relative">
            <div class="bg-contact">
                <div class="h-100 w-50 mx-auto text-white d-flex flex-column justify-content-center align-items-center">
                    <img class="img-fluid" src="<?= BASE_URL ?>assets/img/logo.png" alt="logo">
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

  



            <form action="<?= BASE_URL ?>homepage/contactus_summary" method="POST">
                <div class="img-fluid">
                    <h1 class="fw-bold f-cormorant">Contact Form</h1>
                    <p class="me-0 pe-0 me-md-5 pe-md-5">
                        Fill out the form below to request a personalized consultation. <br>
                        One of our experts will contact you as soon as possible to discuss your needs and provide you with a tailored solution.
                    </p>
                    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                        <div class="mt-5 f-poppins pe-4">
                            <label for="fname">Full Name</label> <br>
                            <input id="fname" name="fname" class="inp-fname mt-3 img-fluid w-100" type="text" required placeholder="Name">
                        </div>
                        <div class="mt-5 f-poppins">
                            <input id="lname" name="lname" class="inp-fname mt-3 img-fluid w-100" type="text" required placeholder="Last Name">
                        </div>
                    </div>

                    <div class="mt-5 f-poppins">
                        <label class="label-email" for="email">Email <span>(Default)</span></label> <br>
                        <input id="email" class="inp-email mt-3 img-fluid" name="email[]" type="email" required placeholder="Enter email address"> <br>
                        <div class="mt-3 add-more pe-auto" id="addemail">
                            + Add more emails
                        </div>
                    </div>

                    <div class="mt-5 f-poppins">
                        <label class="label-email" for="phone">Whatsapp mobile number *</label> <br>
                        <input name="whatsapp" id="telephone" autocomplate="false" class="whatsapp nohp-select input-nohp" type="tel" required>
                    </div>
                    <br>
                    <div class="mt-4 f-poppins">
                        <label class="label-desc" for="desc">Description</label> <br>
                        <textarea class="textarea-desc img-fluid" id="desc" name="desc" type="text" placeholder="Enter description"></textarea>
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
                    <div class="mt-5 f-poppins">
                        <button type="submit" class="btn btn-navbar px-4 px-md-5 py-3 f-outfit d-block mx-auto mx-lg-1">CONFIRM</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
