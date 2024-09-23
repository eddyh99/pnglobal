<div class="app-content row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <div class="my-4">
            <p class="text-white text-center fw-bold">MESSAGE</p>
        </div>
        <table id="table_message" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th class="text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($message as $dt){?>
                    <tr>
                        <td>
                            <a href="<?= BASE_URL?>widget/message/detailmessage/<?=base64_encode($dt->id)?>" class="d-block">
                                <?= $dt->title?>
                            </a>
                        </td>
                        <td class="text-end">
                            <a href="<?= BASE_URL?>widget/message/detailmessage/<?=base64_encode($dt->id)?>" class="d-block">
                                <?php 
                                    $dateString = $dt->created_at;
                                    $date = new DateTime($dateString);
                                    $formattedDate = $date->format('d/m/y');
                                    echo $formattedDate;
                                ?>
                            </a>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td>
                        <a href="">
                            BUY A B C
                        </a>
                    </td>
                    <td class="text-end">20/09/24</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>