<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Mail\Markdown;
use \Storage;

class PostController extends Controller
{

	public function index(){
		$posts = collect(Storage::disk('posts')->files());

		$posts = $posts->map(function($post){
			$postSummary = explode("\n", Storage::disk('posts')->get($post));

			$postDetails = explode("-", $post);

			return [
				'title' => trim(str_replace("#", "", $postSummary[0])),
				'slug' => str_replace(".md", "", $post),
				'date' => Carbon::createFromFormat("Y-m-d", "{$postDetails[0]}-{$postDetails[1]}-{$postDetails[2]}")->format('Y-m-d'),
				'body' => Markdown::parse(join("\n\n", [$postSummary[2], $postSummary[4]])),
				'tags' => $this->getTagList($post)
			];
		});

		return view('posts', [
			'posts' => $posts
		]);
	}

	public function showOne($slug){
		if(!Storage::disk('posts')->exists("{$slug}.md")){
			abort(404);
		}

		$post = "{$slug}.md";

		$postContent = Storage::disk('posts')->get($post);
		$postSummary = explode("\n", $postContent);

		$postDetails = explode("-", $post);

		return view('post', [
			'title' => trim(str_replace("#", "", $postSummary[0])),
			'slug' => str_replace(".md", "", $post),
			'date' => Carbon::createFromFormat("Y-m-d", "{$postDetails[0]}-{$postDetails[1]}-{$postDetails[2]}")->format('Y-m-d'),
			'body' => Markdown::parse($postContent),
			'tags' => $this->getTagList($post)
		]);
	}

	public function showTags($tag){
		$tagList = $this->getTagList();

		if(!isset($tagList[$tag])){
			abort(404);
		}

		$posts = collect($tagList[$tag])->unique();

		$posts = $posts->map(function($post){
			if(!Storage::disk('posts')->exists($post)){
				return false;
			}
			$postSummary = explode("\n", Storage::disk('posts')->get($post));

			$postDetails = explode("-", $post);

			return [
				'title' => trim(str_replace("#", "", $postSummary[0])),
				'slug' => str_replace(".md", "", $post),
				'date' => Carbon::createFromFormat("Y-m-d", "{$postDetails[0]}-{$postDetails[1]}-{$postDetails[2]}")->format('Y-m-d'),
				'body' => Markdown::parse(join("\n\n", [$postSummary[2], $postSummary[4]])),
				'tags' => $this->getTagList($post)
			];
		})->filter();

		return view('posts', [
			'posts' => $posts
		]);
	}

	private function getTagList($forPost = null){
		$tagManifest = json_decode(Storage::disk('local')->get("tags.json"), true);

		if($forPost && isset($tagManifest[$forPost])){
			return $tagManifest[$forPost];
		}

		$tagList = [];
		foreach($tagManifest as $post => $tags){
			foreach($tags as $tagName){
				$tagList[$tagName][] = $post;
			}
		}

		return $tagList;
	}
}
