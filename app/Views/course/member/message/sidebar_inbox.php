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
                    <a class="nav-link <?= $active_cert ?? '' ?> text-white" href="<?= BASE_URL ?>course/message/compose">Compose</a>
                </li>
            </ul>
            <hr class="m-0" style="border: 1px solid #B48B3D;">
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>course/message/inbox" class="nav-link text-white <?= $active_inbox ?? '' ?> px-4 py-3">All
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>course/message/inbox?type=unread" class="nav-link text-white <?= $active_unread ?? '' ?>  px-4 py-3">Unread
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>course/message/inbox?type=starry" class="nav-link text-white <?= $active_starry ?? '' ?>  px-4 py-3">Starry
            </a>
        </li>

        </ul>
    </div>