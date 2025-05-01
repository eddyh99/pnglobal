<div class="d-flex vh-100">
    <!-- friends -->
         <!-- Sidebar dengan garis pembatas kanan -->
    <div id="sidebar" class="bg-black text-white" style="width: 220px;border-right: 4px solid #B48B3D;"">
        <ul class=" nav flex-column text-center">
        <li class="nav-item mb-2">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link <?= $active_inbox ?? $active_unread ?? $active_starry ?? '' ?>
 text-white" aria-current="page" href="<?= BASE_URL ?>course/message/inbox">Inbox</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active_compose ?? '' ?> text-white" href="<?= BASE_URL ?>course/message/compose">Compose</a>
                </li>
            </ul>
            <hr class="m-0" style="border: 1px solid #B48B3D;">
        </li>
        <?php foreach($friends as $f): ?>
        <li class="nav-item">
            <a href="#" class="nav-link text-white px-4 py-3 subject" data-id="<?= $f['id'] ?>"><?= $f['nama'] ?></a>
        </li>
        <?php endforeach ?>

        </ul>
    </div>
    <!-- Konten utama -->
    <div class="flex-grow-1 p-4 text-center">
        <h3>No content available.</h3>
    </div>
</div>