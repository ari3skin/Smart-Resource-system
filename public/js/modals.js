//dynamic variables for modal types
let newProject_modal_content = document.getElementById("new_project_modal");
let newTask_modal_content = document.getElementById("new_task_modal");
let newTeam_modal_content = document.getElementById("new_team_modal");
let newProjectReport_modal_content = document.getElementById("new_project_report_modal");
let newTaskReport_modal_content = document.getElementById("new_task_report_modal");

//the closes
let projectModal_close = document.getElementsByClassName("project_close")[0];
let taskModal_close = document.getElementsByClassName("task_close")[0];
let teamModal_close = document.getElementsByClassName("team_close")[0];
let projectReportModal_close = document.getElementsByClassName("project_report_close")[0];
let taskReportModal_close = document.getElementsByClassName("task_report_close")[0];

function selectedInterface(element) {

    let callerId = element.id;  // get the ID of the calling element

    if (callerId === 'new_project') {
        newProject_modal_content.style.display = "block";

        projectModal_close.onclick = function () {
            newProject_modal_content.style.display = "none";
        }
    } else if (callerId === "new_task") {
        newTask_modal_content.style.display = "block";

        taskModal_close.onclick = function () {
            newTask_modal_content.style.display = "none";
        }
    } else if (callerId === "new_team") {
        newTeam_modal_content.style.display = "block";

        teamModal_close.onclick = function () {
            newTeam_modal_content.style.display = "none";
        }
    } else if (callerId === "new_project_report") {
        newProjectReport_modal_content.style.display = "block";

        projectReportModal_close.onclick = function () {
            newProjectReport_modal_content.style.display = "none";
        }
    } else if (callerId === "new_task_report") {
        newTaskReport_modal_content.style.display = "block";

        taskReportModal_close.onclick = function () {
            newTaskReport_modal_content.style.display = "none";
        }
    }
}

//----------------------------------------------------------------------------------------------------------//
//dynamic logout modal
let modal_logout = document.getElementById("confirm_logout");
let logout_close = document.getElementsByClassName("logout_close")[0];

function logoutModal() {
    modal_logout.style.display = "block";

    logout_close.onclick = function () {
        modal_logout.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target === modal_logout) {
            modal_logout.style.display = "none";
        }
    };
}

function noticeModals() {
    //notifications/warning modal scripts
    let close_span = document.getElementsByClassName("notice_close")[0];
    let modal_popup = document.getElementById("modal_notice");
    close_span.onclick = function () {
        modal_popup.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target === modal_popup) {
            modal_popup.style.display = "none";
        }
    };
}

// tab switching
function switchcommon(evt, mainName) {
    var i, tabcontent, tablinks;
    //get all elements under tabcontent and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(mainName).style.display = "block";
    evt.currentTarget.className += " active";
}
