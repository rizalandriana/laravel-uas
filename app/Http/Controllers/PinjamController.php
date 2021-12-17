<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Untuk query builder:
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\pinjam;
use App\Models\pinjam_cart;
use App\Models\pinjam_detail;
use App\Models\member;
use App\Models\buku;

class PinjamController extends Controller
{

    function left($str, $length)
    {
        return substr($str, 0, $length);
    }
    
    function right($str, $length){
        return substr($str, -$length);
    }

    function pinjamcode()
    {
        $date = Carbon::parse(now())->format('ym');
        $lastCount = DB::table('pinjam')
                 ->select(DB::raw('RIGHT(MAX(kode), 4) AS lastCount'))
                 ->get();
        $lastCount = json_decode($lastCount);
        $lastCount = $lastCount[0]->lastCount;
        $lastCount += 1;
        $lastCount = $this->right('0000' . $lastCount, 4);
        $mycode = 'P'.$date.'-'.$lastCount;
        return $mycode;
    }

    public function countcart()
    {
        if (Auth::check())
        {
            $user = auth()->user()->id;
            $countcart = pinjam_cart::where('user_id', $user)->count();
            return response()->json(['countcart'=>$countcart]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function index()
    {
        if (Auth::check())
        {
            $pcode = $this->pinjamcode();
            return view('pinjam.index', compact('pcode'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function loadcart()
    {
        if (Auth::check())
        {
            // $user = Auth::user()->id;
            $user = auth()->user()->id;
            // $cart = pinjam_cart::where('user_id', $user)->where('id', '>', $request->id)->get();
            // $cart = DB::table('pinjam_cart')
            // ->select('pinjam_cart.id', 'pinjam_cart.buku_id', 'buku.kode', 'buku.judul_buku', 'buku.harga_sewa', 'buku.stok', 'pinjam_cart.qty')
            // ->where('pinjam_cart.id', '>', $request->id)
            // ->where('pinjam_cart.user_id', $user)
            // ->join('buku', 'buku.id', '=', 'pinjam_cart.buku_id')->get();
            $cart = pinjam_cart::where('user_id', $user)->get();
            return view('pinjam.cart', compact('cart'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function member()
    {
        if (Auth::check())
        {
            $member = member::where('status', 'Y')->get();
            return view('pinjam.member', compact('member'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function buku()
    {
        if (Auth::check())
        {
            // $ids = $request->ids;
            $buku = buku::where('status', 'Y')->get();
            // $buku = DB::table("buku")->whereNotIn('id', explode(",", $ids))->where('status', 'Y')->get();
            // $buku = buku::whereNotIn('id', explode(",", $ids))->where('status', 'Y')->get();
            // return response()->json(['success'=>"Please Select The Book!"]);
            return view('pinjam.buku', compact('buku'));
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
            $data = pinjam_cart::create([
                'user_id' => $user,
                'buku_id' => $request->id,
                'qty' => $request->qty
            ]);
            
            // $cart = DB::table('pinjam_cart')
            // ->select('pinjam_cart.id', 'pinjam_cart.buku_id', 'buku.kode', 'buku.judul_buku', 'buku.harga_sewa', 'buku.stok', 'pinjam_cart.qty')
            // ->where('pinjam_cart.id', '=', $data->id)
            // ->join('buku', 'buku.id', '=', 'pinjam_cart.buku_id')->get();
            // return $cart;
            return response()->json(['success'=>"Successfully added The Book"]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function updatecart($id, Request $request)
    {
        if (Auth::check())
        {
            $user = auth()->user()->id;
            pinjam_cart::updateOrCreate(['id' => $id], ['user_id' => $user, 'buku_id' => $request->buku_id, 'qty' => $request->qty]);

            return response()->json(['success'=>'Successfully updated the book.']);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function deletecart($id)
    {
        if (Auth::check())
        {
            $cart = pinjam_cart::find($id);
            if ($cart->delete())
            {
                return response()->json(['success' => 'Item has been deleted']);
            }
            else
            {
                return response()->json(['error' => 'Failed to delete data']);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function deletecartall(Request $request)
    {
        if (Auth::check())
        {
            $ids = $request->ids;
            if (DB::table("pinjam_cart")->whereIn('id', explode(",", $ids))->delete())
            {
                return response()->json(['success'=>"The selected cart is deleted"]);
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

    public function storepinjam(Request $request)
    {
        if (Auth::check())
        {
            $user = auth()->user()->id;
            $tgl = Carbon::parse(now())->format('Y-m-d');
            $duedate = Carbon::parse(now()->addDays(7))->format('Y-m-d');
            $pinjam = pinjam::create([
                'kode' => $request->kode,
                'member_id' => $request->member_id,
                'tgl' => $tgl,
                'duedate' => $duedate,
                'total' => $request->total,
                'user_id' => $user
            ]);

            return response()->json(['success'=>"Successfully submit head pinjam buku", 'pinjam_id'=>$pinjam->id]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function storepinjamdetails(Request $request)
    {
        if (Auth::check())
        {
            $user = auth()->user()->id;

            $pinjam_detail = pinjam_detail::create([
                'pinjam_id' => $request->pinjam_id,
                'buku_id' => $request->buku_id,
                'harga_sewa' => $request->harga,
                'qty' => $request->qty
            ]);

            $buku = buku::find($request->buku_id);
            $stok = $buku->stok;
            $stok -= $request->qty;
            buku::updateOrCreate(['id' => $request->buku_id], ['stok' => $stok]);

            $cart = pinjam_cart::where('user_id', $user)->where('buku_id', $request->buku_id)->delete();

            return response()->json(['success'=>"Successfully submit detail pinjam buku"]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function report()
    {
        if (Auth::check())
        {
            $pending = 0;
            $pinjam = pinjam::get();
            $total = $pinjam->count();
            foreach ($pinjam as $p) {
                if (empty($p->kembali)) {
                    $pending += 1;
                }
            }
            $done = $total - $pending;
            return view('pinjam.report', compact('pinjam', 'total', 'pending', 'done'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function reportdetail($id)
    {
        if (Auth::check())
        {
            $pinjam = pinjam::where('id', $id)->get();

            $dontaccept = 0;
            if (empty($pinjam[0]->kembali)) {
                $dontaccept = 0;
            }
            else {
                $dontaccept = 1;
            }

            return view('pinjam.reportdetail', compact('pinjam', 'dontaccept'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function cetakpdf()
    {
        if (Auth::check())
        {
            $pending = 0;
            $pinjam = pinjam::get();
            $total = $pinjam->count();
            foreach ($pinjam as $p) {
                if (empty($p->kembali)) {
                    $pending += 1;
                }
            }
            $done = $total - $pending;
            return view('pinjam.report_pdf', compact('pinjam', 'total', 'pending', 'done'));
        }
        else
        {
            return redirect('/login');
        }
    }
}