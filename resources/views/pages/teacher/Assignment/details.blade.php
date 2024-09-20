@extends('pages.teacher.teacher')

@section("title")
  Create Assignment
@endsection

@section("InsideContent")

@php
   $data = [
        'point' => '95',
        'dueDate' => '2024-10-01',
        'topic' => 'Mathematics',
        'assignTo' => ['Class A', 'Class B'],
        'title' => 'Homework Assignment',
        'description' => 'Solve the problems in chapter 5.',
        'uploadedFileName' =>
        [
            ['type' => 'photo', 'url' => 'images/Layer 2.png'],
            ['type' => 'photo', 'url' => 'images/Layer 2.png'],
            ['type' => 'video', 'url' => '/path/to/video.mp4'],
            ['type' => 'video', 'url' => '/path/to/video.mp4'],
            ['type' => 'pdf', 'url' => '/path/to/file.pdf', 'file_name' => 'HannahBusing_Resume.pdf', 'file_space' => '200 KB'],
            ['type' => 'pdf', 'url' => '/path/to/file.pdf', 'file_name' => 'HannahBusing_Resume.pdf', 'file_space' => '200 KB'],
            ['type' => 'pdf', 'url' => '/path/to/file.pdf', 'file_name' => 'HannahBusing_Resume.pdf', 'file_space' => '200 KB'],
            ['type' => 'link', 'url' => 'https://example.com']
        ],
    ];
    $paths = [
      ["name" => "Assignment", "url" => "teacher.Assignment"],
      ["name" => "AssignmentName", "url" => "teacher.assignment.show"],
    ];



<div class="flex justify-between">

  @include('components.path', ['paths' => $paths])

  <!-- Create Button Wrapped in Link -->
  <a href="{{ route('teacher.assignment.edit') }}">
      <button class="w-[99.13px] h-[55.47px] rounded-[11.23px] py-[11.23px] px-[21.06px] bg-[#17253E] text-white border-none mt-4">
          Edit
      </button>
      
  </a>

</div>


  @include('components.AssignmentDetails', ['paths' =>$paths  ,  $data])

@endsection



