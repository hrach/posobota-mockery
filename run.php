<?php

use Skrasek\TalkMocking\MovieDownloader;
use Skrasek\TalkMocking\PersonsRepository;
use Tracy\Debugger;


require __DIR__ . '/vendor/autoload.php';

Debugger::enable();

$personRepo = new PersonsRepository();
$movieDownloader = new MovieDownloader($personRepo);

$movie = $movieDownloader->get(263138);

dump($movie);
dump($movie->authorGroups[0]);
