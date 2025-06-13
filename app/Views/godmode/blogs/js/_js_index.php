<script>
    function displayPosts(posts) {
        // If no courses are available, show the "No course available" message
        if (posts.length === 0) {
            $('#noPostsText').text('No posts available');
            $('#posts-content').hide(); // Hide the courses container
            $('#noPostsText').show(); // Show the "No course available" message
        } else {
            $('#posts-content').show(); // Show the courses container
            $('#noPostsText').hide(); // Hide the "No course available" message

            // Clear the list before adding new courses
            $('#posts-content').empty();
            console.log(posts);
            // Loop through the courses and add them to the list
            posts.forEach((post, idx) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(post.content, 'text/html');
                
                // Get the first image element, if it exists
                const firstImage = doc.querySelector('img');
                let imageSrc = 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg'; // fallback if no image found
                
                if (firstImage) {
                  imageSrc = firstImage.getAttribute('src'); // base64 or URL
                  firstImage.parentElement.remove(); // remove the <p><img></p>
                }
                
                // Get the remaining HTML content (e.g., <p>ini postingan yah guys</p>)
                const cleanedContent = doc.body.innerHTML.trim();
                
                // Now build your card using `imageSrc` and `cleanedContent`
                const postCard = `
                  <div class="course-wrapper">
                    <div class="course-number">${idx + 1}</div>
                    <div class="course-card">
                      <img src="${imageSrc}" alt="Posts Thumbnail" class="course-img" />
                      <div class="course-content">
                        <h5>${post.title}</h5>
                        <p class="text-secondary" style="font-size: 0.9rem;">
                          ${cleanedContent}...
                        </p>
                      </div>
                      <a href="<?=BASE_URL?>godmode/blogs/editblog/${post.id}" class="edit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="32"><path fill="#FFFFFF" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1 .8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>
                      </a>
                    </div>
                  </div>
                `;
                $('#posts-content').append(postCard);
            });
        }
    }

    $.ajax({
        url: "<?= BASE_URL ?>godmode/blogs/getall_posts", // URL to fetch courses data
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.code == 200) {
                // If the request is successful, display the courses
                displayPosts(response.message);

            } else {
                // Handle case when courses are not available
                $('#noPostsText').text('No Posts available');
                $('#posts-content').hide();
                $('#noPostsText').show();
            }
        },
        error: function() {
            // Handle errors such as server issues
            $('#noPostsText').text('No posts available');
            $('#posts-content').hide();
            $('#noPostsText').show();
            console.error("Error fetching posts.");
        }
    });
</script>