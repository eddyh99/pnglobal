<script>
function displayCourses(courses) {
    // If no courses are available, show the "No course available" message
    if (courses.length === 0) {
        $('#listcourse').hide(); // Hide the courses container
        $('#noCourseText').show(); // Show the "No course available" message
    } else {
        $('#listcourse').show(); // Show the courses container
        $('#noCourseText').hide(); // Hide the "No course available" message

        // Clear the list before adding new courses
        $('#listcourse').empty();

        // Loop through the courses and add them to the list
        courses.forEach(course => {
            const courseCard = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="${course.image}" class="card-img-top" alt="${course.title}">
                        <div class="card-body">
                            <h5 class="card-title">${course.title}</h5>
                            <p class="card-text">${course.description}</p>
                        </div>
                    </div>
                </div>
            `;
            $('#listcourse').append(courseCard);
        });
    }
}

$.ajax({
    url: "<?= BASE_URL ?>course/member/getall_course", // URL to fetch courses data
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        if (response.code == 200) {
            // If the request is successful, display the courses
            displayCourses(response.courses);
        } else {
            // Handle case when courses are not available
            $('#listcourse').hide();
            $('#noCourseText').show();
        }
    },
    error: function() {
        // Handle errors such as server issues
        $('#listcourse').hide();
        $('#noCourseText').show();
        console.error("Error fetching courses.");
    }
});
</script>