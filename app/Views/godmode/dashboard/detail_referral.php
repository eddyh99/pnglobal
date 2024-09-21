<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <a class="text-white" href="<?= BASE_URL?>godmode/dashboard?type=<?=base64_encode("referral_member")?>">BACK</a>
            </div>
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Detail Referral</h4>
                <table id="table_referralmember" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>EMAIL</th>
                            <th>START DATE</th>
                            <th>END DATE</th>
                            <th>PERIOD</th>
                            <th>MEMBERSHIP</th>
                            <th>COMMISSION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                        <?php foreach($referral as $dt){ ?>
                            <tr>
                                <td><?= $dt->email?></td>
                                <td>
                                    <?php 
                                        $dateString = $dt->start_date;
                                        $date = new DateTime($dateString);
                                        $formattedDate = $date->format('d M Y');
                                        echo $formattedDate;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $dateString = $dt->end_date;
                                        $date = new DateTime($dateString);
                                        $formattedDate = $date->format('d M Y');
                                        echo $formattedDate;
                                    ?>
                                </td>
                                <td>
                                    <?php     
                                        $month = $dt->period / 30;
                                        $month = (int)$month;
                                        echo $month . " Month";
                                    ?>
                                </td>
                                <td>
                                    <?php if($dt->membership == 'active'){?>
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
                                        Active
                                    <?php } else {?>
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                        Expired
                                    <?php } ?>
                                </td>
                                <td><?= (int)$dt->commission . " EUR"?></td>
                                <td>
                                    <?php 
                                        $startdate = $dt->start_date;
                                        $givenDate = new DateTime($startdate);
                                        $today = new DateTime();
                                        $interval = $today->diff($givenDate);
                                        $finaldays = $interval->days;
                                        if($finaldays > 30){      
                                    ?>
                                        <a data-toggle="modal" data-target="#paidModal<?=$dt->subsid?>" class="upgrade-btn btn mx-1">Paid</a>
                                        <a data-toggle="modal" data-target="#cancelModal<?=$dt->subsid?>" class="btn btn-danger">Cancel</a>
                                    <?php } else {?>
                                        <a href="#" disabled class="upgrade-btn btn mx-1">Paid</a>
                                        <a href="#" disabled class="btn btn-danger">Cancel</a>
                                    <?php } ?>

                                    <!-- Start Paid Modal -->
                                    <div class="modal fade" id="paidModal<?=$dt->subsid?>" tabindex="-1" aria-labelledby="paidModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content upgrade-member">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-black" aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="<?= BASE_URL?>godmode/dashboard/payreferral/<?= base64_encode($type)?>/<?= base64_encode($emailreferral)?>">
                                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                                            <input type="hidden" name="type" value="yes">
                                                            <input type="hidden" name="id" value="<?= $dt->subsid?>">
                                                            <p class="text-center">Are you sure want to <b>pay</b> commission of <br> <?= (int)$dt->commission?> EUR</p>
                                                            <h4 class="my-4"><?= $dt->email; ?></h4>
                                                            <button type="submit" class="btn-modal-upgrade mb-4">Pay Now</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Paid Modal -->

                                    <!-- Start Cancel Modal -->
                                    <div class="modal fade" id="cancelModal<?=$dt->subsid?>" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content upgrade-member">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-black" aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="<?= BASE_URL?>godmode/dashboard/payreferral/<?= base64_encode($type)?>/<?= base64_encode($emailreferral)?>">
                                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                                            <input type="hidden" name="type" value="cancel">
                                                            <input type="hidden" name="id" value="<?= $dt->subsid?>">
                                                            <p class="text-center">Are you sure want to <b>cancel</b> commission of <br> <?= (int)$dt->commission?> EUR</p>
                                                            <h4 class="my-4"><?= $dt->email; ?></h4>
                                                            <button type="submit" class="btn-modal-upgrade mb-4">Cancel Now</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Cancel Modal -->
                                </td>
                            </tr>
                        <?php }?>
                    <tbody>
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
