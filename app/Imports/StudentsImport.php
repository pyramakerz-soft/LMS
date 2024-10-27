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

    protected $class;

    public function __construct($classId)
    {
        $this->class = Group::findOrFail($classId);
    }

    public function model(array $row)
    {
        if (empty($row['username']) || empty($row['gender'])) {
            return null;
        }

        $username = str_replace(' ', '_', $row['username']);

        // Check if the username starts with a number
        if (preg_match('/^\d/', $username)) {
            throw new \Exception("The username '{$username}' cannot start with a number.");
        }

        // Validate gender value (assuming valid values are 'male' and 'female')
        $validGenders = ['boy', 'girl'];
        if (!in_array(strtolower($row['gender']), $validGenders)) {
            throw new \Exception("Invalid gender '{$row['gender']}' for username '{$username}'.");
        }

        // Check if the username already exists
        if (Student::where('username', $username)->exists()) {
            $this->duplicateUsernames[] = $username;
            return null;
        }

        $password = Str::random(8);

        return new Student([
            'username' => $username,
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => strtolower($row['gender']),
            'school_id' => $this->class->school_id,
            'stage_id' => $this->class->stage_id,
            'is_active' => 1,
            'image' => null,
            'class_id' => $this->class->id,
        ]);
    }
}
