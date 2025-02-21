<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <form action="<?= BASE_URL ?>godmode/admin/create_admin" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Add Admin</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <form action="" method="POST">
                                <div class="row w-100">
                                    <div class="form-addreferral col-8 mx-auto">
                                        <div class="wrapper-addreferral">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                        <div class="wrapper-addreferral">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="wrapper-addreferral">
                                            <label for="role">Role</label>
                                            <div class="role-wrapper">
                                                <div class="role-item">
                                                    <input type="radio" id="role_member" name="role" value="member">
                                                    <label for="role_member">Member</label>
                                                </div>
                                                <div class="role-item">
                                                    <input type="radio" id="role_admin" name="role" value="admin">
                                                    <label for="role_admin">Admin</label>
                                                </div>
                                                <div class="role-item">
                                                    <input type="radio" id="role_manager" name="role" value="manager">
                                                    <label for="role_manager">Manager</label>
                                                </div>
                                                <div class="role-item">
                                                    <input type="radio" id="role_superadmin" name="role" value="superadmin">
                                                    <label for="role_superadmin">Super Admin</label>
                                                </div>
                                            </div>
                                            <input type="hidden" id="timezone" class="form-control" name="timezone" readonly value="<?= set_value('timezone') ?>">
                                        </div>
                                        <div class="wrapper-addreferral d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Admin</h4>
                <table id="tbl_freemember" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>EMAIL</th>
                            <th>ROLE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
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
    <?php } else if (!empty(session('success'))) { ?>
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