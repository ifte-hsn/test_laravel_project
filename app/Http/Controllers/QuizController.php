<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{

    /**
     * Save data as draft.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function draft(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'questions' => [
                'required',
                'array'
            ],
            'questions.*.question' => 'required',
            'questions.*.mandatory' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse(true, $validator->errors(), [], "Error while saving request"));
        }

        $questionList = $request->input('questions');

        $quiz = new Quiz();

        $quiz->title = $request->input('title');
        $quiz->description = $request->input('description');
        $quiz->save();


        foreach ($questionList as $question) {
            $q = new Question();
            $q->question = $question['question'];
            $q->mandatory = $question['mandatory'];
            $q->quiz_id = $quiz->id;
            $q->save();

            foreach ($question['options'] as $option) {


                $o = new Option();
                $o->title = $option['title'];
                $o->right_answer = $option['right_answer'];
                $o->question_id = $q->id;
                $o->save();
            }
        }
        return response()->json(Helper::formatStandardApiResponse(true, null, $quiz, "Quiz draft was successful"));
    }

    /**
     * publish data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'questions' => [
                'required',
                'array'
            ],
            'questions.*.question' => 'required',
            'questions.*.mandatory' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse(true, $validator->errors(), [], "Error while saving request"));
        }

        $questionList = $request->input('questions');

        $quiz = new Quiz();

        $quiz->title = $request->input('title');
        $quiz->description = $request->input('description');
        $quiz->published = true;
        $quiz->save();


        foreach ($questionList as $question) {
            $q = new Question();
            $q->question = $question['question'];
            $q->mandatory = $question['mandatory'];
            $q->quiz_id = $quiz->id;
            $q->save();

            foreach ($question['options'] as $option) {


                $o = new Option();
                $o->title = $option['title'];
                $o->right_answer = $option['right_answer'];
                $o->question_id = $q->id;
                $o->save();
            }
        }
        return response()->json(Helper::formatStandardApiResponse(true, null, $quiz, "Quiz published successfully"));
    }
    public function show(string $id)
    {
        try {
            $quiz = Quiz::with('questions.options')->findOrFail($id);
            return response()->json(Helper::formatStandardApiResponse(true, null, $quiz));
        } catch (ModelNotFoundException $e) {
            return response()->json(Helper::formatStandardApiResponse(false, ['no result found'], null));
        }

    }
}
