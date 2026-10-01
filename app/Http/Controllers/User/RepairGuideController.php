<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RepairGuide;

class RepairGuideController extends Controller
{
    public function show(RepairGuide $repairGuide)
    {
        $repairGuide->load('steps', 'diagnosis.device');
        return view('user.repair-guides.show', compact('repairGuide'));
    }
}
