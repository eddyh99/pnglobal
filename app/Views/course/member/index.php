<div class="container-fluid">
    <h2 class="text-center my-3">Explore Course</h2>
    <div class="mx-4 text-left">
        <div class="row">
            <?php foreach($courses as $course): ?>
            <div class="col-3 mb-4">
                <a class="text-white" href="<?= BASE_URL?>course/member/detail/<?= base64_encode($course['id']) ?>">
                    <div class="card" style="width: 18rem;background-color: transparent;">
                        <img src=<?= $course['image'] ?> class="card-img-top" alt="...">
                        <div class="card-body p-1">
                            <p class="card-text mb-1"><?= $course['description'] ?></p>
                            <small>By <?= $course['author'] ?></small>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach ?>


        </div>
    </div>
</div>