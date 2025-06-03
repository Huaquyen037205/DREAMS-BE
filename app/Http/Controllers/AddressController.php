<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // ✅ Thêm địa chỉ mới
    public function store(Request $request)
    {
        $request->validate([
            'adress' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $isFirst = !Address::where('user_id', $user->id)->exists();

        $address = Address::create([
            'adress' => $request->adress,
            'user_id' => $user->id,
            'is_default' => $isFirst,
        ]);

        return response()->json([
            'message' => 'Thêm địa chỉ thành công',
            'data' => $address,
        ]);
    }

    // ✅ Đặt địa chỉ mặc định
    public function setDefault($id)
    {
        $user = Auth::user();

        $address = Address::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // Gỡ tất cả mặc định
        Address::where('user_id', $user->id)->update(['is_default' => false]);

        // Đặt địa chỉ này là mặc định
        $address->update(['is_default' => true]);

        return response()->json(['message' => 'Đã cập nhật địa chỉ mặc định']);
    }
}
