<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SePuedeObtenerUnListadoDeVideosTest extends TestCase
{
    use RefreshDatabase;

   public function testSePuedeObtenerUnListadoDeVideos()
   {
        // Obtener erorres detallados en test
        // $this->withoutExceptionHandling();

        Video::factory(2)->create();

        $this->getJson('/api/videos')->assertOk()->assertJsonCount(2);
   }

   public function testElPreviewDeUnVideoTieneIdYThumbnail()
   {
        // $videos = Video::factory(2)->create();

        // $this->getJson('/api/videos')->assertJson($videos->toArray());

        $unID = 12345;
        $unThumbnail = 'https://unaimagen.com';

        Video::factory()->create([
            'id' => $unID,
            'thumbnail' => $unThumbnail,
        ]);

        $this->getJson('/api/videos')
            ->assertExactJson([
                [
                    'id' => $unID,
                    'thumbnail' =>$unThumbnail,
                ],
            ]
        );
   }

   public function testLosVideosEstanOrdenadosDeNuevosAMasViejos()
   {
        $videoHaceUnMes = Video::factory()->create([
            'created_at' => Carbon::now()->subDays(30),
        ]);

        $videoHoy = Video::factory()->create([
            'created_at' => Carbon::now(),
        ]);

        $videoAyer = Video::factory()->create([
            'created_at' => Carbon::yesterday(),
        ]);

        $this->getJson('/api/videos')
            ->assertJsonPath('0.id', $videoHaceUnMes->id)
            ->assertJsonPath('1.id', $videoHoy->id)
            ->assertJsonPath('2.id', $videoAyer->id);

        // $response = $this->getJson('api/videos');

        // [$videoPrimero, $videoSegundo, $videoTercero] = $response->json();

        // $this->assertEquals($videoHaceUnMes->id, $videoPrimero['id']);
        // $this->assertEquals($videoHoy->id, $videoSegundo['id']);
        // $this->assertEquals($videoAyer->id, $videoTercero['id']);
   }

   public function testSePuedeLimitarElNumeroDeVideosAObtener()
   {
        Video::factory(5)->create();

        $this->getJson('/api/videos?limit=3')
            ->assertJsonCount(3);

   }

   public function testPorDefectoSoloTira30Videos()
   {
        Video::factory(40)->create();

        $this->getJson('/api/videos')
            ->assertJsonCount(30);
   }

   public function providerLimitesInvalidos(): array
   {
        return [
            'No se puede pasar un límite menor a 1' => [3, '-1'],
            'No se puede pasar un límite mayor a 50' => [51, '51'],
            'No se puede pasar un límite que sea un string' => [10, 'unString'],
        ];
   }

   /**
    * @dataProvider providerLimitesInvalidos
    */
   public function testDevuelveUnProcessableSiHayErrorEnElLimite(int $numeroDeVideos, string $limite)
   {
        Video::factory($numeroDeVideos)->create();

        $this->getJson(sprintf('/api/videos?limit=%s', $limite))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

   }

   public function testPodemosPaginarLosVideos()
   {
        Video::factory(9)->create();

        $this->getJson('/api/videos?limit=5&page=2')
            ->assertJsonCount(4);
    }

    public function testLaPaginaPorDefectoELaPrimera()
   {
        Video::factory(9)->create();

        $this->getJson('/api/videos?limit=5')
            ->assertJsonCount(5);
    }

    public function testDevuelveCeroVideosCuandoLaPaginaNoExiste()
    {
        Video::factory(9)->create();

        $this->getJson('/api/videos?limit=5&page=20')
            ->assertJsonCount(0);
    }

    public function proveedorDePagesInvalidas()
    {
        return [
            'No se puede pasar un string como page' => ['UnString'],
            'La página no puede ser menor de 1' => ['0'],
        ];
    }
    /**
     * @dataProvider proveedorDePagesInvalidas
     */

    public function testDevuelveUnProcessableSiHayErrorEnLaPage($invalidPage)
    {
        Video::factory(9)->create();
        
        $this->getJson(sprintf('/api/videos?page=%s', $invalidPage))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
