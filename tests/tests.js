QUnit.test("hello test", function( assert ) {
    assert.ok( 1 == "1", "Passed!" );
});

QUnit.test("Check correct response", function( assert ){
    var feedbackType =
    {
    id: "comment",
    };
    var TimeToCheck = new Date();
    lastComment = TimeToCheck.getTime();
    alert(feedbackType);
    alert(feedbackType.id);
    alert(lastComment);
    alert(feedbackControl(feedbackType));
    assert.ok(feedbackControl(feedbackType) == "1", "Was denied");
});