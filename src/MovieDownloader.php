<?php

namespace Skrasek\TalkMocking;

use Kdyby\Curl\CurlSender;
use Kdyby\Curl\Request;
use Kdyby\Curl\Response;
use Nette\Utils\Json;


class MovieDownloader
{
	private $personsRepository;


	public function __construct(PersonsRepository $personsRepository)
	{
		$this->personsRepository = $personsRepository;
	}


	public function get($movieId)
	{
		$url = $this->buildUrl($movieId);

		$response = $this->downloadJson($url);
		if (!$response->isOk()) {
			throw new \Exception('Something wrong');
		}

		return $this->parseResponse($response);
	}


	private function buildUrl($movieId)
	{
		return 'http://csfdapi.cz/movie/' .  $movieId;
	}


	protected function downloadJson($url)
	{
		$sender = new CurlSender();
		$request = new Request($url);

		// $request->setPost(['apiKey' => ...]);

		return $sender->send($request);
	}


	private function parseResponse(Response $response)
	{
		$data = Json::decode($response->getResponse());

		$movie = new Movie();
		$movie->id = $data->id;
		$movie->year = $data->year;
		$movie->posterUrl = $data->poster_url;
		$movie->genres = $this->parseGenres($data);
		$movie->authorGroups = $this->parseAuthorGroups($data);
		$movie->rating = $data->rating;
		$movie->plot = $data->plot;
		$movie->url = $data->csfd_url;
		return $movie;
	}


	private function parseGenres($data)
	{
		$genres = [];
		foreach ($data->genres as $genreName) {
			$genre = new Genre();
			$genre->name = $genreName;
			$genres[] = $genre;
		}
		return $genres;
	}


	private function parseAuthorGroups($data)
	{
		$groups = [];
		foreach ($data->authors as $groupType => $persons) {
			$group = new PersonGroup();
			$group->type = $groupType;
			$group->persons = $this->parsePersons($persons);
			$groups[] = $group;
		}
		return $groups;
	}


	private function parsePersons($data)
	{
		$persons = [];
		foreach ($data as $personData) {
			$persons[] = $this->parsePerson($personData);
		}
		return $persons;
	}


	private function parsePerson($data)
	{
		$person = $this->personsRepository->getById($data->id);
		if ($person) {
			return $person;
		}

		$person = new Person();
		$person->id = $data->id;
		$person->name = $data->name;
		$person->url = $data->csfd_url;
		return $person;
	}

}
