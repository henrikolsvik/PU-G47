//Checking valid id for lecture for now this means not null
function checkNullStudent(){
    if(document.getElementById("selectLectureID").value == ""){
        alert("You need to enter an valid id!");
        return false;
    }
    if((idArray.indexOf(document.getElementById("selectLectureID").value)) == -1){
        alert("There is no lecture by this id");
        return false;
    }
    return true;
}

//Checking valid id for lecture for now this means not null
function checkNullLecturer(){
    if(document.getElementById("usernameL").value == "" || document.getElementById("passwordL").value == ""){
        alert("You need to enter both username and password!");
        return false;
    }
    if((nameArray.indexOf(document.getElementById("usernameL").value)) == -1){
        alert("There is no lecturer by this name");
        return false;
    }
    return true;
}

//Checking valid id for lecture for now this means not null
function checkNullAdmin(){
    if(document.getElementById("usernameA").value == "" || document.getElementById("passwordA").value == ""){
        alert("You need to enter both username and password!");
        return false;
    }
    if((adminArray.indexOf(document.getElementById("usernameA").value)) == -1){
        alert("There is no admin by this name");
        return false;
    }
    return true;
}

//Setting action atrib to refer user to studentfeedback
function setGotoStudent(){
    document.getElementById("formToValidS").action = "index.php?page=studentFeedback";
    return true;
}

//Setting action atrib to refer user to lecturerfeedback
function setGotoLecturer(value1, value2){
    document.getElementById("formToValidL").action = "index.php?page=lecturerOverview";
    document.getElementById("usernameL").value = value1;
    document.getElementById("passwordL").value = value2;
    document.getElementById("formToValidL").submit();
}

//Setting action atrib to refer user to adminSite
function setGotoAdmin(value1, value2){
    document.getElementById("formToValidA").action = "index.php?page=adminOverview";
    document.getElementById("usernameA").value = value1;
    document.getElementById("passwordA").value = value2;
    document.getElementById("formToValidA").submit();
}