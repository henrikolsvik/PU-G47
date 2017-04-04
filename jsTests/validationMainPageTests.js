QUnit.test("testing null detection in idInputField", function( assert ){
    idArray =  [""];
    document.getElementById("selectLectureID").value = "";
    assert.ok(checkNullStudent() == false, "null was detected");
});

//In the far off future this test maybe become a false negative.
QUnit.test("testing non-existing id in idInputField", function( assert ){
    document.getElementById("selectLectureID").value = "999";
    idArray = ['0','900','221', '1'];
    assert.ok(checkNullStudent() == false, "non-existing id was detected");
});

QUnit.test("testing correct id in idInputField", function( assert ){
    document.getElementById("selectLectureID").value = "999";
    idArray = ['0','999','221', '1'];
    assert.ok(checkNullStudent() == true, "was approved");
});

//Lecturer tests
QUnit.test("check of no password lecturer  detection", function( assert ){
     document.getElementById("passwordL").value = "";
     document.getElementById("usernameL").value = "Donald Trump";
     assert.ok(checkNullLecturer() == false, "no password; was denied");
});

QUnit.test("check of no username lecturer detection", function( assert ){
     document.getElementById("usernameL").value = "";
     document.getElementById("passwordL").value = "rewq";
     assert.ok(checkNullLecturer() == false, "no username; was denied");
});

QUnit.test("check of correct lecturer detection", function( assert ){
     document.getElementById("usernameL").value = "Donald Trump";
     document.getElementById("passwordL").value = "rewq";
     nameArray = ['Donald Trump','Jarl Kristiansen'];
     assert.ok(checkNullLecturer() == true, "was approved");
});

//Admin tests
QUnit.test("check of administrator no username detection", function( assert ){
     document.getElementById("usernameA").value = "";
     document.getElementById("passwordA").value = "rewq";
     assert.ok(checkNullAdmin() == false, "no username was denied");
});

QUnit.test("check of administrator no password detection", function( assert ){
     document.getElementById("passwordA").value = "";
     document.getElementById("usernameA").value = "Donald Trump";
     assert.ok(checkNullAdmin() == false, "no password was denied");
});

QUnit.test("check of administrator no password detection", function( assert ){
     document.getElementById("passwordA").value = "rewq";
     document.getElementById("usernameA").value = "Donald Trump";
     adminArray = ['Donald Trump'];
     assert.ok(checkNullAdmin() == true, "was approved");
});