<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serie;
use App\Models\Video;

class SePuedeObtenerLosVideosDeUnaSerieTest extends TestCase
{
    use RefreshDatabase;

    public function testSePuedeObtenerLosVideosDeUnaSerie()
    {
        Video::factory()->create();

        $serie = Serie::factory()->create();

        $serie->videos()->attach(
            Video::factory(2)->create()->pluck('id')->toArray()
        );

        $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function testElContenidoDeLosVideosEsElCorrecto()
    {
        
        $video = Video::factory()->create();
        $serie = Serie::factory()->create();
        $serie->videos()->attach($video->id);
        
        $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
            ->assertOk()
            ->assertExactJson([
                [
                    'id' => $video->id,
                    'thumbnail' => $video->thumbnail,
                ],
            ]);
    }   
}
