<html>
<?php
    include "../phpScripts/mainPagePHPscript.php";
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>QUnit Example</title>
  <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-2.3.0.css">
</head>
<body>
  <div id="qunit"></div>
  <div id="qunit-fixture"></div>
  <p hidden id="selectLectureID"></p>
  <script src="../js/studentFeedbackController.js"></script>
  <script src="../js/tabController.js"></script>
  <script src="../js/validationMainPage.js"></script>
  <script src="https://code.jquery.com/qunit/qunit-2.3.0.js"></script>
  <script src="validationMainPageTests.js"></script>
</body>
</html>