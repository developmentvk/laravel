<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function getIndex()
    {
        $output = new \stdClass;
        return view('admin.dashboard.index', (array) $output);
    }

    public function getStats(Request $request)
    {
        $output = new \stdClass;
        $output->total_customers = \App\Models\User::count();
        return successMessage('success', 200, $output);
    }
}
