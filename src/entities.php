<?php

namespace Skrasek\TalkMocking;


class Movie
{
	/** @var int */
	public $id;
	/** @var int */
	public $year;
	/** @var string */
	public $posterUrl;
	/** @var Genre[] */
	public $genres;
	/** @var PersonGroup[] */
	public $authorGroups;
	/** @var float */
	public $rating;
	/** @var string */
	public $plot;
	/** @var string */
	public $url;
}

class Genre
{
	/** @var string */
	public $name;
}

class PersonGroup
{
	/** @var string */
	public $type;
	/** @var Person[] */
	public $persons;
}

class Person
{
	/** @var int */
	public $id;
	/** @var string */
	public $name;
	/** @var string */
	public $url;
	/** @var bool */
	public $isPersisted = FALSE;
}
