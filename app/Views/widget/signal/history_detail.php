<div class="app-content row  mb-5 pb-5 pt-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <div>
            <a href="<?= BASE_URL?>widget/signal/history">
                <i class="fas fa-chevron-circle-left text-white fs-3"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-lg-12 history-table-message">
                <div class="text-white d-flex align-items-center justify-content-between"><span>PERIOD <?= $period?></span> <span><?= count($history)?> ORDER</span> </div>
                <table id="table_message" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ORDER</th>
                            <th>PRICE</th>
                            <th>DATE</th>
                            <th>TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($history as $hs){?>
                            <tr class="tr-data">
                                <td><?= $hs->type?></td>
                                <td><?= $hs->entry_price?></td>
                                <td><?= $hs->finaldate?></td>
                                <td><?= $hs->finaltime?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>