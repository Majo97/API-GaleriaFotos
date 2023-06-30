<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Collection;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba la creación de una nueva colección.
     */
  /**
 * Prueba la creación de una nueva colección.
 */
public function testCreateCollection()
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/api/collections', [
            'title' => 'Nueva colección',
            'description' => 'Descripción de la colección',
            'type_id' => 1,
        ]);

    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'Collection created successfully',
    ]);
}


    /**
     * Prueba la actualización de una colección existente.
     */
    public function testUpdateCollection()
    {
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put('/api/collections/' . $collection->id, [
                'title' => 'Colección actualizada',
                'description' => 'Descripción actualizada',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Collection updated successfully',
        ]);
    }

    /**
     * Prueba la eliminación de una colección existente.
     */
    public function testDeleteCollection()
    {
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete('/api/collections/' . $collection->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Collection deleted successfully',
        ]);
    }
}
