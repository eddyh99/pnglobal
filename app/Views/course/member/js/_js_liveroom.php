<script src="<?= BASE_URL ?>assets/js/admin/mandatory/RTCMultiConnection.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
<script>
    var connection = new RTCMultiConnection();
    var url = new URL(window.location.href);
    var broadcastId = url.searchParams.get("room_id");
    var performer = false;
    const videos = [];
    let currentPage = 0;
    const pageSize = 25;

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

    // dummy videos
    for (let i = 0; i < 24; i++) {
        const video = document.createElement('video');
        video.autoplay = true;
        video.playsInline = true;
        video.muted = true;
        video.srcObject = null; // dummy, tidak ada stream
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';
        video.style.borderRadius = '8px';
        video.style.backgroundColor = 'black';

        const badge = document.createElement('div');
        badge.className = 'badge-overlay';
        badge.textContent = '🎤 Dummy ' + (i + 1);

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.appendChild(video);
        wrapper.appendChild(badge);

        videos.push({
            wrapper,
            streamid: 'dummy-' + i
        });
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
        // Cegah duplikat stream
        if (document.querySelector('[data-streamid="' + event.streamid + '"]')) return;

        // Buat elemen video
        const video = document.createElement('video');
        video.setAttribute('data-streamid', event.streamid);
        video.autoplay = true;
        video.playsInline = true;
        video.controls = false;
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';
        video.style.borderRadius = '8px';

        if (event.type === 'local') {
            video.muted = true;
            video.volume = 0;
        }

        video.srcObject = event.stream;

        // Buat badge
        const badge = document.createElement('div');
        badge.className = 'badge-overlay';
        badge.textContent = event.extra.roomOwner ? '🎤 Performer' : '👤 Member';

        // Bungkus dalam div .video-wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.appendChild(video);
        wrapper.appendChild(badge);

        videos.push({
            wrapper,
            streamid: event.streamid
        });

        renderPage(); // Render ulang saat ada video baru
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

    $("#btnleave").on("click", function(e) {
        e.preventDefault();
        connection.getAllParticipants().forEach(function(participantId) {
            connection.disconnectWith(participantId);
        });
        connection.closeSocket();
        window.location.href = "<?= base_url() ?>course/member/live";
    })



    function renderPage() {
        const container = document.getElementById('video-container');
        container.innerHTML = ''; // Kosongkan dulu

        const start = currentPage * pageSize;
        const end = start + pageSize;
        const pageItems = videos.slice(start, end);

        pageItems.forEach(item => container.appendChild(item.wrapper));

        document.getElementById('prevbtn').disabled = currentPage === 0;
        document.getElementById('nextbtn').disabled = end >= videos.length;
    }

    document.getElementById('prevbtn').onclick = () => {
        if (currentPage > 0) {
            currentPage--;
            renderPage();
        }
    };

    document.getElementById('nextbtn').onclick = () => {
        if ((currentPage + 1) * pageSize < videos.length) {
            currentPage++;
            renderPage();
        }
    }
</script>