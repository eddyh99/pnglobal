<script src="https://cdn.webrtc-experiment.com:443/FileBufferReader.js"></script>
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
    const endTime = new Date("<?= esc($end_time) ?>");

    // Inisialisasi Connection
    connection.socketURL = 'https://webrtc.pnglobalinternational.com:9001/';
    connection.socketMessageEvent = 'ciak-liveshow';
    connection.extra.broadcastuser = 0;
    // Inisialisasi room opened even if owner leaves
    connection.autoCloseEntireSession = false;
    connection.maxParticipantsAllowed = 200;
    connection.enableFileSharing = true;
    let micEnabled = true;

    // Inisialisasi AUDIO, VIDEO, DATA RTCMultiConnection
    connection.session = {
        audio: true,
        video: true,
        data: true
    };

    connection.iceServers = [{
        urls: ["stun:ss-turn2.xirsys.com"]
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

        }

        // Cek apakah audio aktif
        // const audioTrack = event.stream.getAudioTracks()[0];
        // const isMuted = !audioTrack || !audioTrack.enabled;

        const micIcon = event.extra.roomOwner ? "🎤" : "🔇";
        const roleLabel = event.extra.roomOwner ? "👤 Performer" : "👤 Member";

        // Label dengan mic icon
        const label = document.createElement('div');
        label.className = 'badge-overlay';
        // label.textContent = `${roleLabel} ${micIcon}`;
        const labelText = document.createElement('span');
        labelText.className = 'label-text';
        labelText.textContent = `${roleLabel} ${micIcon}`;
        label.appendChild(labelText);

        // Perbarui ikon mic jika status mute berubah
        event.stream.getAudioTracks().forEach(track => {
            track.onmute = () => {
                labelText.textContent = `${roleLabel} 🔇`;
            };
            track.onunmute = () => {
                labelText.textContent = `${roleLabel} 🎤`;
            };
        });

        if (!event.extra.roomOwner) {
            const kickLink = document.createElement('button');
            kickLink.textContent = "Kick";
            kickLink.className = "btn btn-sm btn-danger ms-2";
            kickLink.style.padding = "2px 6px";
            kickLink.style.fontSize = "12px";
            kickLink.addEventListener("click", function() {
                if (confirm(`Are you sure you want to kick this user?`)) {
                    kickUser(event.userid); // Kirim userid RTC ke fungsi
                }
            });

            label.appendChild(kickLink);
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'video-wrapper';
        wrapper.style.position = 'relative';
        wrapper.appendChild(video);
        wrapper.appendChild(label);
        wrapper.setAttribute('data-userid', event.userid);
        wrapper.setAttribute('data-role', event.extra.roomOwner ? 'mentor' : 'member');


        videos.push({
            wrapper: wrapper,
            isPerformer: label.textContent.includes('Performer')
        });
        document.getElementById('video-container').appendChild(wrapper);
        renderPage();
        checkDuration(endTime);
    };

    connection.onmessage = function(event) {
        const data = event.data;

        if (data.action === 'mute_me') {
            console.log('melakukan mute');
            return;

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

        } else if (data.action === 'raise_hand') {
            raiseHand(data.userid);
        } else if (data.text) {
            // Pesan teks
            displayMsg(data.from || "Friend", data.text);
        }
    };

    connection.onleave = function(event) {
        removeUserVideo(event.userid);
    };

    connection.onstreamended = function(event) {
        removeUserVideo(event.userid);
    };

    connection.onFileStart = function(file) {
        // Kosongkan agar tidak muncul preview file
        return false;
    };

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

        const targets = document.querySelectorAll('[data-role="member"]');
        targets.forEach(function(target) {
            const label = target.querySelector(".badge-overlay");
            if (label) {
                const original = label.textContent.replace(/🔇|🎙️/g, '').trim();
                label.textContent = `${original} 🔇`;
            }
        });


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

    function raiseHand(userid) {
        const wrapper = document.querySelector(`.video-wrapper[data-userid="${userid}"]`);
        if (!wrapper) return;

        const labelText = wrapper.querySelector('.label-text');
        if (!labelText) return;

        if (!labelText.textContent.includes('✋')) {
            labelText.textContent = '✋ ' + labelText.textContent;

            setTimeout(() => {
                labelText.textContent = labelText.textContent.replace('✋ ', '');
            }, 10000); // 10 detik
        }
    }

    function removeUserVideo(userid) {
        const wrapper = document.querySelector(`.video-wrapper[data-userid="${userid}"]`);
        if (wrapper) {
            wrapper.remove();
            renderPage();
        }
    }

    function kickUser(userid) {
        // Kirim perintah ke user untuk disconnect
        connection.send({
            action: 'kick_me',
            userid: userid
        }, userid); // Kirim hanya ke target
    }

    document.getElementById('sendfile').addEventListener('click', function() {
        const participants = connection.getAllParticipants();

        if (participants.length === 0) {
            return;
        }
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {

            connection.filesContainer = null;
            const fileURL = URL.createObjectURL(file);
            const link = document.createElement('a');
            link.href = fileURL;
            link.download = file.name;
            link.textContent = `📎 ${file.name} (sent)`;
            link.className = 'd-block mb-2 text-muted';
            document.getElementById('livechat').appendChild(link);


            connection.send(file);
            console.log('Mengirim file:', file.name);
            this.value = '';
        }
    });

    function checkDuration(endTime) {

        const interval = setInterval(() => {
            const now = new Date();
            const timeLeftMs = endTime - now;
            const timeLeftMin = Math.floor(timeLeftMs / 60000);
            const absMin = Math.abs(timeLeftMin);
            console.log(timeLeftMin);


            if (timeLeftMin >= 0 && timeLeftMin <= 10 && timeLeftMin % 5 === 0) {
                alert(`⏰ The live session will end in ${timeLeftMin} minute${timeLeftMin === 1 ? '' : 's'}`);
            } else if (timeLeftMin < 0 && Math.abs(timeLeftMin) <= 10 && Math.abs(timeLeftMin) % 5 === 0) {
                alert(`🔴 The live session ended ${Math.abs(timeLeftMin)} minute${Math.abs(timeLeftMin) === 1 ? '' : 's'} ago.`);
            }


            // stop ketika selesai
            if (timeLeftMs <= 0) {
                clearInterval(interval);
                alert("🔴 The live session has ended.");
            }
        }, 60000);
    }
</script>