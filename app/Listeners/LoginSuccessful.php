<?php

namespace App\Listeners;

use App\Http\Controllers\CommonFunction;
use App\Models\Branch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (Auth::user()->type != "superman"){
            $branchinfo = Branch::where('id', CommonFunction::getBranchCode())->first();
            Session::put('branch_name', $branchinfo->name);
            Session::put('is_head_office', $branchinfo->is_head_office);
        }
    }
}
