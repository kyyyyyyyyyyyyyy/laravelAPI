<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::orderBy('title', 'asc')->get();

        return response()->json([
            'status' => true,
            'messsage' => 'data has found',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Book;

        $rules = [
            'title' => 'required',
            'author' => 'required',
            'publication_date' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messaage' => 'error request',
                'data' => $validator->errors()
            ]);
        }

        $data->title = $request->title;
        $data->author = $request->author;
        $data->publication_date = $request->publication_date;

        $post = $data->save();
        return response()->json([
            'status' => true,
            'message' => 'data successfuly created',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Book::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'data has found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Book::find($id);
        if(!$data){
            return response()->json([
                'satus' => true,
                'message' => 'data not found'
            ]);
        }

        $rules = [
            'title' => 'required',
            'author' => 'required',
            'publication_date' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messaage' => 'error request',
                'data' => $validator->errors()
            ]);
        }

        $data->title = $request->title;
        $data->author = $request->author;
        $data->publication_date = $request->publication_date;

        $post = $data->save();
        return response()->json([
            'status' => true,
            'message' => 'data successfuly updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Book::find($id);
        if(!$data){
            return response()->json([
                'satus' => true,
                'message' => 'data not found'
            ],);
        }

        $post = $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'data successfuly deleted',
        ], 200);
    }
}
