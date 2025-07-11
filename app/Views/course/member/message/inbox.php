<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>
<div class="d-flex vh-100">
    <?= view($sidebar); ?>
    <!-- Konten utama -->
    <div class="flex-grow-1 p-4 text-center">
        <div class="mx-2 w-25 ml-auto">
            <input type="search" class="form-control border-primary border-2" placeholder="search message...">
        </div>
        <h3>Message</h3>
        <div class="container">
            <table class="table table-bordered mt-5">
                <tbody>
                    <?php foreach ($messages as $m): ?>
                        <tr onclick="window.location.href = '<?= BASE_URL ?>course/message/read/<?=$m->id?>';" style="cursor: pointer; <?= !$m->isread ? 'background-color: rgba(191, 165, 115, 0.3);' : '' ?>">
                            <td><?= $m->sender ?></td>
                            <td><?= $m->subject ?></td>
                            <td><?= $m->sent_date ?>
                                <button class="btn ml-3 p-0"><i>
                                    <span class="toggle-fav" data-id="<?= $m->id ?>" data-status="is_fav">
                                        <?php if ($m->isfav): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                        <?php else: ?>
                                            <svg width="15" height="15" viewBox="0 0 15 15" fill="#FFD700" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.5 0.5C7.64847 0.500002 7.78493 0.575199 7.86523 0.697266L7.89648 0.751953L9.71094 4.61816L9.82422 4.85938L10.0879 4.89941L14.1289 5.51758C14.2702 5.53937 14.391 5.62844 14.4541 5.75488L14.4775 5.81152C14.5227 5.94738 14.4984 6.09514 14.415 6.20898L14.375 6.25586L11.4248 9.28125L11.249 9.46191L11.2891 9.71094L11.9883 13.9912C12.0118 14.136 11.9614 14.2818 11.8564 14.3809L11.8076 14.4199C11.7327 14.4728 11.6442 14.5 11.5557 14.5C11.5192 14.5 11.4828 14.4954 11.4473 14.4863L11.3438 14.4453L7.74219 12.4531L7.5 12.3193L7.25781 12.4531L3.65625 14.4453C3.52694 14.5163 3.3732 14.517 3.24609 14.4521L3.19238 14.4199L3.14453 14.3809C3.0541 14.2956 3.00349 14.1761 3.00586 14.0527L3.01172 13.9912L3.71094 9.71094L3.75098 9.46191L3.5752 9.28125L0.625 6.25586C0.52431 6.15253 0.482056 6.00849 0.507812 5.87012L0.522461 5.81152C0.568054 5.67542 0.676845 5.57174 0.811523 5.53125L0.871094 5.51758L4.91211 4.90039L5.17578 4.85938L5.28906 4.61816L7.10352 0.751953C7.1759 0.597827 7.33026 0.5 7.5 0.5Z" fill="black" fill-opacity="0.01" stroke="white" />
                                            </svg>
                                        <?php endif ?>
                                    </span>
                                </i></button>
                                <a href="<?=BASE_URL?>/course/message/del/<?=$m->id?>" class="btn p-0"><i><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.49967 21.4167C9.49967 22.425 10.3247 23.25 11.333 23.25H18.6663C19.6747 23.25 20.4997 22.425 20.4997 21.4167V10.4167H9.49967V21.4167ZM21.4163 7.66667H18.208L17.2913 6.75H12.708L11.7913 7.66667H8.58301V9.5H21.4163V7.66667Z" fill="white" />
                                    </svg>
                                </i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>