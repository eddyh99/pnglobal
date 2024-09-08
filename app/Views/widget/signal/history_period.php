<div class="app-content row  mb-5 pb-5 pt-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
       <div class="row">
            <div class="col-lg-12 ">
                <table id="table_history_period" class="table table-striped" style="width:100%;border-spacing: 1rem;border:none;">
                    <thead>
                        <tr>
                            <th>ORDER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $dt){?>
                        <tr class="wrapper-period">
                            <td class="td-period">
                                <a href="<?= BASE_URL?>widget/signal/detailhistory/<?= base64_encode($dt->detail)?>" class="period-history">
                                    <span>
                                        Period <?= $dt->created_at?>
                                    </span>
                                    <span>
                                        <?= $dt->status?>
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
       </div>
    </div>
</div>