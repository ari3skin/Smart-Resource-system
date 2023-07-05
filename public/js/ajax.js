//displaying all projects
function projectListing() {
    $.ajax({
        url: '/api/projects/',
        type: 'GET',
        success: function (response) {
            // Clear the container before appending new data
            $('#project-list').empty();
            // Populate the blade page with the received data
            response.forEach(function (item) {
                var projectId = item.id;
                var projectTitle = item.project_title;
                var projectDescription = item.project_description;
                var projectManagerId = item.project_manager;

                // Fetch the project manager's details from the appropriate table
                $.ajax({
                    url: '/api/projects/users',
                    type: 'GET',
                    data: {managerId: projectManagerId},
                    success: function (managerResponse) {
                        var firstName = managerResponse.first_name;
                        var lastName = managerResponse.last_name;

                        var listItem = `
                            <li>
                                <div>PID.${projectId}</div>
                                <div class="text">
                                    <h3>${projectTitle}</h3>
                                    <h4>Manager ${firstName} ${lastName}</h4>
                                    <p>${projectDescription}</p>
                                </div>
                            </li>`;

                        // Append the list item to the desired container
                        $('#project-list').append(listItem);
                    },
                    error: function (xhr, status, error) {
                        // Handle error case
                        console.log(error);
                        displayErrorModal(error);
                    }
                });
            });
        },
        error: function (xhr, status, error) {
            // Handle error case
            console.log(error);
            displayErrorModal(error);
        }
    });
}

function displayErrorModal(errorMessage) {
    var modal = `
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                    Access Denied.
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                </p>
                <p class="modal__text">${errorMessage}</p>
            </div>
        </div>
    `;

    // Display the error modal within the project-list container
    $('#project-list').html(modal);
}
