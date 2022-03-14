@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <div class="modal-header">
            <h5 class="modal-title" id="modalDetailTitle">Details Buku</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table id="myTableDetail" class="table table-bordered table-hover table-striped display">
                <thead>
                    <tr>
                        <th>NIB</th>
                        <th>Picture</th>
                        <th>Judul</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $d)
                    <tr id="tr_{{$d->id}}" name="detailBuku">
                        <td>
                            {{ $d->buku->kode }}
                            <label for="a" name="idd" style="display:none">{{ $d->id }}</label>
                            <label for="b" name="idb" style="display:none">{{ $d->buku->id }}</label>
                        </td>
                        <td>
                            @if (empty($d->buku->gambar))
                                <!-- <div class="text-center"><i class="fas fa-user fa-5x"></i></div> -->
                                <img width="100px" src="{{ url('/data_file/book_cover.png') }}">
                            @else
                                <img width="100px" src="{{ url('/data_file/'.$d->buku->gambar) }}">
                            @endif
                        </td>
                        <td>{{ $d->buku->judul_buku }}</td>
                        <td name="harga">{{ $d->harga_sewa }}</td>
                        <td name="qty">{{ $d->qty }}</td>
                        <td name="subtotal"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>

        <script>

            $(document).ready( function () {
                $('#myTableDetail').DataTable({
                    "scrollX": true
                });

                calculate();
            });

            function calculate() {
                $('tr[name="detailBuku"]').each(function () {
                    var tr = $(this).closest('tr');
                    var harga = tr.find('td[name="harga"]').text();
                    var qty = tr.find('td[name="qty"]').text();
                    var total = harga * qty;
                    tr.find('td[name="subtotal"]').text(total);
                });
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