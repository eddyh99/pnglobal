<div class="app-content row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <div class="my-4 d-flex align-items-center justify-content-between">
            <a href="<?= BASE_URL ?>widget/message" style="font-size: 14px;">BACK</a>
            <p class="text-white text-center fw-bold mb-0">MESSAGE</p>
            <p></p>
        </div>

        <div class="wrapper-detailmessage">
            <div class="header-detailmessage">
                <h1><?= $detail->title; ?></h1>
                <span>
                    <?php   
                        $dateString = $detail->created_at;
                        $date = new DateTime($dateString);
                        $formattedDate = $date->format('d/m/y');
                        echo $formattedDate; ?>
                </span>
            </div>
            <div class="body-detailmessage">
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui magnam corrupti facilis, impedit, in molestias nam unde amet aliquam modi atque voluptatum rerum quaerat tempore ut debitis mollitia, consectetur iure.
                </p>
            </div>
        </div>
    </div>
</div>