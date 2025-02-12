<?php if(!empty(session('success'))) { ?>
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
            <div class="col-lg-12">
                    <a class="text-white" href="<?= BASE_URL?>godmode/freemember">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <h4 class="text-center"><?= $member->email; ?></h4>

                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Detail</div>
                    
                    <!-- Membership Status -->
                    <div class="label">Membership Status</div>
                    <div class="value">
                        <span>
                            <?php 
                                if($member->role == "member"){
                                    if($member->free_status!='yes') { ?>
                                        Normal Member
                            <?php   } else {?>
                                        Free Member
                            <?php   } ?>
                            <?php 
                                } ?>
                        </span>
                        <a 
                            href="<?= ($member->membership != 'expired') ? BASE_URL . 'godmode/freemember/cancelfree/' . base64_encode($member->email) : 'javascript:void(0)' ?>"
                            id="btncancel"
                            class="upgrade-btn <?= ($member->membership == 'expired') ? 'disabled' : '' ?>">  
                            Cancel
                        </a>
                    </div>
                    
                    <!-- Registration date -->
                    <div class="label">Registration date</div>
                    <div class="value">
                        <?php
                            $dateString = $member->created_at;
                            $date = new DateTime($dateString);
                            $formattedDate = $date->format('d F Y');
                            echo $formattedDate;
                        ?>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Subscription Status</div>
                    <div class="value">
                        <?= $member->membership?>
                        <button 
                            id="btnupgrade"
                            class="upgrade-btn" 
                            data-toggle="modal" 
                            data-target="#upgradeModal"
                            <?= (($member->membership =='expired') ? "" : "disabled")?>
                        >  
                            Extend
                        </button>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Free Plan Start Date</div>
                    <div class="value">
                        <?php
                            $dateString = $member->start_date;
                            $date = new DateTime($dateString);
                            $formattedDate = $date->format('d F Y');
                            echo $formattedDate;
                        ?>
                    </div>
                    <!-- Subscription Status -->
                    <div class="label">Free Plan End Date</div>
                    <div class="value">
                         <?php
                            $dateString = $member->end_date;
                            $date = new DateTime($dateString);
                            $formattedDate = $date->format('d F Y');
                            echo $formattedDate;
                        ?>
                    </div>

                    <!-- Subscription Plan -->
                    <div class="label">Subscription Plan</div>
                    <div class="value">
                        <?php 
                            $totalDays = (int)$member->total_period;
                            $months = floor($totalDays / 30);
                            $days = $totalDays % 30;   
                            
                            if ($member->membership!="expired"){
                                if($months < 1){
                                    echo $days . " Days";
                                }else if($days == 0){
                                    echo $months . " Month";
                                }else{
                                    echo $months . " Month " . $days . " Days";
                                }
                            }else{
                                echo "-";
                            }
                        ?>
                    </div>
                    <!-- Bonus Member -->
                    <div class="label">Send Bonus</div>
                    <div class="d-flex flex-row justify-content-start">
                        <form id="frmbonus" action="<?=BASE_URL?>godmode/payment/sendbonus?type=free" method="POST" onsubmit="return validate()">
                            <input type="hidden" name="email" value="<?=$member->email?>">
                            <input class="me-2" type="number" name="amount" id="bonus" class="form-control"  style="min-width: 28ch;" required>
                            &nbsp;&nbsp;<button class="btn" style="background-color:#8a6d3b;color:white">Send</button>
                        </form>
                    </div>
                </div>
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember mt-5">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Referral Level 1</h4>
                        <table id="table_referralmember" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>STATUS</th>
                                    <th>SUBSCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember mt-5">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Referral Level 2</h4>
                        <table id="table_level" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>STATUS</th>
                                    <th>SUBSCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Upgrade Modal -->
<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content upgrade-member">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="upgradeModalLabel">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="text-black" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    $currentDate = new DateTime();
                    $currentDate->modify('+1 month');
                    $tgl= $currentDate->format('m/d/Y');
                ?>

                <form method="POST" action="<?=BASE_URL?>godmode/freemember/upgrademember">
                    <input type="hidden" name="email" value="<?=$member->email?>">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>You will extend this FREE member</p>
                        <h4 class="my-4"><?= $member->email; ?></h4>
                        <input type="text" name="expired" id="expired" value="<?=$tgl ?>" class="form-control text-black">
                        <button class="btn-modal-upgrade mb-4 mt-4">Extend</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>