<script src="<?= BASE_URL ?>assets/js/admin/mandatory/RTCMultiConnection.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>

<script>
    var connection = new RTCMultiConnection();
    var url = new URL(window.location.href);
    var broadcastId = url.searchParams.get("room_id");
    var performer = false;
    const videos = [];
    let currentPage = 0;
    const pageSize = 25;
    let modePerformerOnly = false;
    let recorder, drawInterval;
    const canvas = document.getElementById('recordCanvas');
    const ctx = canvas.getContext('2d');
    const videosx = Array.from(document.querySelectorAll('#video-container video'));
    

    // Inisialisasi Connection
    connection.socketURL = 'https://webrtc.pnglobalinternational.com:9001/';
    connection.socketMessageEvent = 'ciak-liveshow';
    connection.extra.broadcastuser = 0;
    // Inisialisasi room opened even if owner leaves
    connection.autoCloseEntireSession = false;
    connection.maxParticipantsAllowed = 200;

    // Inisialisasi AUDIO, VIDEO, DATA RTCMultiConnection
    connection.session = {
        audio: true,
        video: true,
        data: true
    };
    connection.sdpConstraints.mandatory = {
        OfferToReceiveAudio: true,
        OfferToReceiveVideo: true
    };

    // dummy for testing
    for (let i = 0; i < 24; i++) {
        const video = document.createElement('video');
        video.autoplay = true;
        video.playsInline = true;
        video.muted = true;
        video.poster = 'https://via.placeholder.com/320x180?text=Video'; // Gambar diam
        video.style.borderRadius = '8px';

        const label = document.createElement('div');
        label.className = 'badge-overlay';
        label.textContent = `👤 Dummy ${i+1}`;

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.appendChild(video);
        wrapper.appendChild(label);

        // Simpan dan tambahkan langsung ke DOM
        videos.push({
            wrapper: wrapper,
            isPerformer: label?.textContent.includes('🎤')
        });
        document.getElementById('video-container').appendChild(wrapper);
    }

    // Tampilkan halaman pertama
    renderPage();

    /*----------------------------------------------------------
    7. Confirmation member before start streaming
    ------------------------------------------------------------*/
    $("#joinlive").on("click", function() {

        // $("#confirmjoin").modal("hide");
        connection.join(broadcastId, function(isRoomJoined, roomid, error) {
            if (error) {
                if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                    alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');
                    return;
                }
                if (error === connection.errors.ROOM_FULL) {
                    alert('Room is full.');
                    return;
                }
                alert(error);
            } else {
                connection.extra.broadcastuser += 1;
            }
            connection.updateExtraData();


            connection.socket.on('disconnect', function() {
                location.reload();
            });
        });
    })

    /*----------------------------------------------------------
    14. connection onstream berfungsi receive all local or remote media streaming
    ------------------------------------------------------------*/
    connection.onstream = function(event) {
        if (document.querySelector('[data-streamid="' + event.streamid + '"]')) return;

        const video = document.createElement('video');
        video.setAttribute('data-streamid', event.streamid);
        video.autoplay = true;
        video.playsInline = true;
        video.controls = false;
        video.srcObject = event.stream;

        if (event.type === 'local') {
            video.muted = true;
            video.volume = 0;
        }

        const label = document.createElement('div');
        label.className = 'badge-overlay';
        label.textContent = event.extra.roomOwner ? "🎤 Performer" : "👤 Member";

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.appendChild(video);
        wrapper.appendChild(label);

        videos.push({
            wrapper: wrapper,
            isPerformer: label.textContent.includes('🎤')
        });
        document.getElementById('video-container').appendChild(wrapper);
        renderPage();
    };

    connection.onmessage = function(event) {
        const data = event.data;
        displayMsg(data.from || "Friend", data.text);
    };





    /*----------------------------------------------------------
    15. Connection End
    ------------------------------------------------------------*/
    connection.onerror = function(event) {
        var remoteUserId = event.userid;
        if (event.extra.userJoin == "performer") {
            alert("broadcast ended or you've been kicked");
            window.location.href = "<?= base_url() ?>course/member/live";
        }
    };
    connection.onEntireSessionClosed = function(event) {
        console.log("");
    };


    /*----------------------------------------------------------
    15. Exit Room
    ------------------------------------------------------------*/

    $("#btnleave").on("click", function(e) {
        e.preventDefault();
        connection.getAllParticipants().forEach(function(participantId) {
            connection.disconnectWith(participantId);
        });
        connection.closeSocket();
        window.location.href = "<?= base_url() ?>course/member/live";
    })



    /*----------------------------------------------------------
    15. Render for pagination
    ------------------------------------------------------------*/
    function renderPage() {
        const container = document.getElementById('video-container');
        container.classList.remove('performer-mode', 'normal-mode');

        if (modePerformerOnly) {
            container.classList.add('performer-mode');

            videos.forEach(v => {
                v.wrapper.style.display = v.isPerformer ? 'block' : 'none';
            });

            document.getElementById('prevbtn').style.display = 'none';
            document.getElementById('nextbtn').style.display = 'none';

        } else {
            container.classList.add('normal-mode');

            const start = currentPage * pageSize;
            const end = start + pageSize;

            videos.forEach((v, i) => {
                v.wrapper.style.display = (i >= start && i < end) ? 'block' : 'none';
            });

            document.getElementById('prevbtn').style.display = 'inline-block';
            document.getElementById('nextbtn').style.display = 'inline-block';

            document.getElementById('prevbtn').disabled = currentPage === 0;
            document.getElementById('nextbtn').disabled = end >= videos.length;
        }
    }





    /*----------------------------------------------------------
    15. Previous screen
    ------------------------------------------------------------*/
    document.getElementById('prevbtn').onclick = () => {
        if (currentPage > 0) {
            currentPage--;
            renderPage();
        }
    };



    /*----------------------------------------------------------
    15. Next Screen
    ------------------------------------------------------------*/
    document.getElementById('nextbtn').onclick = () => {
        if ((currentPage + 1) * pageSize < videos.length) {
            currentPage++;
            renderPage();
        }
    }

    document.getElementById('modebtn').onclick = () => {
        modePerformerOnly = !modePerformerOnly;
        renderPage();
    };


    // record meeting
    function drawAllVideos() {
    const cols = 5;
    const rows = Math.ceil(videosx.length / cols);
    const videoWidth = canvas.width / cols;
    const videoHeight = canvas.height / rows;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    videosx.forEach((video, i) => {
        const x = (i % cols) * videoWidth;
        const y = Math.floor(i / cols) * videoHeight;
        try {
            ctx.drawImage(video, x, y, videoWidth, videoHeight);
        } catch (err) {
            // video belum siap — bisa diabaikan
        }
    });
}

function getMixedAudioStream() {
    const audioCtx = new AudioContext();
    const destination = audioCtx.createMediaStreamDestination();

    videosx.forEach(video => {
        const source = audioCtx.createMediaElementSource(video);
        source.connect(destination);
    });

    return destination.stream;
}

document.getElementById('startRecord').onclick = () => {
    const canvasStream = canvas.captureStream(30); // 30 FPS
    const audioStream = getMixedAudioStream();

    const finalStream = new MediaStream([
        ...canvasStream.getVideoTracks(),
        ...audioStream.getAudioTracks()
    ]);

    recorder = new RecordRTC(finalStream, {
        type: 'video'
    });

    drawInterval = setInterval(drawAllVideos, 1000 / 30);
    recorder.startRecording();

    document.getElementById('startRecord').disabled = true;
    document.getElementById('stopRecord').disabled = false;
};

document.getElementById('stopRecord').onclick = () => {
    clearInterval(drawInterval);
    recorder.stopRecording(() => {
        const blob = recorder.getBlob();
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'grid-recording.webm';
        a.click();
    });

    document.getElementById('startRecord').disabled = false;
    document.getElementById('stopRecord').disabled = true;
};

$("#sendmsg").on('click', function() {
    const msg = $("#message").val();
    const sender = $("#message").data("sender");

    if (msg && connection.getAllParticipants().length > 0) {
        connection.send({ from: sender, text: msg });
        displayMsg("You", msg);
        $("#message").val("");
    }
});

function displayMsg(name, msg) {
    const chatContainer = document.getElementById('livechat');
    const p = document.createElement('p');
    p.innerHTML = `<strong>${name}:</strong> ${msg}`;
    chatContainer.appendChild(p);

    // Scroll otomatis ke bawah
    chatContainer.scrollTop = chatContainer.scrollHeight;
}


</script>