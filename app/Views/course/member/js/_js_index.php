<script>
function displayCourses(courses) {
    // If no courses are available, show the "No course available" message
    if (courses.length === 0) {
        $('#noCourseText').text('No courses available');
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
            <div class="col-3 mb-4">
                <a class="text-white" href="<?= BASE_URL?>course/member/detail_course/${btoa(course.id)}">
                    <div class="card w-100" style="width: 18rem;background-color: transparent;">
                        <img src="<?= BASE_URL ?>assets/img/${course.banner}" class="card-img-top" alt="...">
                        <div class="card-body p-1">
                            <p class="card-text mb-1">${course.title}</p>
                              <div class="d-flex justify-content-between">
                                    <small>${course.email}</small>
                                    <i class="bi bi-check-square-fill" style="color: green;"></i>
                                </div>
                        </div>
                    </div>
                </a>
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
            displayCourses(response.message);
            
        } else {
            // Handle case when courses are not available
            $('#noCourseText').text('No courses available');
            $('#listcourse').hide();
            $('#noCourseText').show();
        }
    },
    error: function() {
        // Handle errors such as server issues
        $('#noCourseText').text('No courses available');
        $('#listcourse').hide();
        $('#noCourseText').show();
        console.error("Error fetching courses.");
    }
});
</script>