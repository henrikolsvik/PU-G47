//Controls how many seconds may pass between each type of feedback
var secsBetween = 1*60000;
var lastComment = "0"
var lastDifficulty = "0"
var lastSpeed = "0"


//validation of time between feedbacks
function feedbackControl(feedbackType){
    var currentTime = new Date();
    if(feedbackType.id == "comment"){
        if(lastComment+secsBetween > currentTime.getTime()){
            alert("You need to wait a bit with your comment");
            feedbackType.action = "";
            return 1;
        }
        else{
            feedbackType.action = "index.php?page=submitText";
            lastComment = currentTime.getTime();
        }
        
    }
    else if(feedbackType.id == "speed"){
        if(lastSpeed+secsBetween > currentTime.getTime()){
            alert("You need to wait a bit with your feedback");
            feedbackType.action = "";
            return 1;
        }
        else{
            feedbackType.action = "index.php?page=submitSpeed";
            lastSpeed = currentTime.getTime();
        }
    }
    else if(feedbackType.id == "difficulty"){
        if(lastDifficulty+secsBetween > currentTime.getTime()){
            alert("You need to wait a bit with your feedback");
            feedbackType.action = "";
            return 1;
        }
        else{
            feedbackType.action = "index.php?page=submitDifficult";
            lastDifficulty = currentTime.getTime();
        }

    }
    return 0;
}  

//used for the studentfeedback page response mechanism
function changeColor(sender){
    var i = feedbackControl(sender);
    //skips effect to signal lack of success
    if(i == 0){
        color="green";
        document.body.style.background = color;
        setTimeout(function(){ 
            color = "#e7e7e7";
            document.body.style.background = color; 
            }, 500);
    }
    return true;
}