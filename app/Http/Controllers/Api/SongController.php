<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;

class SongController extends Controller
{

    /**
     * @return string[]
     */
    public function get(): array
    {
        return ['status' => 'success'];
    }
}
