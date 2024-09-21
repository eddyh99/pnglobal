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
            <div class="col-lg-12">
                <?php if($type == "totalmember"){?>
                    <a class="text-white" href="<?= BASE_URL?>godmode/dashboard">BACK</a>
                <?php }else if($type == "freemember"){?>
                    <a class="text-white" href="<?= BASE_URL?>godmode/dashboard?type=<?=base64_encode("free_member")?>">BACK</a>
                <?php } else if($type == "referralmember") {?>
                    <a class="text-white" href="<?= BASE_URL?>godmode/dashboard?type=<?=base64_encode("referral_member")?>">BACK</a>
                <?php } ?>
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
                                    if($member->period < 400 || $member->period == null) { ?>
                                        Normal Member
                            <?php   } else {?>
                                        Free Member
                            <?php   } ?>
                            <?php 
                                } else if($member->role == "referral") { 
                            ?>
                                Referral Member
                            <?php } ?>
                        </span>
                        <button 
                            class="upgrade-btn" 
                            data-toggle="modal" 
                            data-target="#upgradeModal"
                            <?= (($member->period < 400 || $member->period == null) ? "" : "disabled")?>
                        >  
                            Upgrade
                        </button>
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
                    <div class="value"><?= $member->membership?></div>

                    <!-- Subscription Plan -->
                    <div class="label">Subscription Plan</div>
                    <div class="value">
                        <?php 
                            $totalDays = (int)$member->period;
                            $months = floor($totalDays / 30);
                            $days = $totalDays % 30;   
                            
                            if($member->period < 400 || $member->period == null){
                                if($months < 1){
                                    echo $days . " Days";
                                }else if($days == 0){
                                    echo $months . " Month";
                                }else{
                                    echo $months . " Month " . $days . " Days";
                                }
                            }else{
                                echo "Lifetime";
                            }

                        ?>
                    </div>

                </div>

                <?php if($member->role == 'referral'){?>
                <!-- Referral -->
                <div class="dash-detailmember">
                    <div class="header">Referral</div>

                    <!-- Referral Code -->
                    <div class="label">Referral code</div>
                    <div class="value"><?= $member->refcode?></div>
                    
                    <!-- Referring member -->
                    <div class="label">Referring member</div>
                    <div class="value">
                        <span>-</span>
                        <button class="upgrade-btn">Add Referral</button>
                    </div>

                    <!-- Number of referrals -->
                    <div class="label">Number of referrals</div>
                    <div class="value">-</div>
                </div>
               
                <!-- Commission -->
                <div class="dash-detailmember">
                    <div class="header">Commission</div>

                    <!-- Pending Commission -->
                    <div class="label">Pending Commission</div>
                    <div class="value">-</div>
                    
                    <!-- Available Commission -->
                    <div class="label">Available Commission</div>
                    <div class="value">-</div>
                    
                    <!-- Send commission -->
                    <div class="label">Send commission</div>
                    <div class="value">
                        <span></span>
                        <button class="upgrade-btn">Send</button>
                    </div>

                    <!-- Commission Sent -->
                    <div class="label">Commission Sent</div>
                    <div class="value">-</div>
                </div>
                <?php }?>
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
                <form method="POST" action="#">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>You will upgrade this member to FREE</p>
                        <h4 class="my-4"><?= $member->email; ?></h4>
                        <button class="btn-modal-upgrade mb-4">Upgrade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>