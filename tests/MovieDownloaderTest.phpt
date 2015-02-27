<?php

use Skrasek\TalkMocking\MovieDownloader;
use Skrasek\TalkMocking\Person;
use Skrasek\TalkMocking\PersonsRepository;
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';


$personRepository = Mockery::mock(PersonsRepository::class);
$personRepository->shouldReceive('getById')->with(49181)->once()->andReturnUsing(function($id) {
	$person = new Person();
	$person->id = 49181;
	$person->name = 'Brian Kirk';
	$person->url = 'http://www.csfd.cz/tvurce/49181';
	$person->isPersisted = TRUE;

	return $person;
});
$personRepository->shouldReceive('getById')->with(4651)->once()->andReturnUsing(function($id) {
	$person = new Person();
	$person->id = 4651;
	$person->name = 'Daniel Minahan';
	$person->url = 'http://www.csfd.cz/tvurce/4651';
	$person->isPersisted = TRUE;

	return $person;
});
$personRepository->shouldReceive('getById')->andReturnNull();


$movieDownloader = new MovieDownloader($personRepository);
$movie = $movieDownloader->get(263138);

Assert::same(263138, $movie->id);
Assert::same(2011, $movie->year);

Assert::true(is_array($movie->genres));
Assert::same(3, count($movie->genres));
Assert::same('Dobrodružný', $movie->genres[2]->name);

Assert::same(6, count($movie->authorGroups));

Assert::true($movie->authorGroups[0]->persons[0]->isPersisted);
Assert::false($movie->authorGroups[0]->persons[3]->isPersisted);

// ...


Mockery::close();
