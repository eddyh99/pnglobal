
<?php if(!empty(session('failed'))) { ?>
<div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
        <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
        <?= session('success')?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line text-black"></i>
    </button>
</div>
<?php }?>

<?php if(!empty(session('failed'))) { ?>
<div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
        <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
        <?= session('failed')?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line text-black"></i>
    </button>
</div>
<?php }?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-5">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="d-flex flex-column justify-content-center align-items-start">
                                    <div>
                                        <h4 class="text-black">Exclusive Member</h4>
                                    </div>
                                    <div class="mt-3 w-100 d-flex justify-content-end">
                                        <h1 class="text-black fw-bold"><?= @$exclusive?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="d-flex flex-column justify-content-center align-items-start">
                                    <div>
                                        <h4 class="text-black">Total Member</h4>
                                    </div>
                                    <div class="mt-3 w-100 d-flex justify-content-end">
                                        <h1 class="text-black fw-bold"><?= @$totalmember?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="d-flex flex-column justify-content-center align-items-start">
                                    <div>
                                        <h4 class="text-black">Main Signals</h4>
                                    </div>
                                    <div class="mt-3 w-100 d-flex justify-content-end">
                                        <h1 class="text-black fw-bold"><?= @$mainsignal?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="d-flex flex-column justify-content-center align-items-start">
                                    <div>
                                        <h4 class="text-black">Sub Signals</h4>
                                    </div>
                                    <div class="mt-3 w-100 d-flex justify-content-end">
                                        <h1 class="text-black fw-bold"><?= @$subsignal; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="dash-signal-preview">
                    <div class="title-signal-preview">
                        <h4>Signal Preview</h4>
                    </div>
                    <div class="main-signal-preview d-flex flex-column align-items-center justify-content-center">
                        <div class="date d-flex justify-content-end w-100">
                            <!-- <h5>Release at 07-07-2024</h5> -->
                        </div>
                        <div class="insturctions d-flex flex-column align-items-center justify-content-center">
                            <span class="instructions-title">Instructions</span>
                            <div class="box-insturctions d-flex align-items-center justify-content-center">
                                <h4>EMPTY</h4>
                                <!-- <span>16/08/24 | 10:25</span> -->
                            </div>
                        </div>
                        <div class="signal-preview">
                            <div class="row">
                                <div class="col-6 all-buy">
                                    <div class="wrapper-buy">
                                        <div class="buy">
                                            <div class="buy-title d-flex justify-content-between align-items-end">
                                                <span class="buy-text">BUY - A</span>
                                                <span class="buy-date"> 
                                                    <?php
                                                        $newDate = date('d/m/Y H:i', strtotime(@$buy_a['created_at']));
                                                        if(!empty($buy_a)){
                                                            echo $newDate;
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text"  class="price-input" value="<?= @$buy_a['entry_price']?>" readonly>
                                        </div>
                                        <div class="buy">
                                            <div class="buy-title d-flex justify-content-between align-items-end">
                                                <span class="buy-text">BUY - B</span>
                                                <span class="buy-date">
                                                    <?php
                                                        $newDate = date('d/m/Y H:i', strtotime(@$buy_b['created_at']));
                                                        if(!empty($buy_b)){
                                                            echo $newDate;
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text" class="price-input" value="<?= @$buy_b['entry_price']?>" readonly>
                                        </div>
                                        <div class="buy">
                                            <div class="buy-title d-flex justify-content-between align-items-end">
                                                <span class="buy-text">BUY - C</span>
                                                <span class="buy-date"> 
                                                <?php
                                                    $newDate = date('d/m/Y H:i', strtotime(@$buy_c['created_at']));
                                                    if(!empty($buy_c)){
                                                        echo $newDate;
                                                    }
                                                ?>
                                                </span>
                                            </div>
                                            <input type="text" class="price-input" value="<?= @$buy_c['entry_price']?>"  readonly>
                                        </div>
                                        <div class="buy">
                                            <div class="buy-title d-flex justify-content-between align-items-end">
                                                <span class="buy-text">BUY - D</span>
                                                <span class="buy-date"> 
                                                    <?php
                                                        $newDate = date('d/m/Y H:i', strtotime(@$buy_d['created_at']));
                                                        if(!empty($buy_d)){
                                                            echo $newDate;
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text" class="price-input" value="<?= @$buy_d['entry_price']?>"  readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 all-sell">
                                    <div class="wrapper-sell">
                                        <div class="sell">
                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                <span class="sell-text">Sell - A</span>
                                                <span class="sell-date"></span>
                                            </div>
                                            <input type="text" readonly>
                                        </div>
                                        <div class="sell">
                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                <span class="sell-text">Sell - B</span>
                                                <span class="sell-date"></span>
                                            </div>
                                            <input type="text" readonly>
                                        </div>
                                        <div class="sell">
                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                <span class="sell-text">Sell - C</span>
                                                <span class="sell-date"></span>
                                            </div>
                                            <input type="text" readonly>
                                        </div>
                                        <div class="sell">
                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                <span class="sell-text">Sell - D</span>
                                                <span class="sell-date"></span>
                                            </div>
                                            <input type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <form action="<?= BASE_URL?>godmode/referral/sendref" method="POST">
                    <div class="dash-signal-preview">
                        <div class="title-signal-preview">
                            <h4>Add Referral</h4>
                        </div>
                        <div class="dash-referral pt-4">
                            <label for="email">Email</label>
                            <input type="text" id="email" class="form-control-dark" name="email">
                        </div>
                        <div class="dash-referral">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control-dark" name="password">
                        </div>
                        <div class="dash-referral">
                            <label for="refcode">Referral code</label>
                            <input type="text" id="refcode" class="form-control-dark" name="refcode">
                        </div>
                        <div class="dash-referral d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary">CREATE</button>
                        </div>           
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
