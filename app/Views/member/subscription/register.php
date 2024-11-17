<?php if(!empty(session('failed'))) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('failed')?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form action="<?= BASE_URL?>member/auth/signup" method="POST" class="mt-4">
            <div class="subs">
                <div class="title-top">
                    <h1 class="title">Register Your Account</h1>
                </div>
                <div class="list-subs  text-white">
                        <div class="form-group">
                            <label for="exampleInputEmail2">Email address</label>
                            <input type="email" class="form-control mb-0" name="email" id="exampleInputEmail2" placeholder="Enter email">
                        </div>
                        <div class="form-group mt-2">
                            <div>
                                <label for="exampleInputPassword2">Password</label>
                                <input type="password" class="form-control mb-0" name="password" id="password" placeholder="Password">
                            </div>
                            <i class="icon-pass-login las la-eye" id="togglePassword"></i>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail2">Referral</label>
                            <input type="text" class="form-control mb-0" name="referral" id="referral" placeholder="Referrral">
                        </div>

                </div>
                <div class="text-danger" id="card-errors"></div>
                <div class="d-flex justify-content-center mt-5">
                    <!-- <a href="" class="btn-subs-continue mx-2">Back</a> -->
                    <button type="submit" id="submit-button" class="btn-subs-continue mx-2">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>