<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use \stdClass;
use \Response;

use App\Models\kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = kategori::where('status', 'Y')->get();
        $kategoriRecycle = kategori::where('status', 'N')->get();
        // $kategoriEdit = kategori::where('id', '>', 0)->firstOrFail();
        // if (!$kategoriEdit)
        // {
        //     abort(404);
        // }
        // return view('kategori.kategori', ['kategori' => $kategori, 'kategoriRecycle' => $kategoriRecycle, 'kategoriEdit' => $kategoriEdit]);
        return view('kategori.kategori', compact('kategori', 'kategoriRecycle'));
    }

    public function recycle()
    {
    	// $kategoriRecycle = kategori::where('status', 'N')->get();
    	// return view('kategori.kategori', ['kategoriRecycle' => $kategoriRecycle]);
    }

    public function tambah()
    {
        if (Auth::check())
        {
            return view('kategori.kategori_tambah');
        }
        else
        {
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' => 'required|min:2|max:20'
    	]);
 
        kategori::create([
            'nama' => $request->nama,
            'status' => 'Y'
    	]);
 
        return redirect('/member/category');
        // return redirect()->back()->with(['status' => 'Kategori Member added successfully.']);
        
        // $validator = Validator::make($request->all(), [
        //     'nama' => 'required|min:2|max:20'
        // ]);

        // if ($validator->fails())
        // {
        //     // return redirect('/member/category')
        //     //             ->withErrors($validator)
        //     //             ->withInput();
        //     // OR:
        //     // return $validator->validate();
            
        //     // return '<script>alert("Salah!");</script>';

        //     $json = new stdClass();
        //     $json->success = false;
        //     $json->errors = $validator->errors();
        // }
        // else
        // {
        //     // Store the kategori post...
        //     kategori::create([
        //         'nama' => $request->nama,
        //         'status' => 'Y'
    	//     ]);
 
        //     // return redirect('/member/category');

        //     $json = new stdClass();
        //     $json->success = true;
        // }

        // return Response::json($json);
    }

    public function edit($id)
    {
        if (Auth::check())
        {
            $kategori = kategori::find($id);

            return view('kategori.kategori_editt', ['kategoriEdit' => $kategori]);
            // return response()->json([
            //     'data' => $kategori
            // ]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
	        'nama' => 'required|min:2|max:20'
        ]);

        // $kategori = kategori::find($id);
        // $kategori->nama = $request->nama;
        // $kategori->save();

        kategori::updateOrCreate(['id' => $id], ['nama' => $request->nama]);
        // return response()->json([ 'success' => true ]);
        return redirect('/member/category');
    }

    public function delete($id)
    {
        if (Auth::check())
        {
            $kategori = kategori::find($id);
            $kategori->status = 'N';
            // $kategori->save();
            // $kategori->delete();
            // return redirect('/member/category');

            if ($kategori->save())
            {
                return response()->json("The data is moved to the recycle bin");
            }
            else
            {
                return response()->json("Failed to move data to the recycle bin");
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function deleteAll(Request $request)
    {
        if (Auth::check())
        {
            $ids = $request->ids;
            // DB::table("kategori")->whereIn('id', explode(",", $ids))->delete();
            if (DB::table("kategori")->whereIn('id', explode(",", $ids))->update(['status' => 'N']))
            {
                return response()->json(['success'=>"The selected data is moved to the recycle bin"]);
            }
            else
            {
                return response()->json(['error'=>"Error to process!"]);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function restore($id)
    {
        if (Auth::check())
        {
            $kategori = kategori::find($id);
            $kategori->status = 'Y';
            $kategori->save();
            return redirect()->back();
        }
        else
        {
            return redirect('/login');
        }
    }

    public function restoreAll(Request $request)
    {
        if (Auth::check())
        {
            $ids = $request->ids;
            if (DB::table("kategori")->whereIn('id', explode(",", $ids))->update(['status' => 'Y']))
            {
                return response()->json(['success'=>"The selected data is successfully restored"]);
            }
            else
            {
                return response()->json(['error'=>"Error to process!"]);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function hapuspermanen($id)
    {
        if (Auth::check())
        {
            $kategori = kategori::find($id);
            if ($kategori->delete())
            {
                // return redirect()->back();
                return response()->json("The data has been permanently deleted");
                // return Json("The data has been permanently deleted");
            }
            else
            {
                return response()->json("Failed to delete data");
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function hapuspermanenAll(Request $request)
    {
        if (Auth::check())
        {
            $ids = $request->ids;
            if (DB::table("kategori")->whereIn('id', explode(",", $ids))->delete())
            {
                return response()->json(['success'=>"The selected data is deleted"]);
            }
            else
            {
                return response()->json(['error'=>"Error to process!"]);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

}