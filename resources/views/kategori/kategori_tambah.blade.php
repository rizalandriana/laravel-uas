@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <form id="kategoriTambah" method="post" action="/member/category/store" onsubmit="toastsuccess()">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahTitle">Tambah Data - Kategori Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Kategori .." value="{{ old('nama') }}" required maxlength="20" minlength="3" autofocus>
                        @if($errors->has('nama'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('nama')}}
                            </div>
                            <script>
                                alert("{{ $errors->first('nama')}}");
                            </script>
                        @endif
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </form>
    @else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif