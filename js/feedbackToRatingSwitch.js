//Switching the lecturerFeedback page from feedback-mode to rating-mode
function endFeedback() {
    document.getElementById("divQuestion").style.visibility = "hidden";
    document.getElementById("divRating").style.visibility = "visible";
    document.getElementById("log_out").style.visibility = "hidden";
    document.getElementById("menu").style.visibility = "hidden";
    document.getElementById("end").style.visibility = "hidden";
    document.getElementById("finishForm").style.visibility = "visible";
}