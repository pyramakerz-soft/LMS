<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\ObservationHeader;
use App\Models\ObservationQuestion;
use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Observer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ObserverController extends Controller
{
    public function index(Request $request)
    {
        $observers = Observer::query()
            ->paginate(30)
            ->appends($request->query());
        return view('admin.observers.index', compact('observers'));
    }


    public function create()
    {
        return view('admin.observers.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->merge([
            'username' => str_replace(' ', '_', $request->input('username'))
        ]);

        $request->validate([
            'name' => 'required',
            'username' => [
                'required',
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
                Rule::unique('observers'),
            ],
            'gender' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ]);


        Observer::create([
            'name' => $request->name,
            'username' => $request->input('username'),
            'password' => Hash::make($request->password),
            'gender' => $request->input('gender'),
            'is_active' => 1
        ]);

        return redirect()->route('observers.index')->with('success', 'Observer created successfully.');
    }

    public function edit(string $id)
    {
        $observer = Observer::findOrFail($id);

        return view('admin.observers.edit', compact('observer'));
    }
    public function update(Request $request, string $id)
    {
        $student = Observer::findOrFail($id);

        $request->merge([
            'username' => str_replace(' ', '_', $request->input('username'))
        ]);

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $student->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('observers.index')->with('success', 'Observer updated successfully.');
    }

    public function destroy(string $id)
    {
        $observer = Observer::findOrFail($id);
        $observer->delete();
        return redirect()->route('observers.index')->with('success', 'Observer deleted successfully.');
    }

    public function show(string $id)
    {
        $observer = Observer::findOrFail($id);
        return view('admin.observers.show', compact('observer'));
    }
    public function addQuestions(Request $request)
    {
        $headers = ObservationHeader::all();
        $observers = Observer::query()
            ->paginate(30)
            ->appends($request->query());


        foreach ($headers as $header) {
            if (!isset($data[$header->id])) {
                $data[$header->id] = [
                    'header_id' => $header->id,
                    'name' => $header->header,
                    'questions' => [],
                ];
            }
            $questions = ObservationQuestion::where('observation_header_id', $header->id)->get();
            $headerQuestions = [];
            foreach ($questions as $question) {
                if (!isset($headerQuestions[$question->id])) {
                    $headerQuestions[$question->id] = [
                        'question_id' => $question->id,
                        'name' => $question->question,
                        'avg_rating' => 0,
                        'max_rating' => $question->max_rate,
                    ];
                }
            }
            $data[$header->id]['questions'] = $headerQuestions;
        }
        // dd($data);
        return view('admin.observers.observation_questions', compact('observers', 'data'));
    }
    public function deleteQuestion($id)
    {
        $question = ObservationQuestion::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'header_id' => 'required|exists:observation_headers,id',
            'name' => 'required|string|max:255',
            'max_rating' => 'required|integer|min:1',
        ]);

        ObservationQuestion::create([
            'observation_header_id' => $request->header_id,
            'name' => $request->name,
            'max_rate' => $request->max_rating,
        ]);

        return redirect()->back()->with('success', 'Question added successfully.');
    }

    public function deleteHeader($id)
    {
        $header = ObservationHeader::findOrFail($id);
        $header->delete();

        return redirect()->back()->with('success', 'Header deleted successfully.');
    }
}
