<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Student;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Str;

class StudentsImport implements ToModel, WithHeadingRow
{
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
        $password = Str::random(8);

        $student = Student::create([
            'username' => $row['username'],
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $row['gender'],
            'school_id' => $this->class->school_id,
            'stage_id' => $this->class->stage_id,
            'is_active' => 1,
            'image' => null,
            'class_id' => $this->class->id,
        ]);
        return $student;
    }


}
