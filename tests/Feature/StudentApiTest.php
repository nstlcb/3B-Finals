<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Student;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_retrieve_all_students()
    {
        // Create some students
        Student::factory()->count(3)->create();

        // Send GET request to /api/students
        $response = $this->getJson('/api/students');

        // Assert the response
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_student()
    {
        // Student data
        $studentData = [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'birthdate' => '2001-02-02',
            'sex' => 'FEMALE',
            'address' => '123 Main St',
            'year' => 1,
            'course' => 'CS',
            'section' => 'A',
        ];

        // Send POST request to /api/students
        $response = $this->postJson('/api/students', $studentData);

        // Assert the response
        $response->assertStatus(201)
                 ->assertJsonFragment($studentData);

        // Assert the student is in the database
        $this->assertDatabaseHas('students', $studentData);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        // Create a student
        $student = Student::factory()->create();

        // Update data
        $updateData = [
            'address' => '456 New Address',
            'section' => 'B',
        ];

        // Send PATCH request to /api/students/' . $student->id
        $response = $this->patchJson('/api/students/' . $student->id, $updateData);

        // Assert the response
        $response->assertStatus(200)
                 ->assertJsonFragment($updateData);

        // Assert the student is updated in the database
        $this->assertDatabaseHas('students', $updateData + ['id' => $student->id]);
    }
}
    

