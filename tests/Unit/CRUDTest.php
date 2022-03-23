<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Candidate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CRUDTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_create()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.pdf');
        $extension = $file->getClientOriginalExtension();
        //$doc_name = rand().'_a.'.$extension;
        //dd($doc_name);
        $data = [
            'cd_name' => 'Hardy', 
            'cd_edu' => 'BSI', 
            'cd_birth' => '1987-07-16', 
            'cd_exp' => '5', 
            'cd_lp' => 'Developer', 
            'cd_ap' => 'software developer', 
            'cd_skill' => 'Ms Word, Ms PowerPoint', 
            'cd_email' => 'vanturgo16@gmail.com', 
            'cd_phone' => '085155232216',
            //'doc' => $doc_name
        ];

        $this->postJson('/candidates/store', $data)
            ->assertRedirect('/candidates/');
            //->assertJson($data);
    }

    public function test_read()
      {
        $response = $this->get('/candidates');
        $this->assertTrue(true);
      }

    public function test_update(){
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.pdf');
        $extension = $file->getClientOriginalExtension();
        //$doc_name = rand().'_a.'.$extension;
        //dd($doc_name);
        $data = [
            'cd_name' => 'Hardy', 
            'cd_edu' => 'BSI', 
            'cd_birth' => '1987-07-16', 
            'cd_exp' => '5', 
            'cd_lp' => 'Developer', 
            'cd_ap' => 'software developer', 
            'cd_skill' => 'Ms Word, Ms PowerPoint', 
            'cd_email' => 'vanturgo16@gmail.com', 
            'cd_phone' => '085155232216',
            //'doc' => $doc_name
        ];

        $post=$this->postJson('/candidates/store', $data)
            ->assertRedirect('/candidates/');
            
        $update=$this->postJson('/candidates/update', $data)
            ->assertRedirect('/candidates/');
    }
      
    public function test_delete()
      {
        //$this->withoutMiddleware();
        $response = $this->call('GET', '/candidates/delete/12');
        $this->assertEquals(302, $response->getStatusCode());
      }
}
