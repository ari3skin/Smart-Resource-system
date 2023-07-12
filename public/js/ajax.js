//ajax display/view content
//displaying all projects
function projectListing(element, user_id) {
    let callerId = element.id;  // get the ID of the calling element

    if (callerId === 'employers_projects') {

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


                $('#project-manager').append('<option value="0">--Leading Project Manager--</option>');
                $('#sub-project-manager').append('<option value="0">--Sub Project Manager--</option>');
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
    } else if (callerId === 'admin_projects') {

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
            },
            error: function (xhr, status, error) {
                console.log(error);
                displayErrorModal(error);
            }
        });
    }
}

//displaying all tasks
function taskListing(user_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/tasks/managers/' + user_id,
            type: 'GET',
            success: function (response) {
                resolve(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                reject(errorThrown);
            }
        });
    }).then(response => {

        let tableBody = $('#task_table');
        tableBody.empty();
        let projectTitles = [];

        $.each(response, function (i, task) {
            let row =
                "<tr style=\"border-bottom: solid var(--title-color) 1px\">"
                + "<td>" + task.project_title + "</td>"
                + "<td>" + task.task_title + "</td>"
                + "<td>" + task.task_description + "</td>"
                + "<td>" + task.assigned_to + "</td>"
                + "<td>" + task.task_type + "</td>"
                + "</tr>";
            tableBody.append(row);

            // Add the project title to our list if it's not already there
            if (!projectTitles.includes(task.project_title)) {
                projectTitles.push(task.project_title);
            }
        });

        // Populate the project filter dropdown with unique project titles
        let projectFilter = $('#projectFilter');
        projectFilter.empty();  // Remove any old options
        projectFilter.append('<option value="">All Projects</option>');
        $.each(projectTitles, function (i, title) {
            projectFilter.append('<option value="' + title + '">' + title + '</option>');
        });

        // Destroy any existing table instance before reinitializing
        if ($.fn.DataTable.isDataTable("#tableData")) {
            $('#tableData').DataTable().destroy();
        }

        // Initialize DataTables
        let dataTable = $('#tableData').DataTable(
            {
                "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                "iDisplayLength": 5
            }
        );

        // Update the table filter whenever a new option is selected
        projectFilter.on('change', function () {
            dataTable.columns(0).search(this.value).draw();
        });
    });
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
                let title = response.error.title;
                let message = response.error.info;
                displaySuccessModal(title, message)

                form.reset();
            } else {

                // console.error('Error:', xhr.status);
                let errorResponse = JSON.parse(xhr.responseText);
                let title = errorResponse.error.title;
                let message = errorResponse.error.info;
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
