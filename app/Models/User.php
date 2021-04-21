<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

//class User extends Model
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
	
	/** 
	* The Atrribute that are mass assignable
	*
	*@var array
	*/
	
	protected $fillable = [
	  'user_type_id',
	  'email',
	  'password'
	];
	
	/** 
	* The Atrribute should be hidden for arrays
	*
	*@var array
	*/
	protected $dates = ['deleted_at'];
	
	protected $hidden = [
	  'password',
      'remember_token'	  
	];
	
	/** 
	* The Atrribute shuold be cast
	*
	*@var array
	*/
	
	protected $casts = [
		'email_verified_at' => 'datetime'
	];
	
	public function role() {
		return $this->belongsTo('App\Models\UserType','id');
	}
}
