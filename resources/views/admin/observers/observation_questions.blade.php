@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">
                <h1>Observers</h1>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <div class="mb-4 flex" style="gap:10px; padding:10px">
                        <div class="questions mb-3">
                            @foreach ($data as $header)
                            <div class="flex justify-between items-center mb-4">
                                <h1 class="text-lg font-semibold text-[#667085]" style="font-size:24px">{{ $header['name'] }}</h1>

                                <!-- Action Buttons -->
                                <div>
                                    <!-- Add Question Button -->
                                    <button class="btn btn-primary" onclick="openAddQuestionModal('{{ $header['header_id'] }}')">
                                        Add Question
                                    </button>

                                    <!-- Delete Header Button -->
                                    <form action="{{ route('headers.deleteHeader', $header['header_id']) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Delete Header
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Table for questions -->
                            @if (!empty($header['questions']))
                            <table class="w-full border border-gray-300 text-left mb-4">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2">Question</th>
                                        <th class="border px-4 py-2">Max Rating</th>
                                        <th class="border px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($header['questions'] as $question)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $question['name'] }}</td>
                                        <td class="border px-4 py-2">{{ $question['max_rating'] }}</td>
                                        <td class="border px-4 py-2">
                                            <!-- Delete Question Button -->
                                            <form action="{{ route('questions.destroy', $question['question_id']) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p>No questions found for this header</p>
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Add Question Modal -->
                <div id="add-question-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                        <h2 class="text-lg font-semibold mb-4">Add Question</h2>
                        <form id="add-question-form" method="POST" action="{{ route('questions.storeQuestion') }}">
                            @csrf
                            <input type="hidden" name="header_id" id="modal-header-id">

                            <!-- Question Name -->
                            <div class="mb-4">
                                <label for="question-name" class="block text-sm font-medium text-gray-700">Question Name</label>
                                <input type="text" id="question-name" name="name" class="w-full p-2 border border-gray-300 rounded" required>
                            </div>

                            <!-- Max Rating -->
                            <div class="mb-4">
                                <label for="max-rating" class="block text-sm font-medium text-gray-700">Max Rating</label>
                                <input type="number" id="max-rating" name="max_rating" class="w-full p-2 border border-gray-300 rounded" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="button" class="btn btn-secondary mr-2" onclick="closeAddQuestionModal()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>



            </div>

        </main>

    </div>
</div>
@endsection

@section('page_js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#school, #class').change(function() {
            $('#filterForm').submit();
        });
    });

    $('#clearFilters').click(function(e) {
        e.preventDefault();
        $('#school').val('').prop('selected', true);
        $('#class').val('').prop('selected', true);
        $('#filterForm').submit();
    });
</script>
<script>
    function openAddQuestionModal(headerId) {
        document.getElementById('modal-header-id').value = headerId;
        document.getElementById('add-question-modal').classList.remove('hidden');
    }

    function closeAddQuestionModal() {
        document.getElementById('add-question-modal').classList.add('hidden');
    }
</script>

@endsection