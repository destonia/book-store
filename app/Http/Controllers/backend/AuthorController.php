<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Services\AuthorService;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        $authors = $this->authorService->getALl();
        return view('backend.author.list', compact('authors'));
    }

    public function create()
    {
        return view('backend.author.create');
    }

    public function edit($id)
    {
        $author = $this->authorService->getById($id);
        return view('backend.author.edit', compact('author'));
    }

    public function store(AuthorRequest $request)
    {
        $this->authorService->store($request);
        toastr()->success('Author: '.$request->name.' has been added','Add Author');
        return redirect()->route('authors.index');
    }

    public function update(AuthorRequest $request)
    {
        $author = $this->authorService->getById($request->id);
        $this->authorService->update($request,$author);
        toastr()->info('Author: '.'<strong>'.$author->name.'</strong>'.' has been changed to '.'<strong>'.$request->name.'</strong>','Update Author');
        return redirect()->route('authors.index');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $deleted = $this->authorService->getById($id);
        $this->authorService->delete($id);
        toastr()->error('Author: '.'<strong>'.$deleted->name.'</strong>'.' has been deleted','Delete Author');
        return redirect()->route('authors.index');
    }

    public function search(Request $request)
    {
        $name = $request->search;
        $authors = $this->authorService->search($name);
        toastr()->success('Here are the list of Authors for '.'<strong>'.$name.'</strong>','Search Author');
        return view('backend.author.list', compact('authors'));
    }
}
