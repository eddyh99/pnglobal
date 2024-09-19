<div class="wrapper-account-deletion">
    <div class="row header-account-deletion">
        <div class="container">
            <div class="col-12 ">
                <h2 class="f-noto">Attention: Account Deletion</h2>
            </div>
        </div>
    </div>
    <?php if(!empty(session('failed'))) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>
                <?= session('failed')?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">
                <?php if($step == 'first_step') {?>
                    <div class="first-step">
                        <h4>
                            Are you sure you want to delete your account? <br><br>
                            Please note that by deleting your account you will lose:
                        </h4>
                        <div class="box-cons">
                            <ul>
                                <li>
                                    <p>Access to all app features</p>
                                </li>
                                <li>
                                    <p>Your Personal Data</p>
                                </li>
                                <li>
                                    <p>Your Referral Code</p>
                                </li>
                                <li>
                                    <p>Any payments made for the subscription will not be refunded</p>
                                </li>
                            </ul>
                        </div>
                        <p class="by-continue">
                            By continuing, you will lose access to all your data and you will not be able to restore the account.
                        </p>
                        <div class="d-flex justify-content-center">
                            <a href="<?= BASE_URL?>homepage/account_deletion?step=<?=base64_encode('second_step')?>" class="btn btn-navbar-contactform w-50">NEXT</a>
                        </div>
                    </div>
                <?php } ?>

                <?php if($step == 'second_step') {?>
                    <div class="second-step">
                        <form action="<?= BASE_URL?>homepage/account_deletion_proccess" method="POST">
                            <div class="box-cons">
                               <div>
                                    <label for="">Email Address</label><br>
                                    <input type="email" name="email" class="inp-email mt-1 img-fluid w-100" placeholder="Enter your email" required>
                               </div>
                               <div class="mt-4">
                                    <label class="label-desc" for="reason">Reason</label> <br>
                                    <textarea class="textarea-desc img-fluid mt-1" id="desc" name="reason" type="text" placeholder="Explain your reason..." required></textarea>
                               </div>
                            </div>
                            <div class="d-flex justify-content-between actions-button">
                                <a href="<?= BASE_URL?>homepage/account_deletion" class="btn btn-navbar-contactform w-40">BACK</a>
                                <button type="submit" class="btn btn-navbar-contactform w-40">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>


                <?php if($step == 'third_step') {?>
                    <div class="second-step">
                        <div class="box-cons">
                            <div>
                                <h3 class="text-center">Your Request Successfully Send it</h3>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <svg width="195" height="123" viewBox="0 0 195 123" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_i_3559_931)">
                                    <path d="M139.647 2.21116C138.587 1.37204 137.371 0.751126 136.07 0.384249C134.769 0.0173725 133.408 -0.0882026 132.066 0.0736143C130.724 0.235431 129.427 0.661439 128.251 1.32705C127.074 1.99266 126.041 2.8847 125.211 3.95169L53.5419 96.0972L18.4242 53.3007C17.6005 52.2042 16.5649 51.2844 15.3788 50.5959C14.1928 49.9073 12.8805 49.464 11.5198 49.2924C10.1592 49.1207 8.77793 49.2242 7.45803 49.5966C6.13814 49.969 4.90652 50.6028 3.83628 51.4604C2.76604 52.318 1.87899 53.3818 1.2278 54.5888C0.576604 55.7958 0.174533 57.1213 0.0454515 58.4866C-0.0836298 59.852 0.0629112 61.2293 0.476373 62.5369C0.889834 63.8446 1.56179 65.0558 2.45235 66.0987L45.1465 119.134C46.1101 120.321 47.3276 121.278 48.7096 121.934C50.0915 122.589 51.6028 122.927 53.1324 122.922C54.756 122.994 56.3735 122.679 57.8512 122.003C59.3289 121.326 60.6243 120.308 61.6303 119.031L141.797 16.6473C142.614 15.5623 143.207 14.3255 143.542 13.0089C143.877 11.6924 143.946 10.3224 143.746 8.97886C143.546 7.63528 143.08 6.34495 142.376 5.18305C141.673 4.02115 140.745 3.0109 139.647 2.21116ZM190.839 2.21116C189.779 1.37204 188.563 0.751126 187.262 0.384249C185.961 0.0173725 184.6 -0.0882026 183.258 0.0736143C181.916 0.235431 180.619 0.661439 179.443 1.32705C178.266 1.99266 177.233 2.8847 176.403 3.95169L104.734 96.0972L98.4885 88.4184L85.5881 105.005L96.8503 119.031C97.814 120.219 99.0315 121.176 100.413 121.831C101.795 122.487 103.307 122.825 104.836 122.819C106.374 122.812 107.891 122.459 109.273 121.785C110.656 121.112 111.869 120.135 112.822 118.929L192.989 16.5449C193.79 15.4631 194.37 14.2338 194.696 12.9275C195.022 11.6212 195.086 10.2635 194.887 8.9321C194.687 7.6007 194.227 6.32176 193.532 5.16849C192.837 4.01523 191.922 3.01027 190.839 2.21116Z" fill="#BFA573"/>
                                    <path d="M58.6595 72.3612L71.867 55.7749L69.8193 53.3177C69.011 52.1979 67.9845 51.2531 66.8015 50.5404C65.6185 49.8276 64.3035 49.3615 62.9357 49.1702C61.5679 48.9789 60.1756 49.0663 58.8424 49.4272C57.5093 49.7881 56.263 50.4149 55.1784 51.2701C54.1267 52.115 53.2523 53.1594 52.6055 54.3433C51.9587 55.5273 51.5522 56.8273 51.4095 58.1689C51.2668 59.5104 51.3906 60.8669 51.7738 62.1604C52.1571 63.4539 52.7922 64.6589 53.6427 65.7062L58.6595 72.3612Z" fill="#BFA573"/>
                                    </g>
                                    <defs>
                                    <filter id="filter0_i_3559_931" x="0" y="0" width="195" height="126.932" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="2"/>
                                    <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                    <feBlend mode="normal" in2="shape" result="effect1_innerShadow_3559_931"/>
                                    </filter>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center actions-button">
                            <a href="<?= BASE_URL?>" class="btn btn-navbar-contactform w-40">BACK</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>