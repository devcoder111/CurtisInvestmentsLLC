<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{

    protected $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function maintenance() {
        $maintenance = $this->app->isDownForMaintenance();

        return view('admin.maintenance', ['maintenance' => $maintenance]);
    }

    public function toggleMaintenance() {
        $maintenance = $this->app->isDownForMaintenance();
        $cmd = $maintenance ? 'up' : 'down';
        $message = !$maintenance ? ' --message="Under Maintenance"' : '';
        Artisan::call($cmd . $message);
        $success = 'Maintenance mode set to ' . ($maintenance ? 'OFF' : 'ON');
        return redirect()->route('admin.maintenance')->with('success', $success);
    }

    public function users() {
        $users = User::paginate(15);

        return view('admin.users', ['users' => $users]);
    }

    public function payments() {
        return view('admin.payments');
    }
}
