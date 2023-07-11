//dynamic variables for modal types
var dashboard_modal_content = document.getElementById("dashboard_modal");
var close = document.getElementsByClassName("project_close")[0];

function selectedInterface() {
    dashboard_modal_content.style.display = "block";

    close.onclick = function () {
        dashboard_modal_content.style.display = "none";
    }
}

//----------------------------------------------------------------------------------------------------------//
//dynamic logout modal
var modal_logout = document.getElementById("confirm_logout");
var logout_close = document.getElementsByClassName("logout_close")[0];

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
    var close_span = document.getElementsByClassName("notice_close")[0];
    var modal_popup = document.getElementById("modal_notice");
    close_span.onclick = function () {
        modal_popup.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target === modal_popup) {
            modal_popup.style.display = "none";
        }
    };
}
