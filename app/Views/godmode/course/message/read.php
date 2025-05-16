<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="flex-grow-1 p-4 text-center">
            <div class="container">
                <h3 class="my-4">Message</h3>
                <div class="d-flex">
                    <a href="<?= BASE_URL . $url ?>message" class="btn mb-5"><i><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path id="Vector" d="M28.3941 0H11.6258C4.34216 0 0 4.34 0 11.62V28.36C0 35.66 4.34216 40 11.6258 40H28.3741C35.6578 40 39.9999 35.66 39.9999 28.38V11.62C40.0199 4.34 35.6778 0 28.3941 0ZM23.8519 28.26H14.007C13.1866 28.26 12.5062 27.58 12.5062 26.76C12.5062 25.94 13.1866 25.26 14.007 25.26H23.8519C26.4132 25.26 28.5142 23.18 28.5142 20.6C28.5142 18.02 26.4332 15.94 23.8519 15.94H13.7068L14.2271 16.46C14.8074 17.06 14.8074 18 14.2071 18.6C13.9069 18.9 13.5267 19.04 13.1466 19.04C12.7664 19.04 12.3862 18.9 12.086 18.6L8.94446 15.44C8.36417 14.86 8.36417 13.9 8.94446 13.32L12.086 10.18C12.6663 9.6 13.6268 9.6 14.2071 10.18C14.7874 10.76 14.7874 11.72 14.2071 12.3L13.5468 12.96H23.8519C28.074 12.96 31.5157 16.4 31.5157 20.62C31.5157 24.84 28.074 28.26 23.8519 28.26Z" fill="#B48B3D" />
                            </svg>
                        </i></a>
                </div>

                <div class="input-group mw-100 mb-0">
                    <input type="text" name="subject" class="form-control text-white border-primary" id="basic-url" aria-describedby="basic-addon3" style="background-color: transparent;" value="<?= $message['sent_date'] ?>" readonly>
                    <a href="<?= BASE_URL ?>course/message/compose" class="input-group-text btn rounded-0" style="padding: 0.8rem 4rem;background-color: #1A73E8;">Reply</a>
                </div>
                <div class="border border-primary text-white text-left" style="min-height: 350px;">
                    <div class="m-3">
                        <p><span class="text-primary">[Form]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span><b><?= $message['sender'] ?></b></p>
                        <p><span class="text-primary">[Subject] : </span><b><?= $message['subject'] ?></b></< /p>
                        <p style="text-align: justify;"><span class="text-primary d-block"> Message &nbsp;: </span><?= $message['text'] ?></< /p>
                        <p><span class="text-primary">[Attachment] : </span>File</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>