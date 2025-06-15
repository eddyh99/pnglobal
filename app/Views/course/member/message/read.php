<div class="d-flex vh-100">
    <!-- Sidebar dengan garis pembatas kanan -->
    <?= view($sidebar); ?>
    <!-- Konten utama -->
    <div class="flex-grow-1 p-4 text-center">
        <div class="container">
            <h3 class="my-4">Message</h3>
            <div class="input-group mw-100 mb-0">
                <input type="text" name="subject" class="form-control text-white border-primary" id="basic-url" aria-describedby="basic-addon3" style="background-color: transparent;" value="<?= $message->sent_date ?>" readonly>
                <a href="<?= BASE_URL ?>course/message/compose" class="input-group-text btn rounded-0" style="padding: 0.8rem 4rem;background-color: #1A73E8;">Reply</a>
            </div>
            <div class="border border-primary text-white text-left" style="min-height: 350px;">
                <div class="m-3">
                    <p><span class="text-primary">[Form]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span><b><?= $message->sender ?></b></p>
                    <p><span class="text-primary">[Subject] : </span><b><?= $message->subject ?></b></</p>
                    <p style="text-align: justify;"><span class="text-primary d-block"> Message &nbsp;: </span><?= $message->text ?></</p>
                    <p><span class="text-primary">[Attachment] : </span>File</p>
                </div>
            </div>
        </div>
    </div>
</div>