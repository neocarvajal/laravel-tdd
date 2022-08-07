<?php

namespace App\Http\Controllers;


use App\Http\Requests\ListadoDeVideosRequest;
use App\Http\Resources\VideoPreview;
use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    public function index(ListadoDeVideosRequest $request)
    {
        
        /*
        * LLevar la logica del controlador a otro espacio en Dtos y mapear con maoInto()
         $videos = Video::all()
            ->map(function (Video $video){
                return [
                    'id' => $video->id,
                    'thumbnail' => $video->thumbnail,
                ];
            });
        
            return $videos; */

        $videos = Video::ultimos($request->getLimit(), $request->getPage())->get();
        
        return VideoPreview::collection($videos);
    
        
    }

    public function get($id)
    {
        return Video::find($id);
    }
}