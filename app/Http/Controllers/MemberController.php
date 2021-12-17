<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Untuk query builder:
use Illuminate\Support\Facades\DB;

use App\Models\member;

class MemberController extends Controller
{
    function left($str, $length)
    {
        return substr($str, 0, $length);
    }
    
    function right($str, $length){
        return substr($str, -$length);
    }

    function membercode()
    {
        // Membuat Fungsi Kode dari Member:
        $json = DB::table('member')
                 ->select(DB::raw('RIGHT(MAX(kode), 4) AS lastCount'))
                 ->get();
        $lastCount = json_decode($json);
        $lastCount = $lastCount[0]->lastCount;
        $lastCount += 1;
        $lastCount = $this->right('0000' . $lastCount, 4);
        $mycode = 'M' . $lastCount;
        return $mycode;
    }

    public function mynote()
    {
        // Example to Custom Query Builder:
        // $users = DB::table('users')
        //          ->select(DB::raw('count(*) as user_count, status'))
        //          ->where('status', '<>', 1)
        //          ->groupBy('status')
        //          ->get();

        // Example to Obtain Value on JSON example data {'title': 'value'}
        // $json = '{"countryId":"84","productId":"1","status":"0","opId":"134"}';
        // $json = json_decode($json, true); // json_decode() will return an object or array if second value it's true // ini digunakan jika format json langsung seperti ini {'test': 'aku'} bukan seperti ini [{'test': 'aku'}]
        // return $json['countryId'];
        // result is 84

        // Example to Obtain Value on JSON example data [{'title': 'value'}]
        // $json = DB::table('member')
        //          ->select(DB::raw('RIGHT(MAX(kode), 4) AS lastCount'))
        //          ->get();
        // $lastCount = json_decode($json);
        // $lastCount = $lastCount[0]->lastCount;

        // $aku = DB::statement('SELECT CURRENT_TIMESTAMP');
        // return response()->json($aku);
        // return var_dump($aku);
        // result is boolean! Mungkin harus di CAST ke String di Database/Server
    }

    public function index()
    {
        if (Auth::check())
        {
            $member = member::where('status', 'Y')->get();
            // $member = member::find(1);
            return view('member.index', compact('member'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function recycle()
    {
        if (Auth::check())
        {
            $memberRecycle = member::where('status', 'N')->get();
            // return view('member.recycle', ['memberRecycle' => $memberRecycle]);
            return view('member.recycle', compact('memberRecycle'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function tambah()
    {
        if (Auth::check())
        {
            $kode = $this->membercode();
            $kategori = DB::table('kategori')
                ->select(DB::raw('id, nama'))
                ->where('status', 'Y')
                ->get();
            return view('member.tambah', compact('kode', 'kategori'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
        if (Auth::check())
        {
            if ($request->image == null) {
                member::create([
                    'kode' => $request->kode,
                    'kategori_id' => $request->kategori,
                    'nama' => $request->nama,
                    // 'foto' => $request->photo,
                    // 'foto' => $nama_file,
                    'alamat' => $request->alamat,
                    'hp' => $request->hp,
                    'email' => $request->email,
                    'status' => 'Y'
                ]);
            }
            else {
                $folderPath = public_path('data_file/');

                $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                // $file = $folderPath . uniqid() . '.png';
                $nama_file = $request->kode . "_" . time() . '.png';
                $file = $folderPath . $nama_file;

                file_put_contents($file, $image_base64);

                member::create([
                    'kode' => $request->kode,
                    'kategori_id' => $request->kategori,
                    'nama' => $request->nama,
                    // 'foto' => $request->photo,
                    'foto' => $nama_file,
                    'alamat' => $request->alamat,
                    'hp' => $request->hp,
                    'email' => $request->email,
                    'status' => 'Y'
                ]);
                // return redirect()->back();
                // return redirect()->back()->with(['status' => 'Member added successfully.']);
            }

            return response()->json(['success'=>'Successfully added member.']);

            // // menyimpan data file yang diupload ke variabel $file
		    // $file = $request->file('photo');
 
            // // // nama file
            // // echo 'File Name: '.$file->getClientOriginalName();
            // // echo '<br>';

            // // // ekstensi file
            // // echo 'File Extension: '.$file->getClientOriginalExtension();
            // // echo '<br>';

            // // // real path
            // // echo 'File Real Path: '.$file->getRealPath();
            // // echo '<br>';

            // // // ukuran file
            // // echo 'File Size: '.$file->getSize();
            // // echo '<br>';

            // // // tipe mime
            // // echo 'File Mime Type: '.$file->getMimeType();

            // $nama_file = time()."_".$file->getClientOriginalName();

            // // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';

            // // upload file
            // $file->move($tujuan_upload,$nama_file);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function edit($id)
    {
        if (Auth::check())
        {
            $member = member::find($id);
            $kategori = DB::table('kategori')
                ->select(DB::raw('id, nama'))
                ->where('status', 'Y')
                ->get();

            $folderPath = '/data_file';
            $filefoto = '';
            if ($member->foto == null || $member->foto == '') {
                $filefoto = '/' . 'User_icon_BLACK-01.png';
            }
            else {
                $filefoto = '/' . $member->foto;
            }
            $fotosrc = $folderPath . $filefoto;
            return view('member.edit', compact('member', 'kategori', 'fotosrc'));
            // return response()->json([
            //     'data' => $member
            // ]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function update($id, Request $request)
    {
        if (Auth::check())
        {
            if ($request->photo_changed == 'true') {

                $nama_file = null;

                if ($request->image == null) {
                    $nama_file = null;
                }
                else {
                    $folderPath = public_path('data_file/');

                    $image_parts = explode(";base64,", $request->image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $nama_file = $request->kode . "_" . time() . '.png';
                    $file = $folderPath . $nama_file;

                    file_put_contents($file, $image_base64);
                }

                member::updateOrCreate(['id' => $id], ['kode' => $request->kode, 'kategori_id' => $request->kategori, 'nama' => $request->nama, 'foto' => $nama_file, 'alamat' => $request->alamat, 'hp' => $request->hp, 'email' => $request->email]);
            }
            else {
                member::updateOrCreate(['id' => $id], ['kode' => $request->kode, 'kategori_id' => $request->kategori, 'nama' => $request->nama, 'alamat' => $request->alamat, 'hp' => $request->hp, 'email' => $request->email]);
            }

            return response()->json(['success'=>'Successfully updated member.']);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function delete($id)
    {
        if (Auth::check())
        {
            $member = member::find($id);
            $member->status = 'N';

            if ($member->save())
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
            // DB::table("member")->whereIn('id', explode(",", $ids))->delete();
            if (DB::table("member")->whereIn('id', explode(",", $ids))->update(['status' => 'N']))
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
            $member = member::find($id);
            $member->status = 'Y';
            $member->save();
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
            if (DB::table("member")->whereIn('id', explode(",", $ids))->update(['status' => 'Y']))
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
            $member = member::find($id);
            if ($member->delete())
            {
                return response()->json("The data has been permanently deleted");
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
            if (DB::table("member")->whereIn('id', explode(",", $ids))->delete())
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

    // https://www.nicesnippets.com/blog/laravel-crop-image-before-upload-using-cropper-js
    public function crop()
    {
        return view('cropper.index');
    }

    public function cropupload(Request $request)
    {
        $folderPath = public_path('data_file/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.png';

        file_put_contents($file, $image_base64);

        return response()->json(['success'=>'success']);
    }
}