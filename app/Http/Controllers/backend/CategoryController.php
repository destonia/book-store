<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFormRequest;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('backend.category.list', compact('categories'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function edit($id)
    {
        $category = $this->categoryService->getById($id);
        return view('backend.category.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $this->categoryService->store($request);
        toastr()->success('Category: '.$request->name.' has been created','Create category');
        return redirect()->route('categories.index');
    }

    public function update(Request $request)
    {
        $category = $this->categoryService->getById($request->id);
        $this->categoryService->update($request);
        toastr()->info('Category: '.'<strong>'.$category->name.'</strong>'.' has been changed to '.'<strong>'.$request->name.'</strong>','Update category');
        return redirect()->route('categories.index');
    }

    public function delete($id)
    {
        $deleted = $this->categoryService->getById($id);
        $this->categoryService->delete($id);
        toastr()->error('Category: '.'<strong>'.$deleted->name.'</strong>'.' has been deleted','Delete category');
        return redirect()->route('categories.index');
    }

    public function search(Request $request)
    {
        $name = $request->search;
        $categories = $this->categoryService->search($name);
        toastr()->success('Here are the list of Categories for '.'<strong>'.$name.'</strong>','Search category');
        return view('backend.category.list', compact('categories'));
    }
}
