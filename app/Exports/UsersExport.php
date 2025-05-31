<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    public function view(): View
    {
        $data = array(
            'user' => User::orderBy('role', 'asc')->get(),
            'date' => now()->format('d-m-Y_H.i.s'),
        );
        return view('rolevalidator/excel', $data);
    }
}
