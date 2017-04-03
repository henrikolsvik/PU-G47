QUnit.test("Check denial comment response", function( assert ){
    var feedbackType =
    {
    id: "comment",
    };
    var TimeToCheck = new Date();
    lastComment = TimeToCheck.getTime();
    assert.ok(feedbackControl(feedbackType) == "1", "Was denied");
});

QUnit.test("Check denial speed response", function( assert ){
    var feedbackType =
    {
    id: "speed",
    };
    var TimeToCheck = new Date();
    lastSpeed = TimeToCheck.getTime();
    assert.ok(feedbackControl(feedbackType) == "1", "Was denied");
});

QUnit.test("Check denial difficulty response", function( assert ){
    var feedbackType =
    {
    id: "difficulty",
    };
    var TimeToCheck = new Date();
    lastDifficulty = TimeToCheck.getTime();
    assert.ok(feedbackControl(feedbackType) == "1", "Was denied");
});
