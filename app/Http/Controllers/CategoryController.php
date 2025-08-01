<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\LogCategoryService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    protected LogCategoryService $logCategoryService;

    public function __construct(LogCategoryService $logCategoryService)
    {
        $this->logCategoryService = $logCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.categories.index', [
            'title' => 'Categories',
            'categories' => Category::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.categories.create', [
            'title' => 'Create Category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
            $path = $request->file('image') ? $request->file('image')->store('categories') : '';

            Category::create([
                'name' => $request->name,
                'image' => $path,
                'slug' => $slug,
            ]);

            $this->logCategoryService->insert(new Request($request->all()), 'insert');

            return redirect()->route('categories.index')->with('SUCCESS', 'Kategori berhasil ditambahkan');
        } catch (Exception $exception) {
            return redirect()->route('categories.index')->with('FAILED', 'Kategori gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('pages.admin.categories.show', [
            'title' => 'Detail Category',
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pages.admin.categories.edit', [
            'title' => 'Edit Category',
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $path = $category->image;
            $slug = SlugService::createSlug(Category::class, 'slug', $request->name);

            if ($request->file('image') && $path) {
                Storage::delete($path);
                $path = $request->file('image')->store('categories');
            } elseif ($request->file('image')) {
                $path = $request->file('image')->store('categories');
            }

            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $path,
            ]);

            $this->logCategoryService->insert(new Request($request->all()), 'update');

            return redirect()->route('categories.index')->with('SUCCESS', 'Kategori berhasil diubah');
        } catch (Exception $exception) {
            return redirect()->route('categories.index')->with('SUCCESS', 'Kategori gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            Storage::delete($category->image);

            $this->logCategoryService->insert(new Request($category->toArray()), 'delete');

            return redirect()->route('categories.index')->with('SUCCESS', 'Kategori berhasil dihapus');
        } catch (Exception $exception) {
            return redirect()->route('categories.index')->with('SUCCESS', 'Kategori gagal dihapus');
        }
    }
}
