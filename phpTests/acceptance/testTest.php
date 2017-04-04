<?php

$I = new AcceptanceTest($scenario);
$I->wantTo('ensure that page works is send');
$I->amOnPage('/mainPage.php');
$I->see('ENTER');

?>