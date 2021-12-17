<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Untuk query builder:
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\kembali;
use App\Models\pinjam;
use App\Models\pinjam_detail;
use App\Models\member;
use App\Models\buku;

use PDF;

class KembaliController extends Controller
{
    function left($str, $length)
    {
        return substr($str, 0, $length);
    }
    
    function right($str, $length){
        return substr($str, -$length);
    }

    public function index()
    {
        if (Auth::check())
        {
            // query="SELECT a.id, a.kode, b.kode, b.nama, a.tgl, a.duedate, a.total, c.id id_kembali, c.tgl tgl_kembali, c.denda, c.bayar FROM pinjam a INNER JOIN member b ON a.member_id = b.id LEFT JOIN kembali c ON a.id = c.pinjam_id"
            // $pinjam = DB::table('pinjam')
            // ->select('pinjam.id AS id_pinjam', 'pinjam.kode AS kode_pinjam', 'member.kode AS kode_member', 'member.nama AS nama_member', 'pinjam.tgl AS tgl_pinjam', 'pinjam.duedate', 'pinjam.total', 'kembali.id AS id_kembali', 'kembali.tgl AS tgl_kembali', 'kembali.denda', 'kembali.bayar')
            // ->join('member', 'pinjam.member_id', '=', 'member.id')
            // ->leftjoin('kembali', 'pinjam.id', '=', 'kembali.pinjam_id')
            // ->get();
            $pinjam = pinjam::get();
            return view('kembali.index', compact('pinjam'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function pinjamdetail($id)
    {
        if (Auth::check())
        {
            $detail = pinjam_detail::where('pinjam_id', $id)->get();
            return view('kembali.pinjamdetail', compact('detail'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function accept($id)
    {
        if (Auth::check())
        {
            $pinjam = pinjam::where('id', $id)->get();

            $currdate = Carbon::now();
            $duedate = Carbon::parse($pinjam[0]->duedate);
            $selisih = $duedate->diffInDays($currdate, false);
            $denda = 0;
            if ($selisih > 30) {
                $denda = 60000;
            }
            else if ($selisih > 20 && $selisih <= 30) {
                $denda = 40000;
            }
            else if ($selisih > 10 && $selisih <= 20) {
                $denda = 20000;
            }
            else if ($selisih > 5 && $selisih <= 10) {
                $denda = 10000;
            }
            else if ($selisih > 0 && $selisih <= 5) {
                $denda = 5000;
            }
            else {
                $denda = 0;
            }

            $dontaccept = 0;
            if (empty($pinjam[0]->kembali)) {
                $dontaccept = 0;
            }
            else {
                $dontaccept = 1;
            }

            // $buku = $pinjam[0]->pinjam_detail;
            return view('kembali.accept', compact('pinjam', 'denda', 'dontaccept'));
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
            $user = auth()->user()->id;
            $tgl = Carbon::parse(now())->format('Y-m-d');
            kembali::create([
                'pinjam_id' => $request->id,
                'tgl' => $tgl,
                'denda' => $request->denda,
                'bayar' => $request->bayar,
                'user_id' => $user
            ]);

            $detail = pinjam_detail::where('pinjam_id', $request->id)->get();
            foreach ($detail as $d) {
                $buku = buku::find($d->buku_id);
                $stok = $buku->stok;
                $stok += $d->qty;
                buku::updateOrCreate(['id' => $d->buku_id], ['stok' => $stok]);
            }

            return response()->json(['success'=>"Successfully received the book"]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function kas()
    {
        if (Auth::check())
        {
            $kembali = kembali::get();
            // $countdata = $kembali->count();

            return view('kembali.kas', compact('kembali'));
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
            $kembali = kembali::get();

            // PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // $pdf = PDF::loadview('kembali\kas_pdf', compact('kembali'));
            // return $pdf->download('Report_Kas_Perpustakaan.pdf');
            // return $pdf->stream();
            return view('kembali.kas_pdf', compact('kembali'));
        }
        else
        {
            return redirect('/login');
        }
    }
}