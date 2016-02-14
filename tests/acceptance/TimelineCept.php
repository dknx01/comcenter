<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('See timeline and Pinned meu link is working');
$I->amOnPage('/timeline'); 
$I->see('Home');
$I->canSeeNumberOfElements('div.tweet', 50);

$I->seeElement('div', array('id' => 'menu'));

$I->seeLink('Pinned', 'https://www.erikwitthauer.de/cc/twitter/pinned');
$I->click('Pinned');
$I->amOnUrl('https://www.erikwitthauer.de/cc/twitter/pinned');