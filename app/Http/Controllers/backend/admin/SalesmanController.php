<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use PDOException;

class SalesmanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function salesman_add(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {

            $photo = $request->file('photo');
            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/user/' . uniqid() . '.' . $photo_extension;
                $image = Image::make($photo);
                $image->resize(300, 300);
                $image->save($photo_name);
            } else {
                $photo_name = null;
            }
            try {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'user_type' => $request->user_type,
                    'photo' =>  $photo_name,
                ]);
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }


        $data['active_menu'] = 'salesman_add';
        $data['page_title'] = 'Salesman Add';
        return view('backend.admin.pages.salesman_add', compact('data'));
    }

    public function salesman_list()
    {
        $data = [];
        $data['salesman_list'] = DB::table('users')
            ->where('user_type', 'salesman')
            ->get();

        $data['active_menu'] = 'salesman_list';
        $data['page_title'] = 'Salesman List';
        return view('backend.admin.pages.salesman_list', compact('data'));
    }

    // edit 


   public function salesman_edit(Request $request, $id)
{
    $data = [];
    $data['salesman'] = User::findOrFail($id);

    if ($request->isMethod('post')) {
        $old_photo = $data['salesman']->photo;
        $photo = $request->file('photo');

        if ($photo) {
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = 'backend_assets/images/user/' . uniqid() . '.' . $photo_extension;

            // Resize and save using Intervention Image
            $image = Image::make($photo);
            $image->resize(300, 300);
            $image->save(public_path($photo_name));

            if (File::exists(public_path($old_photo))) {
                File::delete(public_path($old_photo));
            }
        } else {
            $photo_name = $old_photo;
        }

        try {
            $data['salesman']->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password ? bcrypt($request->password) : $data['salesman']->password,
                'user_type' => $request->user_type,
                'photo' => $photo_name, // ✅ fixed here
            ]);
            return back()->with('success', 'Updated Successfully');
        } catch (PDOException $e) {
            return back()->with('error', 'Failed Please try Again');
        }
    }

    $data['active_menu'] = 'salesman_edit';
    $data['page_title'] = 'Salesman Edit';
    return view('backend.admin.pages.salesman_edit', compact('data'));
}

}
