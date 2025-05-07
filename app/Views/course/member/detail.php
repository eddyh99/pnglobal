<div class="container-fluid">
    <h2 class="text-center my-3"><?= $course->title ?? 'Untitled' ?></h2>
    <h5 class="text-center">By <?= $course->email ?? '404' ?></h5>
    <div class="mx-4">
        <div class="mt-4 text-white">
            <h2>Description</h2>
            <p style="text-align: justify;"><?= $course->description ?? '-' ?></p>
        </div>
        <h2>Material Video</h2>
        <div class="container">
            <div class="row">
                <div class="col-4"><img src="<?= $course->video ?? '#' ?>" alt="Video Course"></div>
                <div class="col-4"><img src="<?= $course->video ?? '#' ?>" alt="Video Course"></div>
                <div class="col-4"><img src="<?= $course->video ?? '#' ?>" alt="Video Course"></div>
            </div>
        </div>
        <div class="my-4">
            <h2>Live Record Video</h2>
            <div class="container">
                <div class="row">
                    <div class="col-4"><img src="<?= $course->video ?? '#' ?>" alt="Video Course"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>