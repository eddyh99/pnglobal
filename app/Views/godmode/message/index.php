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
                            <th class="d-flex justify-content-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        <tr>
                            <td>INI SUBJECT</td>
                            <td class="d-flex justify-content-end align-items-center">01/12/2024 <a href="" style="margin-left: 10px; font-size: 24px;"><i class="las la-trash text-white"></i></a></td>
                        </tr>
                        
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
</script>


