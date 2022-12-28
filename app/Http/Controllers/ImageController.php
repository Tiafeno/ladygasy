<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
	public function image($size, $image)
	{
		try {
			if ($size == 'original' || !$size) {
				$path = Storage::disk('local')->get("public/product/{$image}");
			} else {
				$path = Storage::disk('local')->get("public/product/thumbnail/{$size}-{$image}");
			}

			$file = File::get($path);
			$type = File::mimeType($path);
			$response = Response::stream(function() use($file) {
				echo $file;
			}, 200, ["Content-Type"=> $type]);
			return $response;
		} catch (\Exception $e) {
			return null;
		}

	}
}
