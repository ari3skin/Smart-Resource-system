// let sys_id = document.getElementById('employers_tasks').dataset.sysId;
function projectListing(element, user_id) {
    let callerId = element.id;

    if (callerId === 'employers_projects') {

        $.ajax({

            url: '/api/projects/' + user_id,
            type: 'GET',
            success: function (response) {
                let projects = response.projects;
                let managers = response.managers;
                let projectList = $('#project-list');
                let projectManager = $('#project-manager');
                let subProjectManager = $('#sub-project-manager');
                let my_projects = $('#my_projects');
                projectList.empty();
                projectManager.empty();
                subProjectManager.empty();
                my_projects.empty();
                my_projects.append('<option value="0">--Select a project--</option>');
                projectManager.append('<option value="0">--Leading Project Manager--</option>');
                subProjectManager.append('<option value="0">--Sub Project Manager--</option>');

                if (projects.length === 0) {

                    let emptyContent = `
                    <div class="empty">
                        <h1>There is nothing here. Start by creating a project!</h1>
                    </div>
                    `;
                    projectList.css("grid-template-columns", "none");
                    projectList.append(emptyContent);

                } else {

                    projectList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    projects.forEach(function (project) {
                        let projectId = project.id;
                        let projectTitle = project.project_title;
                        let projectDescription = project.project_description;
                        let projectManagerFirstName = project.manager.employer.first_name;
                        let projectManagerLastName = project.manager.employer.last_name;
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
                        let projectOptions = `
                                                <option value="${projectId}">
                                                    ${projectTitle}
                                                </option>`;
                        $('#project-list').append(listItem);
                        my_projects.append(projectOptions);
                    });
                }

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
                let projects = response.projects;
                let projectList = $('#project-list');
                projectList.empty();

                if (projects.length === 0) {

                    let emptyContent = `
                    <div class="empty">
                        <h1>There is nothing here. You're all caught up with project approvals</h1>
                    </div>
                    `;
                    projectList.css("grid-template-columns", "none");
                    projectList.append(emptyContent);

                } else {

                    projectList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    projects.forEach(function (project) {
                        let projectId = project.id;
                        let projectTitle = project.project_title;
                        let projectDescription = project.project_description;
                        let projectManagerID = project.manager.employer.id;
                        let projectManagerFirstName = project.manager.employer.first_name;
                        let projectManagerLastName = project.manager.employer.last_name;
                        let departmentName = project.manager.employer.department.department_name;

                        let listItem = `
                                        <li>
                                            <div class="text">
                                                <h3 style="margin: 0 10px;">${projectTitle}<sub>PID.${projectId}</sub></h3>
                                                <h4>Manager ${projectManagerFirstName} ${projectManagerLastName}</h4>
                                                <h5>Department: ${departmentName}</h5>
                                                <p style="margin: 10px 20px;">${projectDescription}</p>
                                                <div>
                                                    <button class="form-submit" id="approve_project"
                                                            onclick="updateItem(this, ${projectId},${projectManagerID})">
                                                        Approve
                                                    </button>
                                                    <button class="form-submit" id="reject_project"
                                                            onclick="updateItem(this, ${projectId},${projectManagerID})">
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </li>`;
                        $('#project-list').append(listItem);
                    });
                }
                // taskListing(yourElement, userId);
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
function taskListing(element, user_id) {
    let callerId = element.id;
    let employer_tasks = document.getElementById("employers_projects");
    let userId = user_id;

    if (callerId === 'employers_tasks') {

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
            let tableData = $('#tableData');
            let projectTitles = [];
            tableBody.empty();

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
                tableData.DataTable().destroy();
            }

            let dataTable = tableData.DataTable(
                {
                    "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                    "iDisplayLength": 5,
                    "language": {
                        "emptyTable": "There is nothing here. Start by creating a task!"
                    }
                }
            );

            projectFilter.on('change', function () {
                dataTable.columns(0).search(this.value).draw();
            });

            taskForm(response);
            taskListing(employer_tasks, userId);
        });

    } else if (callerId === "employees_tasks") {

        return new Promise((resolve, reject) => {

            $.ajax({

                url: '/api/tasks/employees/' + user_id,
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
            let tableData = $('#tableData');
            let projectTitles = [];
            let projectFilter = $('#projectFilter');
            let teamTasks = response.teamTasksInfo;
            projectFilter.empty();
            tableBody.empty();

            $.each(response.tasks, function (projectTitle, tasks) {

                $.each(tasks, function (i, task) {
                    let name = task.first_name + " " + task.last_name;
                    let row = `
                        <tr style="border-bottom: solid var(--title-color) 1px">
                            <td>${projectTitle}</td>
                            <td>${task.task_title}</td>
                            <td>${task.task_description}</td>
                            <td>${name || 'Not Assigned'}</td>
                        </tr>`;

                    tableBody.append(row);
                });
                if (!projectTitles.includes(projectTitle)) {
                    projectTitles.push(projectTitle);
                }
            });

            teamTasks.forEach(function (teamTask) {
                let name = teamTask.task_list.team.team_name;
                let row = `
                        <tr style="border-bottom: solid var(--title-color) 1px">
                            <td>${teamTask.project.project_title}</td>
                            <td>${teamTask.task_title}</td>
                            <td>${teamTask.task_description}</td>
                            <td>Team ${name}</td>
                        </tr>`;

                tableBody.append(row);
            });

            projectFilter.append('<option value="">All Projects</option>');
            $.each(projectTitles, function (i, title) {
                projectFilter.append('<option value="' + title + '">' + title + '</option>');
            });

            if ($.fn.DataTable.isDataTable("#tableData")) {
                tableData.DataTable().destroy();
            }

            let dataTable = tableData.DataTable(
                {
                    "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                    "iDisplayLength": 5,
                    "language": {
                        "emptyTable": "There is nothing here. You are yet to be assigned a task!"
                    }
                }
            );

            projectFilter.on('change', function () {
                dataTable.columns(0).search(this.value).draw();
            });

            taskForm(response);
        });
    }
}

function taskForm(response) {
    let projectList = $('#project');
    let taskTeamManager = $('#task-team-manager');
    let taskManagerIndividual = $('#task-manager-individual');
    let taskEmployeeIndividual = $('#task-employee-individual');
    let my_tasks = $('#my_tasks');

    projectList.empty();
    taskTeamManager.empty();
    taskManagerIndividual.empty();
    taskEmployeeIndividual.empty();
    my_tasks.empty();

    projectList.append('<option value=""> -- Select Project -- </option>');
    taskTeamManager.append('<option value="">Select Team Manager of the above Project</option>');
    taskManagerIndividual.append('<option value="">Select Manager Individual of the above Project</option>');
    taskEmployeeIndividual.append('<option value="">Select Employee Individual</option>');
    my_tasks.append('<option value="">Select my assigned task</option>');

    $.each(response.projects, function (i, project) {
        let projectOptions = "<option value='" + project.id + "'>" + project.project_title + "</option>";
        projectList.append(projectOptions);
    });

    $.each(response.managers, function (type, manager) {
        let managerOptions = `
                    <option value=" ${manager.manager.id}">
                            ${manager.project_title} - Project Manager
                            ${manager.manager.employer.first_name} ${manager.manager.employer.last_name}
                    </option>`;

        if (!manager.sub_manager) {

            let subManagerOptions = `
                    <option value="">No Sub-Project Manager for ${manager.project_title}</option>`;
            taskTeamManager.append(managerOptions).append(subManagerOptions);
            taskManagerIndividual.append(managerOptions).append(subManagerOptions);

        } else {

            let subManagerOptions = `
                    <option value=" ${manager.sub_manager.id}">
                            ${manager.project_title} - Sub-Project Manager
                            ${manager.sub_manager.employer.first_name} ${manager.sub_manager.employer.last_name}
                    </option>`;
            taskTeamManager.append(managerOptions).append(subManagerOptions);
            taskManagerIndividual.append(managerOptions).append(subManagerOptions);
        }
    });

    $.each(response.task_info, function (i, task_info) {
        let my_tasks_options = `
                <option value="${task_info.id}">
                        ${task_info.type} - ${task_info.task_title}
                </option>`;
        my_tasks.append(my_tasks_options);
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
    let callerId = element.id;

    if (callerId === "employers_team") {

        $.ajax({

            url: '/api/teams/managers/' + user_id,
            type: 'GET',
            success: function (response) {

                let teamlList = $('#team-list');
                teamlList.empty();
                let teams = response.teams;

                if (teams.length === 0) {
                    let emptyContent = `
                    <div class="empty">
                        <h1>There is nothing here. Start by creating a team!</h1>
                    </div>
                    `;
                    teamlList.css("grid-template-columns", "none");
                    teamlList.append(emptyContent);

                } else {

                    teamlList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    teams.forEach(function (team) {
                        let teamName = team.team_name;
                        let teamLeaderFirstName = team.team_leader.employer.first_name;
                        let teamLeaderLastName = team.team_leader.employer.last_name;
                        let teamMembers = '';

                        for (let i = 1; i <= 5; i++) {
                            let member = team['member' + i];
                            if (member) {
                                let memberFirstName = member.employee.first_name;
                                let memberLastName = member.employee.last_name;
                                teamMembers += '<p>Member ' + i + ': ' + memberFirstName + ' ' + memberLastName + '</p>';
                            }
                        }

                        let listItem = `
                            <li>
                                <div class="text">
                                    <h3 style="margin: 0 10px;">${teamName}</h3>
                                    <h4 style="margin: 10px 47px;">Team Leader: ${teamLeaderFirstName} ${teamLeaderLastName}</h4>
                                    ${teamMembers}
                                </div>
                            </li>`;
                        $('#team-list').append(listItem);
                    });
                }
                teamForm(response);
            },
            error: function (xhr, status, error) {
                let title = "Team Error"
                displayErrorModal(title, error);
            }
        });
    } else if (callerId === "employees_teams") {

        $.ajax({

            url: '/api/teams/employees/' + user_id,
            type: 'GET',
            success: function (response) {

                let teams = response.teams;
                let teamlList = $('#team-list');
                teamlList.empty();

                if (teams.length === 0) {

                    let emptyContent = `
                    <div class="empty">
                        <h1>There is nothing here. You are yet to be added into a team!</h1>
                    </div>
                    `;
                    teamlList.css("grid-template-columns", "none");
                    teamlList.append(emptyContent);

                } else {

                    teamlList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    teams.forEach(function (team) {
                        let teamName = team.team_name;
                        let teamLeaderFirstName = team.team_leader.employer.first_name;
                        let teamLeaderLastName = team.team_leader.employer.last_name;
                        let teamMembers = '';

                        for (let i = 1; i <= 5; i++) {
                            let member = team['member' + i];
                            if (member) {
                                let memberFirstName = member.employee.first_name;
                                let memberLastName = member.employee.last_name;
                                teamMembers += '<p>Member ' + i + ': ' + memberFirstName + ' ' + memberLastName + '</p>';
                            }
                        }

                        let listItem = `
                            <li>
                                <div class="text">
                                    <h3 style="margin: 0 10px;">${teamName}</h3>
                                    <h4 style="margin: 10px 47px;">Team Leader: ${teamLeaderFirstName} ${teamLeaderLastName}</h4>
                                    ${teamMembers}
                                </div>
                            </li>`;
                        $('#team-list').append(listItem);
                    });
                }
            },
            error: function (xhr, status, error) {
                let title = "Team Error"
                displayErrorModal(title, error);
            }
        });

    } else if (callerId === 'admin_teams') {

        $.ajax({

            url: '/api/teams/managers/' + user_id,
            type: 'GET',
            success: function (response) {

                let teamlList = $('#team-list');
                let teams = response.teamInfo;
                teamlList.empty();

                if (teams.length === 0) {
                    let emptyContent = `
                    <div class="empty">
                        <h1>There is nothing here. You're all caught up with team approvals</h1>
                    </div>
                    `;
                    teamlList.css("grid-template-columns", "none");
                    teamlList.append(emptyContent);

                } else {

                    teamlList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    teams.forEach(function (team) {
                        let teamName = team.team_name;
                        let teamLeaderFirstName = team.team_leader.employer.first_name;
                        let teamLeaderLastName = team.team_leader.employer.last_name;
                        let teamID = team.id;
                        let teamLeaderId = team.team_leader.id;
                        let teamMembers = '';

                        for (let i = 1; i <= 5; i++) {
                            let member = team['member' + i];
                            if (member) {
                                let memberFirstName = member.employee.first_name;
                                let memberLastName = member.employee.last_name;
                                teamMembers += '<p>Member ' + i + ': ' + memberFirstName + ' ' + memberLastName + '</p>';
                            }
                        }

                        let listItem = `
                            <li>
                                <div class="text">
                                    <h3 style="margin: 0 10px;">${teamName}</h3>
                                    <h4 style="margin: 10px 47px;">Team Leader: ${teamLeaderFirstName} ${teamLeaderLastName}</h4>
                                    ${teamMembers}
                                    <div>
                                         <button class="form-submit" id="approve_team"
                                            onclick="updateItem(this, ${teamID},${teamLeaderId})">
                                                Approve
                                        </button>
                                        <button class="form-submit" id="reject_team"
                                            onclick="updateItem(this, ${teamID},${teamLeaderId})">
                                                Reject
                                        </button>
                                    </div>
                                </div>
                            </li>`;
                        $('#team-list').append(listItem);
                    });
                }
                teamForm(response);
            },
            error: function (xhr, status, error) {
                let title = "Team Error"
                displayErrorModal(title, error);
            }
        });
    }
}

//adding the items in the team creation form
function teamForm(response) {
    let managerFormItem = $('#team_leader');
    let employeeFormItem = $('.member');
    managerFormItem.empty();
    employeeFormItem.empty();

    let addedManagers = [];

    managerFormItem.append('<option value="">Select Team Manager</option>');
    employeeFormItem.append('<option value="">Select Employee</option>');
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
        managerFormItem.append(managerOptions);
    });

    $.each(response.employees, function (i, employee) {
        let employeeOptions = "<option value='" + employee.id + "'>"
            + employee.employee.first_name + " " + employee.employee.last_name
            + "</option>";
        employeeFormItem.append(employeeOptions);
    });
}

function reportListing(element, user_id) {
    let callerId = element.id;

    if (callerId === 'employer_reports') {

        $.ajax({
            url: '/api/reports/managers/' + user_id,
            type: 'GET',
            success: function (response) {
                let reports = response.reports;
                let reportList = $('#report-list');
                reportList.empty();

                if (reports.length === 0) {
                    let emptyContent = `
                                    <div class="empty">
                                        <h1>You are yet to create any report type</h1>
                                    </div>`;
                    reportList.css("grid-template-columns", "none");
                    reportList.append(emptyContent);
                } else {
                    reportList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    reports.forEach(function (report) {
                        let reportId = report.report.id;
                        let reportTitle = report.report.report_title;
                        let reportSummary = report.report.report_summary;
                        let reportSubmitterFirstName = report.report.submitter.employer.first_name;
                        let reportSubmitterLastName = report.report.submitter.employer.last_name;
                        let reportProject = report.report.project ? report.report.project.project_title : null;
                        let reportTask = report.report.task ? report.report.task.task_title : null;
                        let reportFile = report.file_url;


                        let listItem = `
                                <li>
                                    <div class="text">
                                        <h3 style="margin: 0 10px;">${reportTitle}<sub>PID.${reportId}</sub></h3>
                                        <h4>User ${reportSubmitterFirstName} ${reportSubmitterLastName}</h4>
                                        ${reportProject ? `<h5>Project: ${reportProject}</h5>` : ''}
                                        ${reportTask ? `<h5>Task: ${reportTask}</h5>` : ''}
                                        <p style="margin: 10px 20px;">${reportSummary}</p>
                                        ${reportFile ? `
                                        <a href="${reportFile}" class="form-submit" download id="download_project">Download Report</a>` : ''}
                                    </div>
                                </li>`;

                        reportList.append(listItem);
                    });
                }
            }
        });

    } else if (callerId === "employee_reports") {

        $.ajax({
            url: '/api/reports/employees/' + user_id,
            type: 'GET',
            success: function (response) {
                let reports = response.reports;
                let reportList = $('#report-list');
                reportList.empty();

                if (reports.length === 0) {
                    let emptyContent = `
                                    <div class="empty">
                                        <h1>You are yet to create any report type</h1>
                                    </div>`;
                    reportList.css("grid-template-columns", "none");
                    reportList.append(emptyContent);
                } else {
                    reportList.css("grid-template-columns", "repeat(3, minmax(240px, 1fr))");
                    reports.forEach(function (report) {
                        let reportId = report.report.id;
                        let reportTitle = report.report.report_title;
                        let reportSummary = report.report.report_summary;
                        let reportSubmitterFirstName, reportSubmitterLastName;
                        if (report.report.submitter) {
                            if (report.report.submitter.employer) {
                                reportSubmitterFirstName = report.report.submitter.employer.first_name;
                                reportSubmitterLastName = report.report.submitter.employer.last_name;
                            } else if (report.report.submitter.employee) {
                                reportSubmitterFirstName = report.report.submitter.employee.first_name;
                                reportSubmitterLastName = report.report.submitter.employee.last_name;
                            }
                        }
                        let reportProject = report.report.project ? report.report.project.project_title : null;
                        let reportTask = report.report.task ? report.report.task.task_title : null;
                        let reportFile = report.file_url;


                        let listItem = `
                                <li>
                                    <div class="text">
                                        <h3 style="margin: 0 10px;">${reportTitle}<sub>PID.${reportId}</sub></h3>
                                        <h4>User ${reportSubmitterFirstName} ${reportSubmitterLastName}</h4>
                                        ${reportProject ? `<h5>Project: ${reportProject}</h5>` : ''}
                                        ${reportTask ? `<h5>Task: ${reportTask}</h5>` : ''}
                                        <p style="margin: 10px 20px;">${reportSummary}</p>
                                        ${reportFile ? `
                                        <a href="${reportFile}" class="form-submit" download id="download_project">Download Report</a>` : ''}
                                    </div>
                                </li>`;

                        reportList.append(listItem);
                    });
                }
            }
        });
    }
}

// ----------------------------------------------------------------------------------------------------------------------//

//ajax create/post functions
//2. creation of content from forms
function createItem(element) {
    let callerId = element.id;

    if (callerId === "create_project") {
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
                    hideForm();
                } else if (xhr.status === 400) {

                    let errorResponse = JSON.parse(xhr.responseText);
                    let title = errorResponse.info.title;
                    let message = errorResponse.info.description;
                    displayErrorModal(title, message);
                }
            }
        };
        xhr.send(formData);
    } else if (callerId === "create_task") {

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
                    hideForm();
                    setTimeout(function () {
                        window.location.href = 'http://127.0.0.1:8000/admin';
                    }, 3000);
                } else if (task_xhr.status === 400) {

                    let errorResponse = JSON.parse(task_xhr.responseText);
                    let title = errorResponse.info.title;
                    let message = errorResponse.info.description;
                    displayErrorModal(title, message);
                }
            }
        };
        task_xhr.send(formData);
    } else if (callerId === "create_team") {

        let form = document.getElementById('create-team-form');
        let formData = new FormData(form);

        // Make AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/teams/create', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    let response = JSON.parse(xhr.responseText);
                    let title = response.info.title;
                    let message = response.info.description;
                    displaySuccessModal(title, message)

                    form.reset();
                    hideForm();
                } else if (xhr.status === 400) {

                    let errorResponse = JSON.parse(xhr.responseText);
                    let title = errorResponse.info.title;
                    let message = errorResponse.info.description;
                    displayErrorModal(title, message);
                }
            }
        };
        xhr.send(formData);
    } else if (callerId === "create_project_report") {

        let form = document.getElementById('create-project-report-form');
        let formData = new FormData(form);

        // Make AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/reports/create', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    let response = JSON.parse(xhr.responseText);
                    let title = response.info.title;
                    let message = response.info.description;
                    displaySuccessModal(title, message)

                    form.reset();
                    hideForm();
                } else if (xhr.status === 400) {

                    let errorResponse = JSON.parse(xhr.responseText);
                    let title = errorResponse.info.title;
                    let message = errorResponse.info.description;
                    displayErrorModal(title, message);
                }
            }
        };
        xhr.send(formData);
    } else if (callerId === "create_task_report") {

        let form = document.getElementById('create-task-report-form');
        let formData = new FormData(form);

        // Make AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/reports/create', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    let response = JSON.parse(xhr.responseText);
                    let title = response.info.title;
                    let message = response.info.description;
                    displaySuccessModal(title, message)

                    form.reset();
                    hideForm();
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
}

//update of items from fellow ajax requests
function updateItem(element, item_id, user_id) {
    let callerId = element.id;

    if (callerId === "approve_project") {

        $.ajax({
            url: '/api/projects/status',
            type: 'POST',
            data: {
                id: item_id,
                action: 'approve_project',
                project_manager: user_id,
            },
            success: function (data) {
                let title = data.info.title;
                let message = data.info.description;

                // Check the title of the response
                if (title === 'Success') {
                    // Handle a success scenario
                    displayNoticeModal(title, message);
                } else if (title === 'Warning') {
                    // Handle an error scenario
                    displayErrorModal(title, message);
                }
            },
            error: function (jqXHR) {

                let errorData = JSON.parse(jqXHR.responseText);
                console.log(errorData);
                let title = 'HTTP Error: ' + jqXHR.status;
                let message = errorData.message;
                displayErrorModal(title, message);
            }
        });

    } else if (callerId === "reject_project") {

        $.ajax({
            url: '/api/projects/status',
            type: 'POST',
            data: {
                id: item_id,
                action: 'reject_project',
                project_manager: user_id,
            },
            success: function (data) {
                let title = data.info.title;
                let message = data.info.description;

                // Check the title of the response
                if (title === 'Success') {
                    // Handle a success scenario
                    displayNoticeModal(title, message);
                } else if (title === 'Warning') {
                    // Handle an error scenario
                    displayErrorModal(title, message);
                }
            },
            error: function (jqXHR) {

                let errorData = JSON.parse(jqXHR.responseText);
                console.log(errorData);
                let title = 'HTTP Error: ' + jqXHR.status;
                let message = errorData.message;
                displayErrorModal(title, message);
            }
        });

    } else if (callerId === "approve_task") {
    } else if (callerId === "approve_team") {

        $.ajax({
            url: '/api/teams/status',
            type: 'POST',
            data: {
                id: item_id,
                action: 'approve_team',
                team_leader: user_id,
            },
            success: function (data) {
                let title = data.title;
                let message = data.description;

                // Check the title of the response
                if (title === 'Success') {
                    // Handle a success scenario
                    displayNoticeModal(title, message);
                } else if (title === 'Warning') {
                    // Handle an error scenario
                    displayErrorModal(title, message);
                }
            },
            error: function (jqXHR) {

                let errorData = JSON.parse(jqXHR.responseText);
                console.log(errorData);
                let title = 'HTTP Error: ' + jqXHR.status;
                let message = errorData.message;
                displayErrorModal(title, message);
            }
        });

    } else if (callerId === "reject_team") {

        $.ajax({
            url: '/api/teams/status',
            type: 'POST',
            data: {
                id: item_id,
                action: 'reject_team',
                team_leader: user_id,
            },
            success: function (data) {
                let title = data.title;
                let message = data.description;

                // Check the title of the response
                if (title === 'Success') {
                    // Handle a success scenario
                    displayNoticeModal(title, message);
                } else if (title === 'Warning') {
                    // Handle an error scenario
                    displayErrorModal(title, message);
                }
            },
            error: function (jqXHR) {

                let errorData = JSON.parse(jqXHR.responseText);
                console.log(errorData);
                let title = 'HTTP Error: ' + jqXHR.status;
                let message = errorData.message;
                displayErrorModal(title, message);
            }
        });

    }
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
    // Transition effect to slide from the top
    modalNotice.css('top', '-200px').animate({
        top: '0',
    }, 500);

    // Display the modal for 2.5 seconds, then fade out of this element over the course of 500 milliseconds (or 0.5 seconds)
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
    // Transition effect to slide from the top
    modalNotice.css('top', '-200px').animate({
        top: '0',
    }, 500);

    // Display the modal for 2.5 seconds, then fade out of this element over the course of 500 milliseconds (or 0.5 seconds)
    modalNotice.delay(2500).fadeOut(500, function () {
        $(this).remove();
    });

    noticeModals()
}

function displayNoticeModal(title, message) {
    let modal = `
        <div id="modal_notice" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close notice_close">&times;</span>
                <p class="modal__text__notice">
                    <img src="icons/notice-logo.svg" alt="sucess">
                    ${title}
                    <img src="icons/notice-logo.svg" alt="sucess">
                </p>
                <p class="modal__text">${message}</p>
            </div>
        </div>
    `;

    let mainContent = $('#main_content');
    mainContent.after(modal);

    let modalNotice = $('#modal_notice');
    // Transition effect to slide from the top
    modalNotice.css('top', '-200px').animate({
        top: '0',
    }, 500);

    // Display the modal for 2.5 seconds, then fade out of this element over the course of 500 milliseconds (or 0.5 seconds)
    modalNotice.delay(2500).fadeOut(500, function () {
        $(this).remove();
    });

    noticeModals()
}

function hideForm() {
    let newProject_modal_content = document.getElementById("new_project_modal");
    let newTask_modal_content = document.getElementById("new_task_modal");
    let newTeam_modal_content = document.getElementById("new_team_modal");
    let newProjectReport_modal_content = document.getElementById("new_project_report_modal");
    let newTaskReport_modal_content = document.getElementById("new_task_report_modal");

    newProject_modal_content.style.display = "none";
    newTask_modal_content.style.display = "none";
    newTeam_modal_content.style.display = "none";

    if (newProjectReport_modal_content) {
        newProjectReport_modal_content.style.display = "none";
    }

    newTaskReport_modal_content.style.display = "none";
}
