<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $classId;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($classId)
    {
        $this->classId = $classId;
    }

    /**
     * Collection of students.
     */
    public function collection()
    {
        return Student::where('class_id', $this->classId)
            ->with(['school', 'stage'])
            ->get()
            ->map(function ($student) {
                if ($student->gender == 'Boy' || $student->gender == 'boy') {
                    $gender = 'ذكر';
                } else {
                    $gender = 'انثى';
                }
                return [
                    'username' => str_replace('_', ' ', $student->username) ?? '',
                    'arabic_name' => $student->arabic_name ?? '',
                    'gender' => $gender ?? '',
                    'phone' => (string)$student->phone ?? '',
                    'birth_date' => $student->birth_date ?? '',
                ];
            });
    }
    public function headings(): array
    {
        return ['اسم الطالب باللغة الانجليزية', 'اسم الطالب باللغة العربية', 'الجنس', 'رقم الموبايل', 'تاريخ الميلاد'];
    }
}
