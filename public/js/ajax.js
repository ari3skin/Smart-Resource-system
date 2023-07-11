//ajax display/view content
//displaying all projects
function projectListing(user_id) {
    $.ajax({
        url: '/api/projects/' + user_id,
        type: 'GET',
        success: function (response) {
            $('#project-list').empty();
            $('#project-manager').empty();
            $('#sub-project-manager').empty();
            let projects = response.projects; // Retrieve projects data
            let managers = response.managers; // Retrieve managers data

            projects.forEach(function (project) {
                let projectId = project.id;
                let projectTitle = project.project_title;
                let projectDescription = project.project_description;
                let projectManagerId = project.project_manager;

                // Fetch user data based on projectManagerId
                $.ajax({
                    url: '/api/projects/user/' + projectManagerId,
                    type: 'GET',
                    success: function (userResponse) {
                        let employerId = userResponse.employer_id;

                        // Fetch employer data based on employerId
                        $.ajax({
                            url: '/api/projects/employer/' + employerId,
                            type: 'GET',
                            success: function (employerResponse) {
                                let firstName = employerResponse.first_name;
                                let lastName = employerResponse.last_name;

                                let listItem = `
                                    <li>
                                        <div class="text">
                                            <h3 style="margin: 0 10px;">${projectTitle}<sub>PID.${projectId}</sub></h3>
                                            <h4>Manager ${firstName} ${lastName}</h4>
                                            <p style="margin: 10px 20px;">${projectDescription}</p>
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


            $('#project-manager').append('<option>--Leading Project Manager--</option>');
            $('#sub-project-manager').append('<option>--Sub Project Manager--</option>');
            managers.forEach(function (manager) {
                let managerEmployerID = manager.employer_id;
                $.ajax({
                    url: '/api/projects/employer/' + managerEmployerID,
                    type: 'GET',
                    success: function (employerResponse) {
                        let firstName = employerResponse.first_name;
                        let lastName = employerResponse.last_name;
                        let managerOptions = `
                                    <option value="${managerEmployerID}">
                                        ${firstName} ${lastName}
                                    </option>`;
                        let subManagerOptions = `
                                    <option value="${managerEmployerID}">
                                        ${firstName} ${lastName}
                                    </option>`;
                        $('#project-manager').append(managerOptions);
                        $('#sub-project-manager').append(subManagerOptions);
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

function taskListing(user_id) {
}

// ----------------------------------------------------------------------------------------------------------------------//

//ajax create/post functions
//2. creating a project
function createProject() {
    let form = document.getElementById('create-project-form');
    let formData = new FormData(form);

    // Make AJAX request
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/projects/create', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                let response = JSON.parse(xhr.responseText);
                let title = response.message.title;
                let message = response.message.info;
                displaySuccessModal(title, message)

                form.reset();
            } else{

                // console.error('Error:', xhr.status);
                let errorResponse = JSON.parse(xhr.responseText);
                let title = errorResponse.message.title;
                let message = errorResponse.message.info;
                displayErrorModal(title, message);
            }
        }
    };
    xhr.send(formData);
}

//3. creating a task
function createTask() {
}

//modal displays
function displayErrorModal(title, message) {
    let modal = `
        <div id="modal_notice" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close notice_close">&times;</span>
                <p class="modal__text__error">
                    <img src="icons/denied-logo.svg" alt="access denied">
                    ${title}
                    <img src="icons/denied-logo.svg" alt="access denied">
                </p>
                <p class="modal__text">${message}</p>
            </div>
        </div>
    `;

    // Display the error modal within the project-list container
    let projectList = $('#project-list');
    if (projectList.length > 0) {
        projectList.html(modal);
    } else {
        // Fallback logic when #project-list element is not present
        let mainContent = $('#main_content');
        mainContent.html(modal);
    }
    noticeModals()
}

function displaySuccessModal(title, message) {
    let modal = `
        <div id="modal_notice" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close notice_close">&times;</span>
                <p class="modal__text__success">
                    <img src="icons/success-logo.svg" alt="sucess">
                    ${title}
                    <img src="icons/success-logo.svg" alt="sucess">
                </p>
                <p class="modal__text">${message}</p>
            </div>
        </div>
    `;

    // Display the error modal within the project-list container
    let projectList = $('#project-list');
    if (projectList.length > 0) {
        projectList.html(modal);
    } else {
        // Fallback logic when #project-list element is not present
        let mainContent = $('#main_content');
        mainContent.html(modal);
    }
    noticeModals()
}
