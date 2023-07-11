//used to add the active class to the selected nav item
const allSideMenuTop = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenuTop.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenuTop.forEach(i => {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});


//used to toggle the sidebar:
const menuBar = document.querySelector('#main_content nav .uil.uil-bars');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
})


//responsive navbar js (mainly on the search, notification and profile
const searchButton = document.querySelector('#main_content nav form .form-input button');
const searchButtonIcon = document.querySelector('#main_content nav form .form-input button .uil');
const searchForm = document.querySelector('#main_content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('uil-search', 'uil-times');
        } else {
            searchButtonIcon.classList.replace('uil-times', 'uil-search');
        }
    }
})

//making the sidebar minimized by default for small screens
if (window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('uil-times', 'uil-search');
    searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('uil-times', 'uil-search');
        searchForm.classList.remove('show');
    }
})


//dark theme js
const themeButton = document.getElementById('dashboard-theme')
const darkTheme = 'dark'
const icon = 'uil-sun'

// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
const getCurrentIcon = () => themeButton.classList.contains(icon) ? 'uil-moon' : 'uil-sun'

// We validate if the user previously chose a topic
if (selectedTheme) {
    // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
    document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
    themeButton.classList[selectedIcon === 'uil-moon' ? 'add' : 'remove'](icon)
}

// Activate / deactivate the theme manually with the button
themeButton.addEventListener('click', () => {
    // Add or remove the dark / icon theme
    document.body.classList.toggle(darkTheme)
    themeButton.classList.toggle(icon)
    // We save the theme and the current icon that the user chose
    localStorage.setItem('selected-theme', getCurrentTheme())
    localStorage.setItem('selected-icon', getCurrentIcon())
})
