<script src="https://muazkhan.com:9001/dist/RTCMultiConnection.js"></script>
<script src="https://muazkhan.com:9001/node_modules/webrtc-adapter/out/adapter.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
<script>
    var connection = new RTCMultiConnection();
    var url = new URL(window.location.href);
    var broadcastId = url.searchParams.get("room_id");
    var performer = false;

    // Inisialisasi Connection
    connection.socketURL = 'https://muazkhan.com:9001/';
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
    5. Confirmation open member join
    ------------------------------------------------------------*/
    $(document).ready(function() {
        if (!performer) {
            $('#confirmjoin').modal('show');
        }
    });

    $("#btnopen").on("click", function() {
        $("#txt-chat-message").removeAttr("disabled");
        $("#btn-chat-message").removeAttr("disabled");
        $("#btn-emoji-livestream").removeAttr("disabled");
        if (!performer) {
            // Masuk sebagai member 
            $("#confirmjoin").modal("show");
        } else if (performer) {
            // Masuk sebagai Performer
            if ((meeting_type == "free") && (purpose == "public")) {
                $('#livemodal-connect').modal('show');
            } else {
                connection.open(broadcastId, function(isRoomOpened, roomid, error) {
                    if (error) {
                        if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                            alert('Someone already created this room. Please either join or create a separate room.');
                            return;
                        }
                        alert(error);
                    } else {
                        connection.extra.userJoin = "performer";
                        $("#allviewer").show();
                        $("#btnopen").attr("disabled", "true");
                        $('.please-click-join-live').hide();
                    }

                    connection.socket.on('disconnect', function() {
                        location.reload();
                    });
                });
            }
        }
    });


    /*----------------------------------------------------------
    6. Confirmation start live performer type FREE Public & enable social media connect streaming
    ------------------------------------------------------------*/
    $("#startlive").on("click", function() {
        if ($("#pil_yt").is(":checked")) {
            rtmpurl = $("#youtube").val();
            // rtmpurl.push($("#youtube").val());
        }
        if ($("#pil_fb").is(":checked")) {
            rtmpurl = $("#facebook").val();
            // rtmpurl.push($("#facebook").val());
        }
        if ($("#pil_ot1").is(":checked")) {
            rtmpurl = $("#others1").val();
        }

        $("#livemodal-connect").modal("hide");

        connect_server();
        connection.extra.userJoin = "performer";
        connection.open(broadcastId, function(isRoomOpened, roomid, error) {
            if (error) {
                if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                    alert('Someone already created this room. Please either join or create a separate room.');
                    return;
                }
                alert(error);
            } else {
                $("#allviewer").show();
                $("#btnopen").attr("disabled", "true");
                $('.please-click-join-live').hide();
            }

            connection.socket.on('disconnect', function() {
                location.reload();
            });
        });
    });


    /*----------------------------------------------------------
    7. Confirmation member before start streaming
    ------------------------------------------------------------*/
    $("#btnconfirm").on("click", function() {
        $("#confirmjoin").modal("hide");
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
                countPayperminutes = 0;

                $("#btnopen").attr("disabled", "true");
                $("#txt-chat-message").removeAttr("disabled");
                $("#btn-chat-message").removeAttr("disabled");

                $("#btn-emoji-livestream").removeAttr("disabled");
                $('.please-click-join-live').hide();
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
        if (event.extra.roomOwner === true) {
            event.mediaElement.controls = false;
            var video = document.getElementById('main-video');
            video.setAttribute('data-streamid', event.streamid);

            // video.style.display = 'none';
            if (event.type === 'local') {
                video.muted = true;
                video.volume = 0;
            }
            video.srcObject = event.stream;
            requestMedia(event.stream);
            $('#main-video').show();
        }
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
</script>