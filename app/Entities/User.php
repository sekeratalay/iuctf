<?php namespace App\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $attributes = [
		'id'        => null,
		'team_id'   => null,
		'username'  => null,
		'email'     => null,
		'name'      => null,
	];

	public function team()
	{
		$teamModel = new \App\Models\TeamModel();

		return $teamModel->find($this->attributes['team_id']);
	}
}
