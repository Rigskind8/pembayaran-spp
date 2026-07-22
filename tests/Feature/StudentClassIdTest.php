<?php

namespace Tests\Feature;

use App\Models\Student;
use Tests\TestCase;

class StudentClassIdTest extends TestCase
{
    public function test_it_allows_string_class_ids_for_students(): void
    {
        $student = Student::create([
            'name' => 'Test Student',
            'nis' => 'NIS-TEST-001',
            'class_id' => 'XII-IPA',
            'email' => 'student-test@example.com',
        ]);

        $this->assertSame('XII-IPA', $student->fresh()->class_id);
    }
}
