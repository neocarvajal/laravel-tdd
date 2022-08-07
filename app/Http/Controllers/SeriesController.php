<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeriePreview;
use Illuminate\Http\Request;
use App\Models\Serie;

class SeriesController extends Controller
{
    public function index()
    {   
        return SeriePreview::collection(Serie::all());
    }
}
