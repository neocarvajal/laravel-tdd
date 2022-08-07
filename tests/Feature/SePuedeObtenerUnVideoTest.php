<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Video;

class SePuedeObtenerUnVideoTest extends TestCase
{
    use RefreshDatabase;

    public function testSePuedeObtenerUnVideoPorSuId()
    {
        $video = Video::factory()->create();

        $this->get(
            sprintf('/api/videos/%s', $video->id)
        )->assertExactJson([
            'id' => $video->id,
            'titulo' => $video->titulo,
            'descripcion' => $video->descripcion,
            'url_video' => $video->url_video
        ]);
    }
}
