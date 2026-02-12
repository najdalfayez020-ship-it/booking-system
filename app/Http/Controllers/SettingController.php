<?php

namespace App\Http\Controllers;
use App\Models\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{
public function edit()
{
    $setting = Setting::first();
    return view('admin.settings', compact('setting'));
}

public function update(Request $request)
{
    $request->validate([
        'opening_time' => 'required',
        'closing_time' => 'required|after:opening_time'
    ]);

    $setting = Setting::first();
    $setting->update($request->only('opening_time','closing_time'));

    return back()->with('success','Business hours updated successfully');
   

}
}
