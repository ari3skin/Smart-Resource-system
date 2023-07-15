function onReady() {
    document.getElementById("defaultOpen").click();

    $(document).ready(function () {

        // variable declarations
        let taskTM = $('#task-team-manager');
        let taskMI = $('#task-manager-individual');
        let taskEI = $('#task-employee-individual');
        let teamManager = $('#teamManager');


        //password comparison
        $('#password').on('keyup', function () {
            var newPassword = $('#first_password').val();
            var confirmPassword = $(this).val();

            if (newPassword !== confirmPassword) {
                $('#password-error').text('Passwords do not match');
            } else {
                $('#password-error').text('');
            }
        });

        //when creating a team, selecting a particular employee the already selected will be dulled onto others
        $('.member').on('change', function () {
            let selectedOptions = [];
            $('.member option:selected').each(function () {
                selectedOptions.push($(this).val());
            });

            $('.member option').each(function () {
                if (selectedOptions.indexOf($(this).val()) !== -1) {
                    if (!$(this).is(':selected')) {
                        $(this).prop('disabled', true);
                    }
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        //Initially hide all select fields
        taskTM.hide();
        taskMI.hide();
        taskEI.hide();

        // Event listener for checkbox of id 'teamManager'
        teamManager.click(function () {
            if ($(this).prop("checked") === true) {
                // Uncheck other checkbox
                $('#individual').prop('checked', false);

                // Show related select and hide others
                taskTM.show();
                taskMI.hide();
                taskEI.hide();
            } else {
                // Hide all selects if checkbox is unchecked
                taskTM.hide();
            }
        });
        teamManager.on('change', function () {
            if ($(this).prop('checked')) {
                // Checkbox is checked, add the information
                $('#team_notice').text('Kindly make sure the selected individual has a team before proceeding.');
            } else {
                // Checkbox is unchecked, clears the information
                $('#team_notice').text('');
            }
        });
        // Event listener for checkbox of id 'individual'
        $('#individual').click(function () {
            if ($(this).prop("checked") === true) {
                // Uncheck other checkbox
                $('#teamManager').prop('checked', false);

                // Show related selects and hide others
                taskMI.show();
                taskEI.show();
                taskTM.hide();
            } else {
                // Hide related selects if checkbox is unchecked
                taskMI.hide();
                taskEI.hide();
            }
        });
    });
}

function adminOnReady() {

    document.getElementById("defaultOpen").click();
    var modal_logout = document.getElementById("confirm_logout");
    var btn = document.getElementById("logout_btn");
    var close_span = document.getElementsByClassName("close")[0];
    setupModalEvents(modal_logout, btn, close_span);

    //password comparison
    $(document).ready(function () {
        $('#password').on('keyup', function () {
            var newPassword = $('#first_password').val();
            var confirmPassword = $(this).val();

            if (newPassword !== confirmPassword) {
                $('#password-error').text('Passwords do not match');
            } else {
                $('#password-error').text('');
            }
        });

        //configuring my datatable
        $('#tableData').DataTable(
            {
                "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                "iDisplayLength": 5
            }
        );
    });
}

function setupModalEvents(modal, button, closeSpan) {
    button.onclick = function () {
        modal.style.display = "block";
    }
    closeSpan.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
}
