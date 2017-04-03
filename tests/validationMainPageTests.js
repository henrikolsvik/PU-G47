QUnit.test("testing null detection in idInputField", function( assert ){
    assert.ok(checkNullStudent() == false, "null was detected");
});

//In the far off future this test maybe become a false negative.
QUnit.test("testing non-existing id in idInputField", function( assert ){
    document.getElementById("selectLectureID").innerHTML = ("999");
    assert.ok(checkNullStudent() == false, "non-existing id was detected");
});