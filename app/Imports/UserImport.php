<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Row Data:', $row);
        return new User([
            'user' => $row['user'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
            'wa_number' => $row['wa_number'],
            'address' => $row['address'],
            'about' => $row['about'],
            'description' => $row['description'],
            'role' => $row['role'],
            'status' => $row['status'],
            'color' => $row['color'],
        ]);
    }
}

