<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoPreview;
use Illuminate\Http\Request;
use App\Models\Serie;

class VideoSerieController extends Controller
{
    public function index(Serie $serie)
    {
        return VideoPreview::collection($serie->videos);
    }
}
