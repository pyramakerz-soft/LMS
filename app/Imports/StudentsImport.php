<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Student;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Str;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null

    
     */

    protected $classId;

    public function __construct($classId)
    {
        $this->class = Group::findOrFail($classId);
    }

    public function model(array $row)
    {
        // Check if mandatory fields are empty
        if (empty($row['username']) || empty($row['gender'])) {
            throw new \Exception("Username or gender field cannot be empty.");
        }

        // Replace spaces in username with underscores
        $username = str_replace(' ', '_', $row['username']);

        // Generate a random password
        $password = str::random(8);

        // Create a new student record
        return new Student([
            'username' => $username,
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $row['gender'],
            'school_id' => $this->class->school_id,
            'stage_id' => $this->class->stage_id,
            'is_active' => 1,
            'image' => null,
            'class_id' => $this->class->id,
        ]);
    }
}
