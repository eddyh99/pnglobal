<script src="<?= BASE_URL ?>assets/js/admin/mandatory/RTCMultiConnection.js"></script>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>

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
    let micEnabled = false;


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

    connection.iceServers= [
    {
        urls: [ "stun:ss-turn2.xirsys.com" ]
    }, {
        username: "9T_lKSp8c-na_my7tOf58N-Owq3KBK3s1BrEX2aYSS_AvrBdUOK6YnOvlHfgo8IBAAAAAGIzscxtM3JjNG43Mw==",
        credential: "09335c34-a63f-11ec-b20c-0242ac140004",
        urls: [
            "turn:ss-turn2.xirsys.com:80?transport=udp",
            "turn:ss-turn2.xirsys.com:3478?transport=udp",
            "turn:ss-turn2.xirsys.com:80?transport=tcp",
            "turn:ss-turn2.xirsys.com:3478?transport=tcp",
            "turns:ss-turn2.xirsys.com:443?transport=tcp",
            "turns:ss-turn2.xirsys.com:5349?transport=tcp"
            ]
    }];
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
            isPerformer: label?.textContent.includes('Performer')
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
                $("#joinlive").attr("disabled", "true");
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
        // const audioTrack = event.stream.getAudioTracks()[0];
        // const isMuted = !audioTrack || !audioTrack.enabled;

        const micIcon = event.extra.roomOwner ? "🎤" : "🔇";
        const roleLabel = event.extra.roomOwner ? "👤 Performer" : "👤 Member";

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
                label.textContent = `${roleLabel} 🎤`;
            };
        });

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.style.position = 'relative';
        wrapper.appendChild(video);
        wrapper.appendChild(label);
        wrapper.setAttribute('data-userid', event.userid);


        videos.push({
            wrapper: wrapper,
            isPerformer: label.textContent.includes('Performer')
        });
        document.getElementById('video-container').appendChild(wrapper);
        renderPage();
    };

    connection.onleave = function(event) {
        removeUserVideo(event.userid);
    };

    connection.onstreamended = function(event) {
        removeUserVideo(event.userid);
    };

    connection.onmessage = function(event) {
        const data = event.data;

        if (data.action === 'mute_me') {
            console.log('melakukan mute');

            const eventObj = connection.streamEvents.selectFirst();
            if (eventObj && eventObj.stream) {
                const stream = eventObj.stream;
                stream.mute('audio');

                // Paksa trigger onmute untuk update label mic lokal
                stream.getAudioTracks().forEach(track => {
                    if (typeof track.onmute === 'function') {
                        track.onmute();
                    }
                });
            }

        } else if (data.action === 'mic_status') {
            // Update label mic dari user lain berdasarkan userId
            const target = document.querySelector(`[data-userid="${data.userid}"]`);
            if (target) {
                const label = target.querySelector(".badge-overlay");
                if (label) {
                    const original = label.textContent.replace(/🔇|🎙️/g, '').trim();
                    label.textContent = `${original} ${data.muted ? '🔇' : '🎙️'}`;
                }
            }

        } else if (data.action === 'kick_me' && connection.userid === data.userid) {
            alert("You have been removed from the room.");
            connection.close();
            window.location.href = "<?= base_url() ?>course/member/live";
            return;
        } else if (data.text) {
            // Pesan teks
            displayMsg(data.from || "Friend", data.text);
        }
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
            connection.send({
                from: sender,
                text: msg
            });
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


    document.getElementById("mic").addEventListener("click", function() {
        const eventObj = connection.streamEvents.selectFirst();
        if (!eventObj || !eventObj.stream) return;

        const stream = eventObj.stream;

        if (micEnabled) {
            stream.mute('audio');
            this.textContent = "ON MIC";
        } else {
            stream.unmute('audio');
            this.textContent = "OFF MIC";
        }

        micEnabled = !micEnabled;

        // Kirim status ke semua peserta
        connection.getAllParticipants().forEach(pid => {
            connection.send({
                action: 'mic_status',
                userid: connection.userid,
                muted: !micEnabled
            }, pid);
        });

        // Update ikon mic lokal (paksa trigger)
        stream.getAudioTracks().forEach(track => {
            if (micEnabled && typeof track.onunmute === 'function') {
                track.onunmute();
            } else if (!micEnabled && typeof track.onmute === 'function') {
                track.onmute();
            }
        });
    });


    function removeUserVideo(userid) {
        const wrapper = document.querySelector(`.video-wrapper[data-userid="${userid}"]`);
        if (wrapper) {
            wrapper.remove();
            renderPage();
        }
    }

</script>