function openTab(evt, userType) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(userType).style.display = "block";
    if (userType == 'Student') {
        tablinks[0].style.border = "1px solid black";
        tablinks[1].style.border = "none";
        tablinks[2].style.border = "none";
    } else if (userType == 'Lecturer') {
        tablinks[0].style.border = "none";
        tablinks[1].style.border = "1px solid black";
        tablinks[2].style.border = "none";
    } else {
        tablinks[0].style.border = "none";
        tablinks[1].style.border = "none";
        tablinks[2].style.border = "1px solid black";
    }
    evt.currentTarget.className += " active";
}