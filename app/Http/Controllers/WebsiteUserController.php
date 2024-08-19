<?php

namespace App\Http\Controllers;

use App\Models\ClimatePoint;
use App\Models\Subscription;
use App\Models\TreeOrder;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;

class WebsiteUserController extends Controller
{
    public function index()
    {
        $allUsers = WebsiteUser::all();
        return view('user.index', compact('allUsers'));
    }

    public function show($id)
    {

        $customer = WebsiteUser::findOrFail($id); // Adjust User model to your model for customers
        $treesCount = TreeOrder::where('user_id', $customer->id)
            ->where('status', 'completed')
            ->sum('tree_count');

        $climatePointsCount = ClimatePoint::where('user_id', $customer->id)->sum('count');

        $subscriptions = Subscription::where('user_id', $customer->id)->get();
        return view('user.show', compact('customer', 'treesCount', 'climatePointsCount', 'subscriptions'));
    }
}
