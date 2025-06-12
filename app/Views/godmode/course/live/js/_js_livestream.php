<script src="<?= BASE_URL ?>assets/js/admin/mandatory/RTCMultiConnection.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
<script>
    var connection = new RTCMultiConnection();
    var url = new URL(window.location.href);
    var broadcastId = url.searchParams.get("room_id");
    var performer = true;
    const videos = [];
    let currentPage = 0;
    const pageSize = 25;
    let modePerformerOnly = false;
    connection.extra.roomOwner = true;

    // Inisialisasi Connection
    connection.socketURL = 'https://webrtc.pnglobalinternational.com:9001/';
    connection.socketMessageEvent = 'ciak-liveshow';
    connection.extra.broadcastuser = 0;
    // Inisialisasi room opened even if owner leaves
    connection.autoCloseEntireSession = false;
    connection.maxParticipantsAllowed = 1000;

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


    /*----------------------------------------------------------
    6. Confirmation start live performer type FREE Public & enable social media connect streaming
    ------------------------------------------------------------*/
    $("#startlive").on("click", function() {

        connection.extra.userJoin = "performer";
        connection.open(broadcastId, function(isRoomOpened, roomid, error) {
            if (error) {
                if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                    alert('Someone already created this room. Please either join or create a separate room.');
                    return;
                }
                alert(error);
            } else {
                $("#startlive").attr("disabled", "true");
            }

            connection.socket.on('disconnect', function() {
                location.reload();
            });
        });
    });


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
            const stream = event.stream;
            stream.mute('audio');

            // Paksa update label mic 🔇
            stream.getAudioTracks().forEach(track => {
                if (typeof track.onmute === 'function') {
                    track.onmute();
                }
            });
        }

        // Cek apakah audio aktif
        const audioTrack = event.stream.getAudioTracks()[0];
        const isMuted = !audioTrack || !audioTrack.enabled;

        const micIcon = isMuted ? "🔇" : "🎙️";
        const roleLabel = event.extra.roomOwner ? "🎤 Performer" : "👤 Member";

        // Label dengan mic icon
        const label = document.createElement('div');
        label.className = 'badge-overlay';
        label.textContent = `${roleLabel} ${micIcon}`;

        // Perbarui ikon mic jika status mute berubah
        event.stream.getAudioTracks().forEach(track => {
            track.onmute = () => {
                label.textContent = `${roleLabel} 🔇`;
            };
            track.onunmute = () => {
                label.textContent = `${roleLabel} 🎙️`;
            };
        });

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.style.position = 'relative';
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
        if (event.data.action === 'mute_me') {
            return;
        } else {
            displayMsg(data.from || "Friend", data.text);
        }
    };;

    /*----------------------------------------------------------
    15. Connection End
    ------------------------------------------------------------*/
    connection.onerror = function(event) {
        var remoteUserId = event.userid;
        if (event.extra.userJoin == "performer") {
            alert("broadcast ended or you've been kicked");
            window.location.href = "<?= base_url() ?>homepage";
        }
    };
    connection.onEntireSessionClosed = function(event) {
        console.log("");
    };

    $("#btnleave").on("click", function(e) {
        e.preventDefault();
        connection.getAllParticipants().forEach(function(participantId) {
            connection.disconnectWith(participantId);
        });
        connection.closeSocket();
        window.location.href = "<?= base_url() ?>homepage";
    })

    function displayMsg(name, msg) {
        const chatContainer = document.getElementById('livechat');
        const p = document.createElement('p');
        p.innerHTML = `<strong>${name}:</strong> ${msg}`;
        chatContainer.appendChild(p);

        // Scroll otomatis ke bawah
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    $("#sendmsg").on('click', function() {
        const msg = $("#message").val();
        const sender = $("#message").data("sender");

        if (msg && connection.getAllParticipants().length > 0) {
            connection.send({
                from: sender,
                text: msg
            });
            displayMsg("You", msg);
            $("#message").val("");
        }
    });

    document.getElementById('muteall').addEventListener('click', function() {
        console.log('mute all');

        connection.send({
            action: 'mute_me'
        }); // Broadcast ke semua user
    });



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
</script>