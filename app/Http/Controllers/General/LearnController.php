<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;


class LearnController extends Controller
{
    public function learn()
    {
      return Inertia::render('General/Learn/Learn');
    }

    public function topics()
    {
      $categories = Category::withCount('words')->get();

      return Inertia::render('General/Learn/Topics', [
          'categories' => $categories,
      ]);
    }

    public function levels()
    {
        return Inertia::render('General/Learn/Levels');
    }

    public function grammars()
    {
        return Inertia::render('General/Learn/Grammars');
    }

}
