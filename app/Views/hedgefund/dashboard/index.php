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

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <!-- Top Row: Referral Card -->
                <?php if ($isreferral || $_SESSION["logged_user"]->role == "superadmin"): ?>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="referral-card">
                                <div class="referral-link text-white">
                                    Referral link:
                                    <a href="https://pnglobalinternational.com/hf/<?= $refcode ?>" target="_blank">
                                        https://pnglobalinternational.com/hf/<?= $refcode ?>
                                    </a>
                                </div>
                                <div class="referral-qr">
                                    <!-- icons... -->
                                    <p>Show QR Code</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <!-- Second Row: USDT & BTC Cards Side by Side -->
                <div class="row mb-4">
                    <!-- USDT -->
                    <div class="col-lg-6 mb-2">
                        <div class="custom-card left-card mb-3">
                            <div class="card-row card-top text-center" style="font-weight: bold;">Funding Wallet</div>
                            <!-- <div class="card-row card-top">USDT</div>
                            <div class="card-row card-bottom">
                                <?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 2, '.', ',') ?>
                            </div> -->

                            <div class="d-flex" style="gap: 1rem;">
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                        <h2 class="text-right text-black"><?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                        <h2 class="text-right text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                            <?= @number_format($balance['fund']->btc ?? 0, 6, '.', ',') ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>hedgefund/deposit/option" class="btn-withdraw btn-lg" style="max-width:250px !important">DEPOSIT</a>
                            <a href="<?= BASE_URL ?>hedgefund/withdraw/transfer/fund" class="btn-withdraw btn-lg" style="max-width:250px !important">To Trade Wallet</a>
                        </div>
                        </a>
                    </div>

                    <!-- BTC -->
                    <div class="col-lg-6">
                        <div class="custom-card left-card mb-3">
                            <div class="card-row card-top text-center" style="font-weight: bold;">Unified Trading Wallet</div>
                            <div class="d-flex" style="gap: 1rem;">
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                        <h2 class="text-right text-black"><?= '$ ' . @number_format($balance['trade']->usdt ?? 0, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">BTC </h5>
                                        <h2 class="text-right text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                            <?= @number_format($balance['trade']->btc ?? 0, 6, '.', ','); ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>hedgefund/withdraw/transfer/trade" class="btn-withdraw btn-lg" style="max-width:250px !important">To Funds Wallet</a>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 dash-table-totalmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Deposit/Withdraw History</h4>
                        <table id="tablehistory_depositwithdraw" class="table table-striped" style="width:100%">
                            <thead class="thead_totalmember">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount Deposit</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12 mt-3 dash-table-totalmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Trade History</h4>
                        <table id="table_tradehistory" class="table table-striped" style="width:100%">
                            <thead class="thead_totalmember">
                                <tr>
                                    <th>Buy Price</th>
                                    <th>Sell Price</th>
                                    <th>Profit NET</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="whatsappModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; padding:1rem; border-radius:0.5rem; max-width:700px; width:98%; max-height:80vh; overflow-y:auto; text-align:center; position:relative;">
            <h4 style="color:black;">Add WhatsApp Number</h4>
            <p>Please enter your WhatsApp number to continue.</p>

            <div class="form-group mb-3 text-start" style="margin-top:1rem;">
                <label for="phone_number" class="fw-semibold">Phone Number</label>
                <div class="input-group" style="display:flex; gap:0.5rem;">
                    <select class="form-select" id="country_code" name="country_code" required style="flex:1; padding:0.5rem; max-width: 120px !important;"></select>
                    <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="8xxxxxxxxxxx" required style="flex:2; padding:0.5rem;">
                </div>
                <input type="hidden" id="full_phone" name="full_phone">
            </div>

            <button id="saveWhatsappBtn" style="padding:0.5rem 1rem; background:#bfa573; border:none; border-radius:0.3rem; color:#fff; cursor:pointer;" onclick="saveWhatsappNumber()">Verify</button>

        </div>
    </div>

    <?php if (!empty($phone_number) && !empty($otp)): ?>
        <!-- OTP Modal Custom -->
        <div id="otpModal" class="custom-modal">
            <div class="custom-modal-content">
                <h2 class="fw-bold mb-2" style="color: black;">ACTIVATION</h2>
                <p>We have sent an activation code to your WhatsApp.</p>

                <form id="satoshi-otp-form" onsubmit="setFormData(event)">
                    <div id="otp" class="otp-inputs">
                        <input type="text" id="first" maxlength="1" autofocus class="otp-box">
                        <input type="text" id="second" maxlength="1" class="otp-box">
                        <input type="text" id="third" maxlength="1" class="otp-box">
                        <input type="text" id="fourth" maxlength="1" class="otp-box">
                        <input type="hidden" name="email" id="emailInput" value="<?= session()->get('logged_user')->email ?>">
                        <input type="hidden" name="otp" id="otpInput">
                    </div>

                    <p>Enter the activation code in the column provided.</p>
                    <button type="submit" class="confirm-btn  mt-2">Confirm</button>
                </form>

                <div class="mt-3">
                    <button id="resend" onclick="resendTokenWhatsapp('<?= $phone_number ?? '' ?>')">RESEND</button> activation code
                </div>

                <div class="show-failed mt-2"></div>
            </div>
        </div>

        <style>
            /* Fullscreen overlay */
            .custom-modal {
                display: none;
                /* sembunyi default */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
                display: flex;
                /* flex centering */
                z-index: 9999;
            }

            /* Box putih di tengah */
            .custom-modal-content {
                background-color: #fff;
                padding: 30px 40px;
                border-radius: 12px;
                max-width: 400px;
                width: 90%;
                text-align: center;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            }

            /* OTP input boxes */
            .otp-inputs {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin: 20px 0;
            }

            .otp-box {
                width: 50px;
                height: 50px;
                font-size: 24px;
                text-align: center;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            /* Confirm button */
            .confirm-btn {
                width: 100%;
                padding: 12px 0;
                background-color: #bfa573;
                border: none;
                border-radius: 6px;
                color: white;
                font-size: 16px;
                cursor: pointer;
            }

            .confirm-btn:hover {
                background-color: #a17308;
            }

            /* Resend button */
            #resend {
                background: none;
                border: none;
                color: blue;
                font-weight: bold;
                cursor: pointer;
            }

            #resend:disabled {
                cursor: default;
                color: gray;
            }
        </style>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // ---------- ELEMENTS ----------
                const otpModal = document.getElementById('otpModal');
                const otpInputs = document.querySelectorAll('.otp-box');
                const resendBtn = document.getElementById('resend');
                const emailInput = document.getElementById('emailInput');

                const WAHA_URL = "<?= getenv('WAHA_URL') ?>";
                const WAHA_API_KEY = "<?= getenv('WAHA_API_KEY') ?>";
                const phone = "<?= $phone_number ?? '' ?>";

                // ---------- MODAL ----------
                function openOtpModal() {
                    otpModal.style.display = 'flex';
                }

                function closeOtpModal() {
                    otpModal.style.display = 'none';
                }
                openOtpModal(); // auto open on page load

                // ---------- OTP INPUT AUTO-MOVE ----------
                otpInputs.forEach((input, index) => {
                    input.addEventListener('input', (e) => {
                        const value = input.value;

                        // Paste >1 character → autofill
                        if (value.length > 1) {
                            const chars = value.split('');
                            otpInputs.forEach((box, i) => {
                                box.value = chars[i] || '';
                            });
                            otpInputs[Math.min(chars.length, otpInputs.length) - 1].focus();
                            return;
                        }

                        // Auto-move to next input
                        if (value.length === 1 && index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    });

                    input.addEventListener('keydown', (e) => {
                        // Backspace → move to previous input if empty
                        if (e.key === "Backspace" && input.value === "" && index > 0) {
                            otpInputs[index - 1].focus();
                        }
                    });
                });

                // ---------- SUBMIT OTP ----------
                document.getElementById('satoshi-otp-form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const otp = Array.from(otpInputs).map(i => i.value).join('');
                    const email = emailInput.value;

                    if (otp.length < otpInputs.length) {
                        alert('Please enter complete OTP');
                        return;
                    }

                    try {
                        const res = await fetch('<?= BASE_URL ?>hedgefund/dashboard/verif_otp', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                email,
                                otp
                            })
                        });

                        const data = await res.json();
                        alert(data.message);

                        if (data.success) closeOtpModal();

                    } catch (err) {
                        console.error(err);
                        alert("Failed to submit OTP: " + err.message);
                    }
                });

                // ---------- RESEND OTP WAHA ----------
                async function resendTokenWhatsapp() {
                    resendBtn.disabled = true;
                    const email = emailInput.value;
                    const chatId = phone.replace(/\D/g, '') + "@c.us";

                    try {
                        // 1️⃣ Ambil OTP dari backend
                        const otpRes = await fetch('<?= BASE_URL ?>hedgefund/auth/resend_token_whatsapp/', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                email
                            })
                        });
                        console.log(otpRes);

                        const otpData = await otpRes.json();

                        if (!otpData.success || !otpData.otp) {
                            alert('Failed to get OTP: ' + (otpData.message || 'Unknown error'));
                            resendBtn.disabled = false;
                            return;
                        }

                        const otp = otpData.otp;

                        // 2️⃣ Kirim OTP via WAHA API
                        const res = await fetch(WAHA_URL + "api/sendText", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Api-Key': WAHA_API_KEY
                            },
                            body: JSON.stringify({
                                session: "default",
                                chatId: chatId,
                                text: `This is your activation code: ${otp}`
                            })
                        });

                        if (res.status === 201) {
                            alert("OTP sent successfully to " + phone);

                            // countdown 60 detik
                            let countdown = 60;
                            const originalText = "RESEND";
                            const interval = setInterval(() => {
                                resendBtn.textContent = `RESEND (${countdown}s)`;
                                countdown--;
                                if (countdown < 0) {
                                    clearInterval(interval);
                                    resendBtn.disabled = false;
                                    resendBtn.textContent = originalText;
                                }
                            }, 1000);
                        } else {
                            alert("Failed to send OTP. Status: " + res.status);
                            resendBtn.disabled = false;
                        }

                    } catch (err) {
                        console.error(err);
                        alert("Error sending OTP: " + err.message);
                        resendBtn.disabled = false;
                    }
                }

                // Attach event listener ke tombol RESEND
                resendBtn.addEventListener('click', resendTokenWhatsapp);

            });
        </script>
    <?php endif; ?>