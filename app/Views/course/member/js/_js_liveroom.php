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
        videos.push(wrapper);
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

        videos.push(wrapper);
        document.getElementById('video-container').appendChild(wrapper);
        renderPage();
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
        videos.forEach((wrapper, index) => {
            if (index >= currentPage * pageSize && index < (currentPage + 1) * pageSize) {
                wrapper.style.display = 'block';
            } else {
                wrapper.style.display = 'none';
            }
        });

        document.getElementById('prevbtn').disabled = currentPage === 0;
        document.getElementById('nextbtn').disabled = (currentPage + 1) * pageSize >= videos.length;
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