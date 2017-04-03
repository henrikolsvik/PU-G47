QUnit.test( "hello test", function( assert ) {
  assert.ok( 1 == "1", "Passed!" );
});

QUnit.test( "Check Colour Change" , function( assert ){
    changeColor();
    assert.equal(color,"green");
});

<script src="pages/studentFeedbackResponse.php">  </script>