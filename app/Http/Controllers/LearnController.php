<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;


class LearnController extends Controller
{
    public function topics()
    {
      $categories = Category::withCount('words')->get();

      return Inertia::render('Learn/Topics', [
          'categories' => $categories,
      ]);
    }

    public function levels()
    {
        return Inertia::render('Learn/Levels');
    }

    public function grammars()
    {
        return Inertia::render('Learn/Grammars');
    }

}
