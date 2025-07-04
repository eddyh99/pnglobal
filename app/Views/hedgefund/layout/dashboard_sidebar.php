<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-menu-bt-sidebar d-flex justify-content-end">
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="main-circle">
                    <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.5 14.5L21.25 7.75M21.25 7.75H16.1875M21.25 7.75V12.8125" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14.5 14.5L7.74997 21.25M7.74997 21.25H12.8125M7.74997 21.25V16.1875" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M28 14.5C28 20.8639 28 24.046 26.0229 26.0229C24.046 28 20.8639 28 14.5 28C8.13603 28 4.95406 28 2.97703 26.0229C1 24.046 1 20.8639 1 14.5C1 8.13603 1 4.95406 2.97703 2.97703C4.95406 1 8.13603 1 14.5 1C20.8639 1 24.046 1 26.0229 2.97703C27.3376 4.29158 27.7781 6.13884 27.9256 9.1" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="hover-circle">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.5002 3.50001L16.0002 11M16.0002 11H20.6877M16.0002 11V6.31251" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.50018 23.5L11.0002 16M11.0002 16H6.31268M11.0002 16V20.6875" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26 13.5C26 19.3925 26 22.3389 24.1694 24.1694C22.3389 26 19.3925 26 13.5 26C7.60744 26 4.66116 26 2.83059 24.1694C1 22.3389 1 19.3925 1 13.5C1 7.60744 1 4.66116 2.83059 2.83059C4.66116 1 7.60744 1 13.5 1C19.3925 1 22.3389 1 24.1694 2.83059C25.3866 4.04776 25.7945 5.75819 25.9311 8.5" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" />
                    </svg>

                </div>
            </div>
        </div>
    </div>
    <div class="iq-sidebar-logo d-flex justify-content-between align-items-center">
        <a href="<?= BASE_URL ?>hedgefund/dashboard" class="header-logo">
            <div class="logo-title d-flex align-items-center">
                <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo-sidebar-admin" alt="logo pnglobal">
                <span class="text-white text-uppercase">PN GLOBAL</span>
            </div>
        </a>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <?php
                // if ($_SESSION["logged_user"]->role=="admin"){
                ?>
                <li class="<?= @$active_dash ?>">
                    <a href="<?= BASE_URL ?>hedgefund/dashboard" class="iq-waves-effect">
                        <i>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.04505 9.20507C9.51607 6.73405 10.7516 5.49854 12.1299 4.92763C13.9676 4.16642 16.0324 4.16642 17.8701 4.92763C19.2484 5.49854 20.4839 6.73405 22.955 9.20507V9.20507C24.0354 10.2855 24.5756 10.8257 24.986 11.4399C25.5332 12.2589 25.9137 13.1776 26.1059 14.1436C26.25 14.868 26.25 15.632 26.25 17.16V22.5001C26.25 24.5712 24.5711 26.2501 22.5 26.2501V26.2501C20.4289 26.2501 18.75 24.5712 18.75 22.5001V21.2501C18.75 19.1791 17.0711 17.5001 15 17.5001V17.5001C12.9289 17.5001 11.25 19.1791 11.25 21.2501V22.5001C11.25 24.5712 9.57107 26.2501 7.5 26.2501V26.2501C5.42893 26.2501 3.75 24.5712 3.75 22.5001V17.16C3.75 15.632 3.75 14.868 3.89411 14.1436C4.08626 13.1776 4.46679 12.2589 5.01398 11.4399C5.42437 10.8257 5.9646 10.2855 7.04505 9.20507V9.20507Z" fill="<?= (@$active_dash != null) ? 'black' : 'white' ?>" />
                            </svg>
                        </i>
                        <span class="<?= (@$active_dash != null) ? 'text-black' : 'text-white' ?>">Dashboard</span>
                    </a>
                </li>
                <?php
                // }
                ?>
                <?php if(session('logged_user')->role == 'referral' || session('logged_user')->role == 'superadmin'): ?> 
                <li class="<?= @$active_referral ?>">
                    <a href="<?= BASE_URL ?>hedgefund/referral" class="iq-waves-effect">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>">
                                <g clip-path="url(#clip0_270_79)">
                                    <path d="M15 13.525C17.4612 13.525 19.4563 11.5299 19.4563 9.06877C19.4563 6.60765 17.4612 4.61252 15 4.61252C12.5389 4.61252 10.5438 6.60765 10.5438 9.06877C10.5438 11.5299 12.5389 13.525 15 13.525Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    <path d="M20.6625 14.9063L19.6125 14.5938L15 19.2125L10.3874 14.5938L9.33741 14.9063C6.61864 15.725 4.79363 18.175 4.79363 21.0125V26.2501H25.2061V21.0125C25.2062 18.175 23.3813 15.725 20.6625 14.9063Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    <path d="M20.2688 3.75C19.5134 3.75 18.7894 3.95363 18.1539 4.31735C19.6906 5.34091 20.7062 7.08779 20.7062 9.06852C20.7062 10.2426 20.3491 11.3344 19.7389 12.2426C19.9142 12.2647 20.0907 12.2813 20.2688 12.2813C22.625 12.2813 24.5375 10.3688 24.5375 8.01252C24.5375 5.66242 22.625 3.75 20.2688 3.75Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    <path d="M25.6625 13.5312L24.6438 13.2312L23.1486 14.7265C25.1885 16.1177 26.4564 18.4318 26.4564 21.0125V24.375H30.0001V19.3625C30 16.6563 28.2563 14.3125 25.6625 13.5312Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    <path d="M11.8461 4.31735C11.2107 3.95363 10.4867 3.75 9.73128 3.75C7.37503 3.75 5.46254 5.66242 5.46254 8.01252C5.46254 10.3688 7.37503 12.2813 9.73128 12.2813C9.90933 12.2813 10.0859 12.2646 10.2611 12.2426C9.65086 11.3345 9.2938 10.2426 9.2938 9.06852C9.2938 7.08779 10.3094 5.34091 11.8461 4.31735Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    <path d="M5.35628 13.2312L4.34377 13.5312H4.33748C1.74377 14.3125 0 16.6563 0 19.3625V24.375H3.54371V21.0125C3.54371 18.4312 4.81223 16.1167 6.85109 14.7261L5.35628 13.2312Z" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_270_79">
                                        <rect width="30" height="30" fill="<?= (@$active_referral != null) ? 'black' : 'white' ?>" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </i>
                        <span class="<?= (@$active_referral != null) ? 'text-black' : 'text-white' ?>">Referral</span>
                    </a>
                </li>
                <?php endif ?>
                <li class="<?= @$active_withdraw ?>">
                    <a href="<?= BASE_URL ?>hedgefund/withdraw" class="iq-waves-effect">
                        <i>
                            <svg width="35" height="35" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" fill="<?= (@$active_withdraw != null) ? 'black' : 'white' ?>">
                              <rect x="36" y="40" width="56" height="64" rx="8" />
                              <circle cx="64" cy="72" r="12" fill="white" />
                              <path d="M28 24h72c2.21 0 4 1.79 4 4v16c0 2.21-1.79 4-4 4s-4-1.79-4-4V32H32v12c0 2.21-1.79 4-4 4s-4-1.79-4-4V28c0-2.21 1.79-4 4-4z"/>
                            </svg>
                        </i>
                        <span class="<?= (@$active_withdraw != null) ? 'text-black' : 'text-white' ?>">Withdraw</span>
                    </a>
                </li>
                <!-- <li class="<?= @$active_membership ?>">
                    <a href="<?= BASE_URL ?>hedgefund/membership" class="iq-waves-effect">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M15 0C12.2791 0 9.75581 0.686047 7.43023 2.05814C5.17442 3.38372 3.38372 5.17442 2.05814 7.43023C0.686047 9.75581 0 12.2791 0 15C0 17.7209 0.686047 20.2442 2.05814 22.5698C3.38372 24.8256 5.17442 26.6163 7.43023 27.9419C9.75581 29.314 12.2791 30 15 30C17.7209 30 20.2442 29.314 22.5698 27.9419C24.8256 26.6163 26.6163 24.8256 27.9419 22.5698C29.314 20.2442 30 17.7209 30 15C30 12.2791 29.314 9.75581 27.9419 7.43023C26.6163 5.17442 24.8256 3.38372 22.5698 2.05814C20.2442 0.686047 17.7209 0 15 0ZM15 3.76744C16.8372 3.76744 18.5581 4.18605 20.1628 5.02326C21.7674 5.86047 23.0988 7.01744 24.157 8.49419C25.2151 9.97093 25.8721 11.6163 26.1279 13.4302H23.7209C23.4419 13.4302 23.1453 13.3547 22.8314 13.2035C22.5174 13.0523 22.2791 12.8605 22.1163 12.6279L19.1163 8.65116C18.9535 8.4186 18.75 8.30233 18.5058 8.30233C18.2616 8.30233 18.0581 8.4186 17.8953 8.65116L12.1047 16.3953C11.9419 16.6047 11.7384 16.7093 11.4942 16.7093C11.25 16.7093 11.0465 16.6047 10.8837 16.3953L9.27907 14.2674C9.11628 14.0349 8.87791 13.8372 8.56395 13.6744C8.25 13.5116 7.96512 13.4302 7.7093 13.4302H3.87209C4.12791 11.6163 4.78488 9.97093 5.84302 8.49419C6.90116 7.01744 8.23256 5.86047 9.83721 5.02326C11.4419 4.18605 13.1628 3.76744 15 3.76744ZM15 26.2326C13.1628 26.2326 11.4419 25.814 9.83721 24.9767C8.23256 24.1395 6.90116 22.9826 5.84302 21.5058C4.78488 20.0291 4.12791 18.3837 3.87209 16.5698H6.27907C6.55814 16.5698 6.85465 16.6512 7.1686 16.814C7.48256 16.9767 7.72093 17.1628 7.88372 17.3721L10.8837 21.3837C11.0465 21.593 11.25 21.6977 11.4942 21.6977C11.7384 21.6977 11.9419 21.593 12.1047 21.3837L17.8953 13.6395C18.0581 13.407 18.2616 13.2907 18.5058 13.2907C18.75 13.2907 18.9535 13.407 19.1163 13.6395L20.7209 15.7674C20.8837 15.9767 21.1221 16.1628 21.436 16.3256C21.75 16.4884 22.0349 16.5698 22.2907 16.5698H26.1279C25.8721 18.3837 25.2151 20.0291 24.157 21.5058C23.0988 22.9826 21.7674 24.1395 20.1628 24.9767C18.5581 25.814 16.8372 26.2326 15 26.2326Z" fill="<?= (@$active_membership != null) ? 'black' : 'white' ?>" />
                            </svg>
                        </i>
                        <span class="<?= (@$active_membership != null) ? 'text-black' : 'text-white' ?>">Membership</span>
                    </a>
                </li> -->
                <?php
                // }
                ?>
                <li>
                    <a href="<?= BASE_URL ?>hedgefund/auth/logout" class="iq-waves-effect">
                        <i>
                            <svg width="36" height="37" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 18.561H31.5M31.5 18.561L27.75 14.811M31.5 18.561L27.75 22.311M22.5 13.311V13.161C22.5 9.78628 22.5 8.0989 21.6406 6.916C21.363 6.53398 21.0271 6.19802 20.645 5.92046C19.4621 5.06104 17.7748 5.06104 14.4 5.06104H12.6C9.22524 5.06104 7.53786 5.06104 6.35497 5.92046C5.97294 6.19802 5.63698 6.53398 5.35942 6.916C4.5 8.0989 4.5 9.78628 4.5 13.161V23.961C4.5 27.3358 4.5 29.0232 5.35942 30.2061C5.63698 30.5881 5.97294 30.9241 6.35497 31.2016C7.53786 32.061 9.22524 32.061 12.6 32.061H14.4C17.7748 32.061 19.4621 32.061 20.645 31.2016C21.0271 30.9241 21.363 30.5881 21.6406 30.2061C22.5 29.0232 22.5 27.3358 22.5 23.961V23.811" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- TOP Nav Bar -->
<div class="iq-top-navbar d-block d-lg-none">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-menu-bt d-flex align-items-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                    <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                </div>
                <div class="iq-navbar-logo d-flex justify-content-between">
                    <a href="<?= BASE_URL ?>hedgefund/dashboard" class="header-logo">
                        <div class="logo-title d-flex align-items-center">
                            <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo-sidebar-admin" alt="logo pnglobal">
                            <span class="text-white text-uppercase">PN GLOBAL</span>
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- TOP Nav Bar END -->