<style>
    #video-container.normal-mode {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        /* 5 kolom */
        grid-template-rows: repeat(5, 1fr);
        /* 5 baris */
        gap: 10px;
        height: 90vh;
        /* penuh 1 layar */
        padding: 10px;
        box-sizing: border-box;
        overflow: hidden;
    }

    #video-container.performer-mode {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        /* lebih lega */
        padding: 20px;
        box-sizing: border-box;
        overflow: hidden;
        height: 90vh;
    }


    .video-wrapper {
        background: black;
        width: 100%;
        height: 100%;
        position: relative;
    }

    .video-wrapper video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .badge-overlay {
        position: absolute;
        top: 5px;
        left: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 2px 6px;
        font-size: 12px;
        border-radius: 4px;
    }
</style>

<div class="d-flex flex-column mx-3 my-2 text-center" style="height: 100vh;">
    <div class="row m-0 mb-2 h-100">
        <div class="col-9 p-0 border border-2 border-primary">
        <canvas class="d-none" id="recordCanvas" width="1280" height="720"></canvas>
            <div id="video-container">
                <!-- <?php for ($i = 0; $i < 20; $i++): ?>
                    <div class="video-wrapper">
                        <video autoplay playsinline muted></video>
                        <div class="badge-overlay">👤 Member <?= $i + 1 ?></div>
                    </div>
                <?php endfor; ?> -->
            </div>
        </div>

        <div id="chatlive" class="col-3">
            <div class="d-flex flex-column h-100 border border-primary p-2 text-white">
                <!-- Chat body -->
                <div id="livechat" class="flex-grow-1 overflow-auto mb-2" style="max-height: 80vh;">
                    <p><strong>Amos:</strong> what are you doing here Rebecca?</p>
                    <p><strong>Becky:</strong> I'm learning about crypto.</p>
                    <p><strong>Amos:</strong> I can teach you my dear...</p>
                    <p><strong>Becky:</strong> but I want to learn by myself :p</p>
                    <p><strong>Principe:</strong> You two don’t be noisy. I’m teaching something important.</p>
                    <p><strong>xxx:</strong> Hahaha.. lets go to the party...</p>
                    <p><strong>Principe:</strong></p>
                    <p><strong>Amos:</strong> what are you doing here Rebecca?</p>
                    <p><strong>Becky:</strong> I'm learning about crypto.</p>
                    <p><strong>Amos:</strong> I can teach you my dear...</p>
                    <p><strong>Becky:</strong> but I want to learn by myself :p</p>
                    <p><strong>Principe:</strong> You two don’t be noisy. I’m teaching something important.</p>
                    <p><strong>xxx:</strong> Hahaha.. lets go to the party...</p>
                    <p><strong>Principe:</strong></p>
                </div>

                <!-- Chat input -->
                <div class="d-flex align-items-center border border-primary rounded p-1">
                    <input id="message" type="text" data-sender="<?= $user ?>" class="form-control bg-transparent text-white border-0" placeholder="Message...">
                    <button class="btn btn-sm ms-2" id="sendmsg">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Bagian tombol di bawah -->
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <button class="btn p-0 px-2 d-flex flex-column align-items-center"><i>
                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.219 7.86169L35.6592 9.38162C36.4882 9.52655 37.2806 9.83367 37.9908 10.2852C38.7011 10.7367 39.3153 11.3239 39.7983 12.0132C40.2813 12.7024 40.6237 13.4801 40.8057 14.3018C40.9877 15.1235 41.0061 15.9731 40.8593 16.8018L37.5192 35.7021C37.3766 36.5305 37.0718 37.3223 36.6224 38.0324C36.1728 38.7426 35.5874 39.3568 34.8998 39.84C34.2122 40.3232 33.4358 40.6658 32.6153 40.8482C31.7949 41.0304 30.9467 41.0488 30.1191 40.9022L14.3588 38.1224C13.5289 37.9764 12.736 37.6681 12.0255 37.2149C11.3151 36.7619 10.7011 36.1731 10.2188 35.4823" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M19.5217 1.10158C20.3479 0.952101 21.1959 0.967721 22.0161 1.1476C22.8365 1.32751 23.6129 1.66809 24.301 2.1497C24.989 2.63129 25.5748 3.24438 26.0246 3.95358C26.4744 4.66275 26.7794 5.45396 26.9218 6.28162L30.2617 25.2019C30.4113 26.0283 30.3957 26.8763 30.2157 27.6966C30.0359 28.517 29.6953 29.2934 29.2136 29.9814C28.732 30.6694 28.119 31.2552 27.4098 31.705C26.7006 32.1548 25.9094 32.4598 25.0818 32.6022L9.32138 35.3821C7.65051 35.6789 5.93022 35.2999 4.53875 34.3285C3.14728 33.3571 2.19861 31.8728 1.90124 30.202L1.28125 26.6419" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.30169 26.6419C0.335372 20.8394 1.71142 14.8908 5.12764 10.1021C8.54386 5.31338 13.7209 2.07624 19.5221 1.10156" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.14229 25.7219C0.122272 17.3818 9.14242 22.5619 13.3225 16.5218C17.5026 10.4817 11.3225 2.52159 19.5427 1.10156" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </i>Send File</button>
            <button class="btn p-0 px-2 d-flex flex-column align-items-center"><i>
                    <svg width="55" height="40" viewBox="0 0 55 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.78898 10.1329H24.4863C25.474 10.1329 26.2753 10.9342 26.2753 11.9219V26.3374C26.2753 27.3251 25.474 28.1264 24.4863 28.1264H12.6127L9.01399 31.5869L5.27715 28.1264H1.78898C0.801243 28.1264 0 27.3251 0 26.3374V11.9219C0 10.9342 0.801243 10.1329 1.78898 10.1329Z" fill="#E9C684" />
                        <path d="M9.01399 31.58L5.27715 28.1195H1.78898C0.801243 28.1195 0 27.3182 0 26.3305V11.9219C0 10.9342 0.801243 10.1329 1.78898 10.1329H24.4932C25.4809 10.1329 26.2822 10.9342 26.2822 11.9219V26.3374C26.2822 27.3251 25.4809 28.1264 24.4932 28.1264H12.6196L9.01399 31.58ZM2.68002 25.4394H6.32706L8.97945 27.8915L11.5351 25.4394H23.5952V12.813H2.68002V25.4394Z" fill="#B48B3D" />
                        <path d="M15.79 1.78894H50.9411C51.9289 1.78894 52.7301 2.59018 52.7301 3.57792V31.1379C52.7301 32.1257 51.9289 32.9269 50.9411 32.9269H38.7153L33.9147 37.541L28.9277 32.9269H15.7831C14.7954 32.9269 13.9941 32.1257 13.9941 31.1379V3.57792C14.001 2.59018 14.8023 1.78894 15.79 1.78894Z" fill="black" />
                        <path d="M33.9422 40L28.2368 34.7159H15.7899C13.8213 34.7159 12.2119 33.1135 12.2119 31.138V3.57797C12.2119 1.60939 13.8144 0 15.7899 0H50.941C52.9095 0 54.5189 1.60249 54.5189 3.57797V31.138C54.5189 33.1065 52.9165 34.7159 50.941 34.7159H39.4335L33.9422 40ZM15.7899 3.57797V31.138H29.632L33.8938 35.082L37.9968 31.138H50.941V3.57797H15.7899Z" fill="#B48B3D" />
                        <path d="M37.9347 18.477H33.7766L33.7628 19.2299C33.742 20.2038 32.9477 20.9843 31.9738 20.9843H31.9669C31.0137 20.9843 30.24 20.2107 30.24 19.2575V19.223L30.2884 16.6604C30.3091 15.7072 31.0689 14.9405 32.0083 14.9059C32.0636 14.899 32.1188 14.899 32.1741 14.899H36.1319V11.625H29.4941C28.5063 11.625 27.7051 10.8237 27.7051 9.83598C27.7051 8.84824 28.5063 8.047 29.4941 8.047H37.9209C38.9087 8.047 39.7099 8.84824 39.7099 9.83598V16.688C39.7099 17.6688 38.9156 18.4632 37.9347 18.477ZM30.1779 25.1149V24.9353C30.1779 23.9475 30.9791 23.1463 31.9669 23.1463C32.9546 23.1463 33.7558 23.9475 33.7558 24.9353V25.1149C33.7558 26.1026 32.9546 26.9038 31.9669 26.9038C30.9791 26.9038 30.1779 26.1026 30.1779 25.1149Z" fill="#B48B3D" />
                    </svg>


                </i>Ask</button>
            <button id="startlive" class="btn py-0 px-2 d-flex flex-column align-items-center"><i>
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.5654 0H15.1153C13.3432 0 11.9022 1.44081 11.9022 3.213V11.9H3.21267C1.44032 11.9 0 13.3409 0 15.113V36.5658C0 38.3376 1.44032 39.7785 3.21267 39.7785H19.3486C19.3291 39.6805 19.3038 39.5863 19.2919 39.4856L18.8519 35.7067H4.07183V15.972H11.9023V24.6628C11.9023 26.4352 13.3433 27.8756 15.1153 27.8756H17.9414L17.4668 23.8042H15.9741V15.972H23.8065V18.4291L27.8784 20.4255V15.113C27.8784 13.3409 26.4376 11.9 24.6652 11.9H15.974V4.07183H35.7063V23.8042H34.7679L38.7271 25.7458C38.9659 25.8638 39.1818 26.0109 39.3847 26.1727C39.6271 25.7206 39.7779 25.2118 39.7779 24.6628V3.213C39.778 1.44081 38.3375 0 36.5654 0Z" fill="#B48B3D" />
                        <path d="M37.5296 28.1806L21.2317 20.1896C21.1003 20.126 20.9597 20.0941 20.8194 20.0941C20.6286 20.0941 20.4392 20.1512 20.2787 20.2651C19.9989 20.4624 19.8507 20.798 19.89 21.1386L21.9884 39.1717C22.0324 39.5468 22.2974 39.8593 22.6605 39.9629C22.7451 39.9881 22.8328 40 22.9189 40C23.1986 40 23.4703 39.8727 23.6492 39.6476L29.1325 32.7829L37.4235 29.9054C37.7811 29.782 38.0278 29.4559 38.0519 29.0782C38.0742 28.7016 37.8688 28.3477 37.5296 28.1806Z" fill="#B48B3D" />
                    </svg>


                </i>Start Live</button>
            <div style="margin-top: 10px;">
                <button class="btn fw-bold" id="prevbtn">PREV</button>
                <button class="btn fw-bold" id="nextbtn">NEXT</button>
                <button class="btn fw-bold" id="modebtn">MODE</button>
                <button class="d-none" id="startRecord">Start Record</button>
                <button class="d-none" id="stopRecord" disabled>Stop Record</button>
            </div>
        </div>
        <button id="btnleave" class="btn p-0 px-2"><i>
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.5858 24.5858C29.8048 25.3668 29.8048 26.6332 30.5858 27.4142C31.3668 28.1952 32.6332 28.1952 33.4142 27.4142L39.2402 21.5882C39.2702 21.5582 39.2994 21.5274 39.3274 21.496C39.74 21.1296 40 20.5952 40 20C40 19.4048 39.74 18.8704 39.3274 18.504C39.2994 18.4726 39.2702 18.4418 39.2402 18.4118L33.4142 12.5858C32.6332 11.8047 31.3668 11.8047 30.5858 12.5858C29.8048 13.3668 29.8048 14.6332 30.5858 15.4142L33.1716 18H22C20.8954 18 20 18.8954 20 20C20 21.1046 20.8954 22 22 22H33.1716L30.5858 24.5858Z" fill="#B48B3D" />
                    <path d="M6 0C2.6863 0 0 2.6863 0 6V34C0 37.3138 2.6863 40 6 40H25C27.7614 40 30 37.7614 30 35V29.4652C29.7038 29.294 29.425 29.0818 29.1716 28.8284C27.8628 27.5196 27.6506 25.5298 28.5348 24H22C19.7908 24 18 22.2092 18 20C18 17.7908 19.7908 16 22 16H28.5348C27.6506 14.4703 27.8628 12.4803 29.1716 11.1716C29.425 10.9182 29.7038 10.7059 30 10.5348V5C30 2.23858 27.7614 0 25 0H6Z" fill="#B48B3D" />
                </svg>

            </i></button>
    </div>
</div>