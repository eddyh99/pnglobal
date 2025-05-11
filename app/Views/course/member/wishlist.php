</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <div class="d-flex w-50">
            <span class="btn btn-primary rounded-0 py-2 mr-1" style="pointer-events: none;">Category</span>
            <select class="form-control bg-primary text-white text-center border-0 rounded-0 w-25 h-100">
                <option class="text-center">ALL</option>
                <option class="text-center">CATEGORY 1</option>
                <option class="text-center">CATEGORY 2</option>
                <option class="text-center">CATEGORY 3</option>
            </select>
        </div>
        <div>
            <input type="search" class="form-control border-primary border-2 mt-1" placeholder="search video">
        </div>
    </div>
    <h2 class="text-center mt-3 mb-5">Wishlist</h2>
    <div class="mx-4 text-left">
        <div class="row">
            <?php foreach ($courses as $course): ?>
                <div class="col-3 mb-4">
                    <a class="text-white" href="<?= BASE_URL ?>course/member/detail/<?= base64_encode($course['id']) ?>">
                        <div class="card" style="width: 18rem;background-color: transparent;">
                            <img src=<?= $course['image'] ?> class="card-img-top" alt="...">
                            <div class="card-body p-1">
                                <p class="card-text mb-1"><?= $course['description'] ?></p>
                                <div class="d-flex justify-content-between">
                                    <small>By <?= $course['author'] ?></small>
                                    <div>
                                        <i class="bi bi-check-square-fill"></i>
                                        <button class="btn p-0"><i class="bi bi-heart-fill text-danger"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>


        </div>
    </div>
</div>