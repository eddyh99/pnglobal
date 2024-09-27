<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-5">
                <form action="<?= BASE_URL?>godmode/message/sendmessage" method="POST">
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($message as $dt){?>
                            <tr>
                                <td><?= $dt->title?></td>
                                <td>
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
                            </tr>    
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    <?php if(!empty(session('success'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('success')?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php }?>

    <?php if(!empty(session('failed'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('failed')?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php }?>

    <?php if(!empty(session('error_validation'))) { ?>
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
    <?php }?>
</script>


