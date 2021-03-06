<?php

namespace App\Repositories;

use App\Tag;

use Illuminate\Support\Str;

class TagRepository extends ResourceRepository
{

    protected $tag;

    public function __construct(Tag $tag)
	{
		$this->model = $tag;
	}

	public function store(Array $inputs)
	{
		$tags = explode(',', $inputs['tag']);

		foreach ($tags as $tag) {

			$tag = trim($tag);

			$tag_url = Str::slug($tag);

			$tag_ref = $this->model->where('tag_url', $tag_url)->first();

			if(is_null($tag_ref))
			{
				$tag_ref = new $this->model([
					'tag' => $tag,
					'tag_url' => $tag_url
				]);	

				$tag_ref->save();
			}

		}

	}

	public function attach($table, $tags)
	{
		$tags = explode(',', $tags);

		foreach ($tags as $tag) {

			$tag = trim($tag);

			$tag_url = Str::slug($tag);

			$tag_ref = $this->model->where('tag_url', $tag_url)->first();

			if(is_null($tag_ref)) 
			{
				continue;

			} else {
			
				$table->tags()->attach($tag_ref->id);

			}

		}
	}

}