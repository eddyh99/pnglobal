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
        <div class="mx-2">
            <input type="search" class="form-control border-primary border-2" placeholder="search...">
        </div>
        <?php foreach ($friends as $f): ?>
            <li class="nav-item mt-2">
                <a href="#" class="nav-link text-white px-4 py-3 subject" data-id="<?= $f['id'] ?>"><?= $f['nama'] ?></a>
            </li>
        <?php endforeach ?>

        </ul>
    </div>
    <!-- Konten utama -->
    <div class="flex-grow-1 p-4 text-center">
        <div class="container">
            <h3 class="my-4">Message</h3>
            <form action="" method="POST">
            <div class="input-group mw-100 mb-0">
                    <span class="input-group-text text-white bg-primary rounded-0" style="padding: 0.7rem;" id="basic-addon3">Subject</span>
                    <input type="text" name="subject" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                    <button type="submit" class="input-group-text btn bg-primary rounded-0" style="padding: 0.8rem;">Send Message</button>
                </div>
                <textarea id="editor" class="w-100 form-control" name="message" style="min-height: 350px;" placeholder="Message..."></textarea>
                </form>
        </div>
    </div>
</div>