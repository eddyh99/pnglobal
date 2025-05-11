    <!-- Sidebar dengan garis pembatas kanan -->
    <div id="sidebar" class="bg-black text-white" style="width: 220px;border-right: 4px solid #B48B3D;"">
        <ul class="nav flex-column text-center mt-2">
            <?php
            $categories = range(1, 13);
            $active = 1;
            foreach ($categories as $cat) :
                $isActive = $cat == $active ? 'fw-bold bg-primary' : '';
            ?>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>course/member/mycourse" class="nav-link text-white <?= $isActive ?> px-4 py-3">
                        Category <?= $cat ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>