@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <div class="modal-header">
            <h5 class="modal-title" id="modalBukuTitle">Select Buku</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <div style="overflow:auto">
            <table id="myTableBuku" class="table table-bordered table-hover table-striped display">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>NIB</th>
                        <th>Judul</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $b)
                    <tr id="tr_{{$b->id}}" name="tr_buku_{{$b->id}}">
                        <td>
                            @if (empty($b->gambar))
                                <img width="80px" src="{{ url('/data_file/book_cover.png') }}">
                            @else
                                <img width="80px" src="{{ url('/data_file/'.$b->gambar) }}">
                            @endif
                        </td>
                        <td>
                            <label name="kodeBuku">{{ $b->kode }}</label>
                            <label for="a" name="idb" style="display:none">{{ $b->id }}</label>
                        </td>
                        <td name="judulBuku">{{ $b->judul_buku }}</td>
                        <td>{{ $b->harga_sewa }}</td>
                        <td><label name="stokBuku">{{ $b->stok }}</label></td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btnSelectBuku"><i class="fas fa-check-circle"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div> <!-- body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>

        <script>
            $(document).ready( function () {
                $('#myTableBuku').DataTable({
                    // "scrollX": true
                    "bPaginate": false,
                    "bInfo": false
                });

                hideBuku();
            } );

            function hideBuku() {
                var id_buku_cart = [];
                var i;
                $('label[name="idBuku"]').each(function() {  
                    id_buku_cart.push(($(this).text()).trim());
                });

                for (i = 0; i < id_buku_cart.length; i++) {
                    $('tr[name="tr_buku_'+id_buku_cart[i]+'"]').hide();
                }
            };

        </script>
    @else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif