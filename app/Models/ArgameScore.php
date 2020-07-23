<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArgameScore extends Model
{
	protected $table = 'argame_scores';

	public function getRanking($query, $id){
	   $collection = collect($query);
	   $data       = $collection->where('id', $id);
	   $value      = $data->keys()->first() + 1;
	   return $value;
	}

}
