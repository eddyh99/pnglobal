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

    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">

                <li class="<?= @$active_dash ?>">
                    <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/luxbtc" class="iq-waves-effect">
                        <i>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.04505 9.20507C9.51607 6.73405 10.7516 5.49854 12.1299 4.92763C13.9676 4.16642 16.0324 4.16642 17.8701 4.92763C19.2484 5.49854 20.4839 6.73405 22.955 9.20507V9.20507C24.0354 10.2855 24.5756 10.8257 24.986 11.4399C25.5332 12.2589 25.9137 13.1776 26.1059 14.1436C26.25 14.868 26.25 15.632 26.25 17.16V22.5001C26.25 24.5712 24.5711 26.2501 22.5 26.2501V26.2501C20.4289 26.2501 18.75 24.5712 18.75 22.5001V21.2501C18.75 19.1791 17.0711 17.5001 15 17.5001V17.5001C12.9289 17.5001 11.25 19.1791 11.25 21.2501V22.5001C11.25 24.5712 9.57107 26.2501 7.5 26.2501V26.2501C5.42893 26.2501 3.75 24.5712 3.75 22.5001V17.16C3.75 15.632 3.75 14.868 3.89411 14.1436C4.08626 13.1776 4.46679 12.2589 5.01398 11.4399C5.42437 10.8257 5.9646 10.2855 7.04505 9.20507V9.20507Z" fill="<?= (@$active_dash != null) ? 'black' : 'white' ?>" />
                            </svg>
                        </i>
                        <span class="<?= (@$active_dash != null) ? 'text-black' : 'text-white' ?>">Dashboard</span>
                    </a>
                </li>

                <li class="<?= @$active_reff ?>">
                    <a translate="no" href="<?= BASE_URL ?>godmode/referral/luxbtc" class="iq-waves-effect">
                        <i>
                        <svg width="31" height="28" viewBox="0 0 31 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18.5 11H15.5H12.5C10.85 11 9.5 12.35 9.5 14V18.5C9.5 19.05 9.75 19.55 10.1 19.9C10.45 20.25 10.95 20.5 11.5 20.5V25C11.5 26.65 12.85 28 14.5 28H15.5H16.5C18.15 28 19.5 26.65 19.5 25V20.5C20.05 20.5 20.55 20.3 20.9 19.9C21.25 19.55 21.5 19.05 21.5 18.5V14C21.5 12.35 20.15 11 18.5 11Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
<path d="M15.5 9C17.433 9 19 7.433 19 5.5C19 3.567 17.433 2 15.5 2C13.567 2 12 3.567 12 5.5C12 7.433 13.567 9 15.5 9Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
<path d="M8.3 22.35C8.2 22.25 8.05 22.15 7.95 22.05C7 21.05 6.45 19.8 6.45 18.5V14C6.45 12.4 7.1 10.9 8.15 9.85C8.45 9.55 8.2 9 7.8 9C6.95 9 6 9 6 9H3C1.35 9 0 10.35 0 12V16.5C0 17.05 0.25 17.55 0.6 17.9C0.95 18.25 1.45 18.5 2 18.5V23C2 24.65 3.35 26 5 26H6H7C7.45 26 7.85 25.9 8.2 25.75C8.4 25.65 8.5 25.5 8.5 25.3C8.5 24.7 8.5 23.3 8.5 22.75C8.5 22.6 8.45 22.45 8.3 22.35Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
<path d="M6 7C7.933 7 9.5 5.433 9.5 3.5C9.5 1.567 7.933 0 6 0C4.067 0 2.5 1.567 2.5 3.5C2.5 5.433 4.067 7 6 7Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
<path d="M28 9H25C25 9 24.05 9 23.2 9C22.75 9 22.55 9.5 22.85 9.85C23.9 10.95 24.55 12.4 24.55 14V18.5C24.55 19.8 24.05 21.05 23.05 22.05C22.95 22.15 22.85 22.25 22.7 22.35C22.6 22.45 22.5 22.6 22.5 22.75C22.5 23.3 22.5 24.65 22.5 25.3C22.5 25.5 22.6 25.7 22.8 25.75C23.15 25.9 23.55 26 24 26H25H26C27.65 26 29 24.65 29 23V18.5C29.55 18.5 30.05 18.3 30.4 17.9C30.75 17.55 31 17.05 31 16.5V12C31 10.35 29.65 9 28 9Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
<path d="M25 7C26.933 7 28.5 5.433 28.5 3.5C28.5 1.567 26.933 0 25 0C23.067 0 21.5 1.567 21.5 3.5C21.5 5.433 23.067 7 25 7Z" fill="<?= (@$active_reff != null) ? 'black' : 'white' ?>"/>
</svg>
                        </i>
                        <span class="<?= (@$active_reff != null) ? 'text-black' : 'text-white' ?>">Referral/Seller</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>