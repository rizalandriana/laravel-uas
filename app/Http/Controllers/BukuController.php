<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Untuk query builder:
use Illuminate\Support\Facades\DB;

use App\Models\buku;
use App\Models\pinjam_cart;

class BukuController extends Controller
{
    function left($str, $length)
    {
        return substr($str, 0, $length);
    }
    
    function right($str, $length){
        return substr($str, -$length);
    }

    function bukucode()
    {
        // Membuat Fungsi Kode dari Buku:
        $json = DB::table('buku')
                 ->select(DB::raw('RIGHT(MAX(kode), 4) AS lastCount'))
                 ->get();
        $lastCount = json_decode($json);
        $lastCount = $lastCount[0]->lastCount;
        $lastCount += 1;
        $lastCount = $this->right('0000' . $lastCount, 4);
        $mycode = 'B' . $lastCount;
        return $mycode;
    }

    public function index()
    {
        if (Auth::check())
        {
            $buku = buku::where('status', 'Y')->get();
            return view('buku.index', compact('buku'));
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
            $bukuRecycle = buku::where('status', 'N')->get();
            // return view('buku.recycle', ['bukuRecycle' => $bukuRecycle]);
            return view('buku.recycle', compact('bukuRecycle'));
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
            $kode = $this->bukucode();
            return view('buku.tambah', compact('kode'));
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
                buku::create([
                    'kode' => $request->kode,
                    'judul_buku' => $request->judul,
                    'harga_sewa' => $request->harga,
                    'stok' => $request->stok,
                    // 'gambar' => $request->photo,
                    // 'gambar' => $nama_file,
                    'pengarang' => $request->pengarang,
                    'penerbit' => $request->penerbit,
                    'tahun' => $request->tahun,
                    'tempat' => $request->tempat,
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

                buku::create([
                    'kode' => $request->kode,
                    'judul_buku' => $request->judul,
                    'harga_sewa' => $request->harga,
                    'stok' => $request->stok,
                    // 'gambar' => $request->photo,
                    'gambar' => $nama_file,
                    'pengarang' => $request->pengarang,
                    'penerbit' => $request->penerbit,
                    'tahun' => $request->tahun,
                    'tempat' => $request->tempat,
                    'status' => 'Y'
                ]);
            }
            return response()->json(['success'=>'Successfully added the book.']);
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
            $buku = buku::find($id);
            $folderPath = '/data_file';
            $filefoto = '';
            if ($buku->gambar == null || $buku->gambar == '') {
                $filefoto = '/' . 'book_cover.png';
            }
            else {
                $filefoto = '/' . $buku->gambar;
            }
            $fotosrc = $folderPath . $filefoto;
            return view('buku.edit', compact('buku', 'fotosrc'));
            // return response()->json([
            //     'data' => $buku
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

                buku::updateOrCreate(['id' => $id], ['kode' => $request->kode, 'judul_buku' => $request->judul, 'harga_sewa' => $request->harga, 'stok' => $request->stok, 'gambar' => $nama_file, 'pengarang' => $request->pengarang, 'penerbit' => $request->penerbit, 'tahun' => $request->tahun, 'tempat' => $request->tempat]);
            }
            else {
                buku::updateOrCreate(['id' => $id], ['kode' => $request->kode, 'judul_buku' => $request->judul, 'harga_sewa' => $request->harga, 'stok' => $request->stok, 'pengarang' => $request->pengarang, 'penerbit' => $request->penerbit, 'tahun' => $request->tahun, 'tempat' => $request->tempat]);
            }

            return response()->json(['success'=>'Successfully updated the book.']);
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
            $buku = buku::find($id);
            $buku->status = 'N';

            if ($buku->save())
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
            // DB::table("buku")->whereIn('id', explode(",", $ids))->delete();
            if (DB::table("buku")->whereIn('id', explode(",", $ids))->update(['status' => 'N']))
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
            $buku = buku::find($id);
            $buku->status = 'Y';
            $buku->save();
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
            if (DB::table("buku")->whereIn('id', explode(",", $ids))->update(['status' => 'Y']))
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
            $buku = buku::find($id);
            if ($buku->delete())
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
            if (DB::table("buku")->whereIn('id', explode(",", $ids))->delete())
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

    public function storecart(Request $request)
    {
        if (Auth::check())
        {
            $user = auth()->user()->id;
            $data = pinjam_cart::where('user_id', $user)->where('buku_id', $request->id)->count();
            $buku = buku::find($request->id);
            $stok = $buku->stok;
            if ($stok < 1) {
                return response()->json(['warning'=>"Out of stock"]);
            }
            else if ($data > 0) {
                return response()->json(['warning'=>"The Book has been added"]);
            }
            else {
                $cart = pinjam_cart::create([
                    'user_id' => $user,
                    'buku_id' => $request->id,
                    'qty' => 1
                ]);
                return response()->json(['success'=>"Successfully add The Book to Cart"]);
            }
        }
        else
        {
            return redirect('/login');
        }
    }
}