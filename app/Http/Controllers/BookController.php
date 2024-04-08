<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clien = new Client();
        $url = "http://127.0.0.1:8000/api/books";
        $response = $clien->request('GET', $url);

        $data = $response->getBody()->getContents();
        $contentArray = json_decode($data, true);
        $datas = $contentArray['data'];

        return view('books.index', ['datas'=> $datas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $value = [
            'title' => $request->title,
            'author' => $request->author,
            'publication_date' => $request->publication_date
        ];

        $clien = new Client();
        $url = "http://127.0.0.1:8000/api/book";
        $response = $clien->request('POST', $url, [
            'headers' => ['content-type' => 'application/json'],
            'body' => json_encode($value)
        ]);

        $data = $response->getBody()->getContents();
        $contentArray = json_decode($data, true);
        if($contentArray['status'] != true){
            return redirect()->to('books')->withErrors($contentArray['data'])->withInput();
        }else {
            return redirect()->to('books')->with('success', $contentArray['message']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clien = new Client();
        $url = "http://127.0.0.1:8000/api/book/$id";
        $response = $clien->request('GET', $url);

        $data = $response->getBody()->getContents();
        $contentArray = json_decode($data, true);
        if($contentArray['status'] != true){
            return redirect()->to('books')->withErrors($contentArray['message']);
        }else {
            return view('books.index', ['data' => $contentArray['data']]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $value = [
            'title' => $request->title,
            'author' => $request->author,
            'publication_date' => $request->publication_date
        ];

        $clien = new Client();
        $url = "http://127.0.0.1:8000/api/book/$id";
        $response = $clien->request('PUT', $url, [
            'headers' => ['content-type' => 'application/json'],
            'json' => $value
        ]);

        $data = $response->getBody()->getContents();
        $contentArray = json_decode($data, true);
        if($contentArray['status'] != true){
            return redirect()->to('books')->withErrors($contentArray['data'])->withInput();
        }else {
            return redirect()->to('books')->with('success', $contentArray['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clien = new Client();
        $url = "http://127.0.0.1:8000/api/book/$id";
        $response = $clien->request('DELETE', $url);

        $data = $response->getBody()->getContents();
        $contentArray = json_decode($data, true);
        if($contentArray['status'] != true){
            return redirect()->to('books')->withErrors($contentArray['data'])->withInput();
        }else {
            return redirect()->to('books')->with('success', $contentArray['message']);
        }
    }
}
