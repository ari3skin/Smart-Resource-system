let sys_id = document.getElementById('employers_tasks').dataset.sysId;
console.log(sys_id);
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
                let projectManager = $('#project-manager');
                let subProjectManager = $('#sub-project-manager');
                projectManager.empty();
                subProjectManager.empty();
                let projects = response.projects; // Retrieve projects data
                let managers = response.managers;

                projectManager.append('<option value="0">--Leading Project Manager--</option>');
                subProjectManager.append('<option value="0">--Sub Project Manager--</option>');

                projects.forEach(function (project) {
                    let projectId = project.id;
                    let projectTitle = project.project_title;
                    let projectDescription = project.project_description;

                    // Extract project manager's user record, employer record and department record from the response
                    let projectManagerFirstName = project.manager.employer.first_name;
                    let projectManagerLastName = project.manager.employer.last_name;
                    let departmentName = project.manager.employer.department.department_name;
                    let managerEmployerID = project.manager.id;

                    let listItem = `
                                        <li>
                                            <div class="text">
                                                <h3 style="margin: 0 10px;">${projectTitle}<sub>PID.${projectId}</sub></h3>
                                                <h4>Manager ${projectManagerFirstName} ${projectManagerLastName}</h4>
                                                <h5>Department: ${departmentName}</h5>
                                                <p style="margin: 10px 20px;">${projectDescription}</p>
                                            </div>
                                        </li>`;
                    $('#project-list').append(listItem);
                });

                managers.forEach(function (manager) {
                    let sub_managerID = manager.id;
                    let sub_managerFirstName = manager.employer.first_name;
                    let sub_managerLastName = manager.employer.last_name;

                    let subManagerOptions = `
                                                <option value="${sub_managerID}">
                                                    ${sub_managerFirstName} ${sub_managerLastName}
                                                </option>`;
                    let managerOptions = `
                                                <option value="${sub_managerID}">
                                                    ${sub_managerFirstName} ${sub_managerLastName}
                                                </option>`;

                    $('#project-manager').append(managerOptions);
                    $('#sub-project-manager').append(subManagerOptions);
                });
            },
            error: function (xhr, status, error) {
                // console.log(error);
                let title = "Project Error"
                displayErrorModal(title, error);
            }
        });
    } else if (callerId === 'admin_projects') {

        $.ajax({
            url: '/api/projects/' + user_id,
            type: 'GET',
            success: function (response) {
                $('#project-list').empty();
                let projects = response.projects; // Retrieve projects data

                projects.forEach(function (project) {
                    let projectId = project.id;
                    let projectTitle = project.project_title;
                    let projectDescription = project.project_description;

                    // Extract project manager's user record, employer record and department record from the response
                    let projectManagerFirstName = project.manager.first_name;
                    let projectManagerLastName = project.manager.last_name;
                    let departmentName = project.manager.employer.department.department_name;

                    let listItem = `
                                        <li>
                                            <div class="text">
                                                <h3 style="margin: 0 10px;">${projectTitle}<sub>PID.${projectId}</sub></h3>
                                                <h4>Manager ${projectManagerFirstName} ${projectManagerLastName}</h4>
                                                <h5>Department: ${departmentName}</h5>
                                                <p style="margin: 10px 20px;">${projectDescription}</p>
                                            </div>
                                        </li>`;

                    $('#project-list').append(listItem);
                });
            },
            error: function (xhr, status, error) {
                // console.log(error);
                let title = "Project Error"
                displayErrorModal(title, error);
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
            cache: false,
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

        $.each(response.tasks, function (i, task) {
            let row =
                "<tr style=\"border-bottom: solid var(--title-color) 1px\">"
                + "<td>" + task.project.project_title + "</td>"
                + "<td>" + task.task_title + "</td>"
                + "<td>" + task.task_description + "</td>"
                + "<td>" + (task.assigned_to.first_name + " " + task.assigned_to.last_name || 'Not Assigned') + "</td>"
                + "<td>" + task.type + "</td>"
                + "</tr>";
            tableBody.append(row);
            if (!projectTitles.includes(task.project.project_title)) {
                projectTitles.push(task.project.project_title);
            }
        });

        let projectFilter = $('#projectFilter');
        projectFilter.empty();
        projectFilter.append('<option value="">All Projects</option>');
        $.each(projectTitles, function (i, title) {
            projectFilter.append('<option value="' + title + '">' + title + '</option>');
        });

        if ($.fn.DataTable.isDataTable("#tableData")) {
            $('#tableData').DataTable().destroy();
        }

        let dataTable = $('#tableData').DataTable(
            {
                "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                "iDisplayLength": 5
            }
        );

        projectFilter.on('change', function () {
            dataTable.columns(0).search(this.value).draw();
        });

        taskForm(response);
    });
}

function taskForm(response) {
    let projectList = $('#project');
    let taskTeamManager = $('#task-team-manager');
    let taskManagerIndividual = $('#task-manager-individual');
    let taskEmployeeIndividual = $('#task-employee-individual');

    projectList.empty();
    taskTeamManager.empty();
    taskManagerIndividual.empty();
    taskEmployeeIndividual.empty();

    projectList.append('<option value=""> -- Select Project -- </option>');
    taskTeamManager.append('<option value="">Select Team Manager</option>');
    taskManagerIndividual.append('<option value="">Select Manager Individual</option>');
    taskEmployeeIndividual.append('<option value="">Select Employee Individual</option>');

    $.each(response.projects, function (i, project) {
        let projectOptions = "<option value='" + project.id + "'>" + project.project_title + "</option>";
        projectList.append(projectOptions);
    });

    let addedManagers = [];

    $.each(response.managers, function (type, managers) {
        let managerOptions = '';

        $.each(managers, function (i, manager) {
            if (!addedManagers.includes(manager.id)) {
                managerOptions += "<option value='" + manager.id + "'>"
                    + manager.employer.first_name + " " + manager.employer.last_name
                    + "</option>";

                addedManagers.push(manager.id);
            }
        });

        taskTeamManager.append(managerOptions);
        taskManagerIndividual.append(managerOptions);
    });

    $.each(response.employees, function (i, employee) {
        let employeeOptions = "<option value='" + employee.id + "'>"
            + employee.employee.first_name + " " + employee.employee.last_name
            + "</option>";
        taskEmployeeIndividual.append(employeeOptions);
    });
}

//displaying all teams
function teamListing(element, user_id) {

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
                let title = response.info.title;
                let message = response.info.description;
                displaySuccessModal(title, message)

                form.reset();
            } else if (xhr.status === 400) {

                let errorResponse = JSON.parse(xhr.responseText);
                let title = errorResponse.info.title;
                let message = errorResponse.info.description;
                displayErrorModal(title, message);
            }
        }
    };
    xhr.send(formData);
}

//3. creating a task
function createTask() {
    let form = document.getElementById('create-task-form');
    let formData = new FormData(form);

    // Make AJAX request
    let task_xhr = new XMLHttpRequest();
    task_xhr.open('POST', '/api/tasks/create', true);
    task_xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    task_xhr.onreadystatechange = function () {
        if (task_xhr.readyState === XMLHttpRequest.DONE) {
            if (task_xhr.status === 200) {

                let response = JSON.parse(task_xhr.responseText);
                let title = response.info.title;
                let message = response.info.description;
                displaySuccessModal(title, message)

                form.reset();

                // taskListing(sys_id);
                taskListing(sys_id)
                    .then(() => {
                        console.log('Task listing updated');
                    })
                    .catch(err => {
                        console.log('Error updating task listing: ', err);
                    });
            } else if (task_xhr.status === 500) {

                let errorResponse = JSON.parse(task_xhr.responseText);
                let title = errorResponse.info.title;
                let message = errorResponse.info.description;
                displayErrorModal(title, message);
            }
        }
    };
    task_xhr.send(formData);
}

//4.creating a team
function createTeam() {

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
    let mainContent = $('#main_content');
    mainContent.after(modal);

    let modalNotice = $('#modal_notice');
    // Transition effect to slide from top
    modalNotice.css('top', '-200px').animate({
        top: '0',
    }, 500);

    // Display the modal for 5 seconds, then fade out of this element over the course of 500 milliseconds (or 0.5 seconds)
    modalNotice.delay(2500).fadeOut(500, function () {
        $(this).remove();
    });

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

    let mainContent = $('#main_content');
    mainContent.after(modal);

    let modalNotice = $('#modal_notice');
    // Transition effect to slide from top
    modalNotice.css('top', '-200px').animate({
        top: '0',
    }, 500);

    // Display the modal for 5 seconds, then fade out of this element over the course of 500 milliseconds (or 0.5 seconds)
    modalNotice.delay(2500).fadeOut(500, function () {
        $(this).remove();
    });

    noticeModals()
}
