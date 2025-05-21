<script>
    function displayCourses(courses) {
        // If no courses are available, show the "No course available" message
        if (courses.length === 0) {
            $('#noCourseText').text('No courses available');
            $('#course-content').hide(); // Hide the courses container
            $('#noCourseText').show(); // Show the "No course available" message
        } else {
            $('#course-content').show(); // Show the courses container
            $('#noCourseText').hide(); // Hide the "No course available" message

            // Clear the list before adding new courses
            $('#course-content').empty();

            // Loop through the courses and add them to the list
            courses.forEach((course, idx) => {
                const courseCard = `
                      <div class="course-wrapper">
                        <div class="course-number">${idx +1}</div>
                        <div class="course-card">
                        <img src="<?= BASE_URL . 'assets/img/' ?>${course.cover}" alt="Course Thumbnail" class="course-img" />
                        <div class="course-content">
                            <h5>${course.title}</h5>
                            <p class="text-secondary fw-bold">${course.name}</p>
                            <p class="text-secondary" style="font-size: 0.9rem;">
                                ${course.short_desc}...
                            </p>
                        </div>
                        <div class="edit-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="32"><path fill="#FFFFFF" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1 .8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/></svg>
                        </div>
                        </div>
                    </div>
            `;
                $('#course-content').append(courseCard);
            });
        }
    }

    $.ajax({
        url: "<?= BASE_URL ?>godmode/course/explore/getall_course", // URL to fetch courses data
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            if (response.code == 200) {
                // If the request is successful, display the courses
                displayCourses(response.message);

            } else {
                // Handle case when courses are not available
                $('#noCourseText').text('No courses available');
                $('#course-content').hide();
                $('#noCourseText').show();
            }
        },
        error: function() {
            // Handle errors such as server issues
            $('#noCourseText').text('No courses available');
            $('#course-content').hide();
            $('#noCourseText').show();
            console.error("Error fetching courses.");
        }
    });
</script>