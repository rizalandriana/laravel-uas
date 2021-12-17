<!-- Gak dipake jika pake modal! -->

<!-- @extends('welcome')

@section('title', 'Edit Kategori Member') -->

<!-- @if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <strong>EDIT DATA</strong> - Kategori Member
                </div>
                <div class="card-body">
                    <a href="/member/category" class="btn btn-outline-danger">Kembali</a>
                    <br/>
                    <br/>
 
                    <form method="post" action="/member/category/update/{{ $kategoriEdit->id }}">
 
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
 
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Kategori .." value="{{ $kategoriEdit->nama }}">
 
                            @if($errors->has('nama'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('nama')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <input type="submit" class="btn btn-outline-success" value="Simpan">
                        </div>
 
                    </form>
 
                </div>
            </div>
        </div>
    @endsection

    @else
        @section('konten')
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        @endsection
        @if (Route::has('register'))

        @endif
    @endauth
@endif -->