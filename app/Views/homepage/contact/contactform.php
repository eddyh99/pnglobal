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
            <form id="contact-form" action="<?= BASE_URL ?>homepage/contactform_proccess" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="subject" value="<?= $subject?>">
                <div class="img-fluid wrapper-field">
                    <h1 class="fw-bold f-cormorant mb-3">Contact Form</h1>
                    <div class="bg-field">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end">
                            <div class="mt-5 f-poppins pe-4">
                                <label for="fname">Full Name</label> <br>
                                <input id="fname" name="fname" class="inp-fname mt-1 img-fluid w-100" type="text" required placeholder="Name">
                            </div>
                            <div class="mt-5 f-poppins">
                                <input id="lname" name="lname" class="inp-fname mt-1 img-fluid w-100" type="text" required placeholder="Last Name">
                            </div>
                        </div>
    
                        <div class="mt-5 f-poppins">
                            <label class="label-email" for="email">Email </label><br>
                            <input id="email" class="inp-email mt-1 img-fluid" name="email" type="email" required placeholder="Enter email address"> <br>
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
