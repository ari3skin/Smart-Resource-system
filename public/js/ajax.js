//displaying all projects
function projectListing(user_id) {
    $.ajax({
        url: '/api/projects/' + user_id,
        type: 'GET',
        success: function (response) {
            $('#project-list').empty();
            response.forEach(function (item) {
                var projectId = item.id;
                var projectTitle = item.project_title;
                var projectDescription = item.project_description;
                var projectManagerId = item.project_manager;

                // Fetch user data based on projectManagerId
                $.ajax({
                    url: '/api/projects/user/' + projectManagerId,
                    type: 'GET',
                    success: function (userResponse) {
                        var employerId = userResponse.employer_id;
                        var empty = null;

                        // Fetch employer data based on employerId
                        $.ajax({
                            url: '/api/projects/employer/' + employerId,
                            type: 'GET',
                            success: function (employerResponse) {
                                var firstName = employerResponse.first_name;
                                var lastName = employerResponse.last_name;

                                var listItem = `
                                    <li>
                                        <div class="text">
                                            <h3>${projectTitle}<sub>PID.${projectId}</sub></h3>
                                            <h4>Manager ${firstName} ${lastName}</h4>
                                            <p>${projectDescription}</p>
                                        </div>
                                    </li>`;

                                $('#project-list').append(listItem);
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                                displayErrorModal(error);
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        displayErrorModal(error);
                    }
                });
            });
        },
        error: function (xhr, status, error) {
            console.log(error);
            displayErrorModal(error);
        }
    });
}


//error displays
function displayErrorModal(errorMessage) {
    var modal = `
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">
                    <img src="icons/denied-logo.svg" alt="access denied">
                    Access Denied.
                    <img src="icons/denied-logo.svg" alt="access denied">
                </p>
                <p class="modal__text">${errorMessage}</p>
            </div>
        </div>
    `;

    // Display the error modal within the project-list container
    $('#project-list').html(modal);
}
