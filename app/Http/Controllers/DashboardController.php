<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shetabit\Visitor\Traits\Visitor;
use App\Models\User;
use Shetabit\Visitor\Models\Visit;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();

        $userVisitorCounts = [];
        $visitorCount = 0;
        $allVisitorCounts = Visit::count();

        foreach ($users as $user) {
            $visitorCount += $user->visitLogs()->count();
            $userVisitorCounts[$user->id] = array('name'=>$user->name,'count'=>$visitorCount);
        }
        $allVisitorCounts = $allVisitorCounts - $visitorCount;
        return view('dashboard', ['userVisitorCounts' => $visitorCount, 'allVisitorCounts' => $allVisitorCounts]);
    }
}
