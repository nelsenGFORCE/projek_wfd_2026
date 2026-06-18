<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(MovieRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(MovieRequest $request, Movie $movie)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted successfully.');
    }
}