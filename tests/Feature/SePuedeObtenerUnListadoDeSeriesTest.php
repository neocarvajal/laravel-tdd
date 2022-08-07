<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serie;

class SePuedeObtenerUnListadoDeSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testSePuedeObtenerUnListadoDeSeries()
    {
        Serie::factory(2)->create();

        $this->getJson('/api/series')
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function testElPreviewDeUnaSerieTieneElFormatoCorrecto()
    {
        $id = 12345;
        $titulo = 'Un Titulo';
        $thumbnail = 'https://thumbnail.com';
        $resumen = 'un resumen';
        Serie::factory()->create([
                'id' => $id,
                'titulo' => $titulo,
                'thumbnail' => $thumbnail,
                'resumen' => $resumen,
        ]);

        $this->getJson('/api/series')
            ->assertExactJson([
                [
                    'id' => $id,
                    'titulo' => $titulo,
                    'thumbnail' => $thumbnail,
                    'resumen' => $resumen,
                ],
                
            ]);
    }
}
