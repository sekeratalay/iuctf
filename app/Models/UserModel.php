<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $returnType = User::class;

	protected $allowedFields = [
		'team_id', 'username', 'email', 'name', 'password_hash', 'reset_hash', 'reset_start_time', 'activate_hash',
		'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
	];

	protected $validationRules = [
		'username'      => 'required|min_length[3]|alpha_numeric|is_unique[users.username,username,{username}]',
		'email'         => 'required|valid_email|is_unique[users.email,email,{email}]',
		'name'          => 'required|min_length[3]|string',
		'password_hash' => 'required',
	];

	protected $useTimestamps = true;
	protected $useSoftDeletes = true;
}
