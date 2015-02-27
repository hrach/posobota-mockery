<?php

namespace Skrasek\TalkMocking;


class PersonsRepository
{

	public function getById($id)
	{
		if ($id === 49181) {
			$person = new Person();
			$person->id = 49181;
			$person->name = 'Brian Kirk';
			$person->url = 'http://www.csfd.cz/tvurce/49181';
			$person->isPersisted = TRUE;
			return $person;

		} elseif ($id === 4651) {
			$person = new Person();
			$person->id = 4651;
			$person->name = 'Daniel Minahan';
			$person->url = 'http://www.csfd.cz/tvurce/4651';
			$person->isPersisted = TRUE;
			return $person;

		} else {
			return NULL;
		}
	}

}
