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
        <a href="#" class="header-logo">
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
                $loggedUser = $_SESSION['logged_user'] ?? null;
                if ($loggedUser && isset($loggedUser->email) && $loggedUser->email === 'a@a.a') {
                    // Untuk user a@a.a, kita langsung set semua akses sebagai super admin
                    $access = ['subscriber', 'signal', 'message', 'freemember', 'payment'];
                } else {
                    $access = $loggedUser && is_string($loggedUser->access)
                        ? json_decode($loggedUser->access, true)
                        : ($loggedUser->access ?? []);
                }
                ?>


                <li class="<?= @$active_message ?>">
                    <a href="<?= BASE_URL ?>/course/mentor/message" class="iq-waves-effect">
                        <i>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.75 15C3.75 13.2576 3.75 12.3863 3.89411 11.6618C4.48591 8.68665 6.81165 6.36091 9.78684 5.76911C10.5113 5.625 11.3826 5.625 13.125 5.625H16.875C18.6174 5.625 19.4887 5.625 20.2132 5.76911C23.1883 6.36091 25.5141 8.68665 26.1059 11.6618C26.25 12.3863 26.25 13.2576 26.25 15V15C26.25 16.7424 26.25 17.6137 26.1059 18.3382C25.5141 21.3133 23.1883 23.6391 20.2132 24.2309C19.4887 24.375 18.6174 24.375 16.875 24.375H13.125C11.3826 24.375 10.5113 24.375 9.78684 24.2309C6.81165 23.6391 4.48591 21.3133 3.89411 18.3382C3.75 17.6137 3.75 16.7424 3.75 15V15Z" stroke="<?= (@$active_message != null) ? 'black' : 'white' ?>" stroke-width="2.25" stroke-linejoin="round" />
                                <path d="M3.75 10L6.71216 12.3038C10.2366 15.0449 11.9988 16.4155 14.0118 16.6831C14.668 16.7704 15.3329 16.7703 15.9892 16.6831C18.0021 16.4153 19.7643 15.0447 23.2886 12.3034L26.25 10" stroke="<?= (@$active_message != null) ? 'black' : 'white' ?>" stroke-width="2.25" stroke-linejoin="round" />
                            </svg>
                        </i>
                        <span class="<?= (@$active_message != null) ? 'text-black' : 'text-white' ?>">Message</span>
                    </a>
                </li>

                    <li class="<?= @$active_explore ?>">
                        <a href="<?= BASE_URL ?>course/mentor/explore" class="iq-waves-effect">
                            <i>
                                <svg width="30" height="30" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9998 13.2838C12.1578 12.6515 12.6515 12.1578 13.2838 11.9997L19.3859 10.4742C20.6782 10.1511 21.8489 11.3218 21.5258 12.6143L20.0004 18.7163C19.8423 19.3486 19.3485 19.8424 18.7164 20.0003L12.6142 21.5259C11.3218 21.849 10.1511 20.6783 10.4742 19.3858L11.9998 13.2838Z" stroke="<?= (@$active_explore != null) ? 'black' : 'white' ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16 1C4.52941 1 1 4.52941 1 16C1 27.4706 4.52941 31 16 31C27.4706 31 31 27.4706 31 16C31 4.52941 27.4706 1 16 1Z" stroke="<?= (@$active_explore != null) ? 'black' : 'white' ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </i>
                            <span class="<?= (@$active_explore != null) ? 'text-black' : 'text-white' ?>">Explore</span>
                        </a>
                    </li>


                    <li class="<?= @$active_live ?>">
                        <a href="<?= BASE_URL ?>course/mentor/live" class="iq-waves-effect">
                            <i>
                                <svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.4545 0.0908203C20.8162 0.0908203 21.1631 0.234489 21.4188 0.49022C21.6745 0.745952 21.8182 1.0928 21.8182 1.45446V7.18173L28.9268 2.20446C29.029 2.13281 29.149 2.09059 29.2735 2.08241C29.3981 2.07424 29.5225 2.10041 29.6332 2.15809C29.7439 2.21576 29.8367 2.30272 29.9013 2.40948C29.966 2.51625 30.0001 2.63872 30 2.76355V19.2363C30.0001 19.3611 29.966 19.4836 29.9013 19.5903C29.8367 19.6971 29.7439 19.7841 29.6332 19.8417C29.5225 19.8994 29.3981 19.9256 29.2735 19.9174C29.149 19.9092 29.029 19.867 28.9268 19.7954L21.8182 14.8181V20.5454C21.8182 20.907 21.6745 21.2539 21.4188 21.5096C21.1631 21.7653 20.8162 21.909 20.4545 21.909H1.36364C1.00198 21.909 0.655131 21.7653 0.3994 21.5096C0.143668 21.2539 0 20.907 0 20.5454V1.45446C0 1.0928 0.143668 0.745952 0.3994 0.49022C0.655131 0.234489 1.00198 0.0908203 1.36364 0.0908203H20.4545ZM19.0909 2.81809H2.72727V19.1817H19.0909V2.81809ZM8.72727 6.67582C8.83105 6.67554 8.93276 6.70487 9.02045 6.76037L14.9591 10.5404C15.0362 10.5897 15.0997 10.6576 15.1437 10.7379C15.1877 10.8183 15.2107 10.9083 15.2107 10.9999C15.2107 11.0915 15.1877 11.1816 15.1437 11.2619C15.0997 11.3422 15.0362 11.4101 14.9591 11.4595L9.02045 15.2408C8.93774 15.2935 8.84234 15.323 8.7443 15.3261C8.64625 15.3291 8.5492 15.3057 8.46335 15.2582C8.37751 15.2108 8.30605 15.141 8.2565 15.0564C8.20696 14.9717 8.18116 14.8753 8.18182 14.7772V7.22264C8.18182 6.92127 8.42727 6.67582 8.72727 6.67582ZM27.2727 6.69082L21.8182 10.509V11.4881L27.2727 15.3063V6.69082Z" fill="<?= (@$active_live != null) ? 'black' : 'white' ?>" />
                                </svg>


                            </i>
                            <span class="<?= (@$active_live != null) ? 'text-black' : 'text-white' ?>">Live</span>
                        </a>
                    </li>

                <li class="<?= @$active_score ?>">
                    <a href="<?= BASE_URL ?>course/mentor/score" class="iq-waves-effect">
                        <i>
                            <svg width="28" height="30" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.9917 22.7281L11.4084 21.7725V30H16.536V21.332L15.9332 21.0122L12.9917 22.7281Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M17.5165 30.0001H22.6435V24.5729L17.5165 21.8525V30.0001Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M23.624 25.0933V30.0001H27.9444V27.3856L23.624 25.0933Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M5.3009 29.9999H10.428V21.1802L5.3009 18.0845V29.9999Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M0 30.0002H4.32035V17.4926L0 14.8843V30.0002Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M12.3506 4.54184C13.602 4.42548 14.5227 3.31618 14.4059 2.06473C14.29 0.814167 13.1812 -0.106048 11.9293 0.00985034C10.6787 0.125749 9.75811 1.23458 9.87441 2.48649C9.99031 3.73753 11.0987 4.65768 12.3506 4.54184Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M20.0659 18.2164L18.9791 14.6396C18.9345 14.7172 18.8895 14.7948 18.8383 14.8685C18.3409 15.5838 17.5586 16.0406 16.6911 16.1205L16.2913 16.1478L17.4308 18.9112C17.6725 19.3114 17.9713 19.6744 18.3179 19.9889L21.281 22.6795C21.6989 23.0429 22.3309 23.0085 22.7077 22.6015L22.7345 22.5737C23.1099 22.1678 23.0965 21.5377 22.7053 21.1479L20.0659 18.2164Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M12.5264 7.2266L13.2847 7.53105L13.5098 6.70184L13.0415 5.90479L12.1477 6.58078L12.5264 7.2266Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                                <path d="M12.2142 20.5431L12.2545 20.5335C12.7917 20.4004 13.132 19.8729 13.031 19.33L12.3785 15.8283L16.6825 15.5295C17.3002 15.4864 17.8661 15.1656 18.2194 14.6572C18.5732 14.1478 18.6761 13.5062 18.5014 12.9117L18.3395 12.3635L16.9938 7.46139L19.3009 7.58584L21.1451 9.36252C21.056 9.47121 21.0115 9.61342 21.0474 9.76084L21.1982 10.3713L20.1258 10.6361C19.8721 10.6978 19.7174 10.9545 19.7801 11.2082L20.5021 14.1377C20.5652 14.392 20.8214 14.5466 21.0747 14.4848L25.6249 13.3627C25.8791 13.2994 26.0337 13.0428 25.971 12.7886L25.2486 9.85957C25.1863 9.60633 24.9297 9.45071 24.676 9.51246L23.6035 9.77719L23.4532 9.1677C23.3919 8.9202 23.1415 8.76891 22.8935 8.82973L22.7815 8.8575C22.7561 8.75362 22.7101 8.65307 22.6412 8.56307L20.8372 6.19752C20.6429 5.94282 20.3657 5.76334 20.054 5.69098L17.087 4.62909C16.0831 4.27002 14.9747 4.42084 14.0996 5.01686L13.8425 8.66789L11.4793 7.01332L9.82998 8.27871L7.16086 7.31543C6.74244 7.13016 6.25359 7.30828 6.05349 7.71903L6.02572 7.77551C5.92711 7.97948 5.91269 8.21356 5.9874 8.42661C6.06158 8.64059 6.21867 8.81538 6.42351 8.91399L9.64078 10.4498C10.041 10.6413 10.5069 10.6395 10.9057 10.445L12.6211 9.30416L13.7979 12.6785L10.9507 12.9279C10.4715 12.9714 10.0353 13.2266 9.76383 13.624C9.49289 14.0213 9.41385 14.5197 9.54791 14.9827L10.9631 19.8224C11.1203 20.3597 11.6713 20.6767 12.2142 20.5431ZM23.0003 9.26157L23.0218 9.27399L23.1722 9.88395L21.6301 10.2645L21.4841 9.6733C21.7704 9.90791 22.1793 9.92561 22.4766 9.6958L22.4938 9.68286C22.6183 9.58659 22.7055 9.4602 22.7552 9.32239L23.0003 9.26157ZM15.0954 11.6061C15.1098 11.7618 14.9963 11.8977 14.8412 11.913C14.6866 11.9264 14.5496 11.8134 14.5344 11.6583C14.5204 11.5027 14.634 11.3658 14.7895 11.3519C14.9436 11.3375 15.0811 11.4505 15.0954 11.6061ZM14.3447 9.8093C14.4989 9.79495 14.6363 9.90797 14.6507 10.0631C14.6651 10.2187 14.5511 10.3561 14.3965 10.37C14.2419 10.3839 14.1045 10.2708 14.0906 10.1157C14.0757 9.96059 14.1896 9.82366 14.3447 9.8093Z" fill="<?= (@$active_score != null) ? 'black' : 'white' ?>" />
                            </svg>

                        </i>
                        <span class="<?= (@$active_score != null) ? 'text-black' : 'text-white' ?>">Score</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>course/auth/logout" class="iq-waves-effect">
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
                    <a href="<?= BASE_URL ?>godmode/dashboard" class="header-logo">
                        <div class="logo-title d-flex align-items-center">
                            <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo-sidebar-admin" alt="logo pnglobal">
                            <span class="text-white text-uppercase">PN COURSE</span>
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- TOP Nav Bar END -->