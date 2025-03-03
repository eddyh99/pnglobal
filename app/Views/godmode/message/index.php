<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-5">
                <form id="frm-message" action="<?= BASE_URL ?>godmode/message/sendmessage" method="POST">
                    <div class="wrapper-message-subject d-flex">
                        <div class="bg-subject d-flex align-items-center justify-content-center">Subject</div>
                        <input type="text" name="subject">
                        <button type="submit" class="btn-sendmessage">Send Message</button>
                    </div>
                    <div class="wrapper-message-email">
                        <textarea id="summernote" name="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 px-5 history-table-message">
                <table id="table_message" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Message</th>
                            <th class="d-flex justify-content-end">Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($message as $dt) { ?>
                            <tr>
                                <td><?= $dt->title; ?></td>
                                <td>
                                    <input type="hidden" class="hidden-message" value="<?= htmlspecialchars(html_entity_decode($dt->pesan)) ?>">
                                    <?php
                                    $temp = html_entity_decode($dt->pesan);
                                    echo htmlspecialchars_decode($temp);
                                    ?>
                                </td>
                                <td class="d-flex justify-content-end align-items-center">
                                    <?php
                                    $dateString = $dt->created_at;
                                    $date = new DateTime($dateString);
                                    $formattedDate = $date->format('d M Y');
                                    echo $formattedDate;
                                    ?>
                                </td>
                                <td>
                                    <input type="hidden" class="msgid" value="<?= $dt->id ?>">
                                    <textarea class="message-content d-none"><?= htmlspecialchars_decode(html_entity_decode($dt->pesan)) ?></textarea>
                                    <a href="#" class="edit-message" data-title="<?= htmlspecialchars_decode($dt->title) ?>">
                                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="#FFFFFF" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    <?php if (!empty(session('success'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('success') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>

    <?php if (!empty(session('failed'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('failed') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>

    <?php if (!empty(session('error_validation'))) { ?>
        setTimeout(function() {
            Swal.fire({
                html: '<?= trim(str_replace('"', '', json_encode($_SESSION['error_validation']))) ?>',
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>
</script>