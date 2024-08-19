<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\TreeOrder;
use App\Models\User;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = $this->getUserDataForCharts();

        $totalSubscriptions = Subscription::where('status', 'active')->count();

        $totalCustomers = WebsiteUser::count();

        $treeDataForPIE = $this->getTreeDataForPIE();

        $labels = $treeDataForPIE->pluck('month')->toArray();
        $values = $treeDataForPIE->pluck('total')->toArray();

        $subscriptionsRevenue = Subscription::sum('grand_total');
        return view('home', compact('data', 'totalCustomers', 'totalSubscriptions', 'labels', 'values','subscriptionsRevenue'));
    }

    public function getUserDataForCharts()
    {
        $currentYear = date('Y');
        $months = [
            trans('January'),
            trans('February'),
            trans('March'),
            trans('April'),
            trans('May'),
            trans('June'),
            trans('July'),
            trans('August'),
            trans('September'),
            trans('October'),
            trans('November'),
            trans('December')
        ];

        // Retrieve monthly incidents from the database
        $monthlyUsers = \DB::table('User')
            ->selectRaw('TO_CHAR("createdAt", \'FMMonth\') as "month", COUNT(*) as "total"')
            ->whereYear('createdAt', $currentYear)
            ->groupByRaw('TO_CHAR("createdAt", \'FMMonth\')')
            ->orderByRaw('MIN("createdAt") ASC')
            ->get(['month', 'total']);

        // Create a collection of all months
        $allMonths = collect($months)->map(function ($month) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        // Normalize month names to ensure matching
        $monthlyUsers = $monthlyUsers->map(function ($item) use ($months) {
            $index = array_search($item->month, $months);
            return $index !== false ? ['month' => $months[$index], 'total' => $item->total] : null;
        })->filter();

        // Merge the result with the collection of all months
        $mergedData = $allMonths->map(function ($item) use ($monthlyUsers) {
            $matchingUser = $monthlyUsers->firstWhere('month', $item['month']);
            return $matchingUser ? $matchingUser : $item;
        });

        // Extract labels and data from the merged collection
        return [
            'labels' => $mergedData->pluck('month')->toArray(),
            'data' => $mergedData->pluck('total')->toArray(),
        ];
    }

    public function getTreeDataForPIE()
    {
        $currentYear = date('Y');
        $months = [
            trans('January'),
            trans('February'),
            trans('March'),
            trans('April'),
            trans('May'),
            trans('June'),
            trans('July'),
            trans('August'),
            trans('September'),
            trans('October'),
            trans('November'),
            trans('December')
        ];

        // Retrieve monthly incidents from the database
        $monthlyUsers = \DB::table('Tree_Order')
            ->selectRaw('TO_CHAR("createdAt", \'FMMonth\') as "month", COUNT(*) as "total"')
            ->whereYear('createdAt', $currentYear)
            ->groupByRaw('TO_CHAR("createdAt", \'FMMonth\')')
            ->orderByRaw('MIN("createdAt") ASC')
            ->get(['month', 'total']);

        // Create a collection of all months
        $allMonths = collect($months)->map(function ($month) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        // Normalize month names to ensure matching
        $monthlyUsers = $monthlyUsers->map(function ($item) use ($months) {
            $index = array_search($item->month, $months);
            return $index !== false ? ['month' => $months[$index], 'total' => $item->total] : null;
        })->filter();

        // Merge the result with the collection of all months
        $mergedData = $allMonths->map(function ($item) use ($monthlyUsers) {
            $matchingUser = $monthlyUsers->firstWhere('month', $item['month']);
            return $matchingUser ? $matchingUser : $item;
        });

        return $mergedData;


    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }


}
