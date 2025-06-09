<script>
    $.ajax({
        url: "<?= BASE_URL ?>course/member/get_live", // URL to fetch courses data
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            let content = `<h2 class="text-uppercase">There are no live courses yet</h2>
    <button class="btn mt-3 py-2" style="background-color: #343434;">Join Live Course</button>`

            if (response.code == 200) {
                const data = response.message;
                content = `<h2 class="text-uppercase">${data.title}</h2>
    <span class="mb-5">BY ${data.mentor}</span>

    <h4>Start at: ${data.start_date}</h4>
    <button class="btn btn-primary mt-3 py-2" onclick="window.location.href='<?= BASE_URL ?>/course/member/joinlive?room_id=${data.roomid}'" ${data.remaining > 60 ? 'disabled' : ''}>Join Live Course</button>
    <small class="mt-1 text-white">This button will active 1 hour before live started</small>`
                $('#live').append(content);

            } else {
                $('#live').append(content);
            }
        },
        error: function() {
            // Handle errors such as server issues
            $('#live').append(content);
            console.error("Error fetching courses.");
        }
    });
</script>