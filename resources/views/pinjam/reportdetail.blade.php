@if (Route::has('login'))
    @auth

        <!-- Konten -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalAcceptTitle">Accept Data ({{ $pinjam[0]->kode }})</h5><span class="badge badge-pill badge-success myBadge">Done</span>
                <label name="idpp" style="display:none">{{ $pinjam[0]->id }}</label>
                <label name="dontaccept" style="display:none">{{ $dontaccept }}</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-row">
                        <div class="form-group col-md-3" style="overflow:auto">
                            @if (empty($pinjam[0]->member->foto))
                            <img width="160px" class="rounded" src="{{ url('/data_file/User_icon_BLACK-01.png') }}">
                            @else
                            <img width="160px" class="rounded" src="{{ url('/data_file/'.$pinjam[0]->member->foto) }}">
                            @endif
                        </div>
                        <div class="form-group col-md-5">
                            <label>NIM</label>
                            <input class="form-control" type="text" placeholder="NIM" readonly value="{{ $pinjam[0]->member->kode }}">
                            <label name="idm" style="display:none">{{ $pinjam[0]->member->id }}</label>
                            </br>
                            <label>Nama</label>
                            <input class="form-control" type="text" placeholder="Nama" readonly value="{{ $pinjam[0]->member->nama }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tanggal Pinjam</label>
                            <input class="form-control" type="text" placeholder="Tgl Pinjam" readonly value="{{ $pinjam[0]->tgl }}">
                            </br>
                            <label>Duedate</label>
                            <input type="text" class="form-control" placeholder="Duedate" value="{{ $pinjam[0]->duedate }}" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12" style="overflow:auto">
                            <table id="myTableAcceptDetail" class="table table-bordered table-hover table-striped display">
                                <thead>
                                    <tr>
                                        <th>NIB</th>
                                        <th>Judul</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pinjam[0]->pinjam_detail as $d)
                                    <tr id="tr_{{$d->id}}" name="detailAcceptBuku">
                                        <td>
                                            {{ $d->buku->kode }}
                                            <label for="a" name="idd" style="display:none">{{ $d->id }}</label>
                                            <label for="b" name="idb" style="display:none">{{ $d->buku->id }}</label>
                                        </td>
                                        <td>{{ $d->buku->judul_buku }}</td>
                                        <td name="harga">{{ $d->harga_sewa }}</td>
                                        <td name="qty">{{ $d->qty }}</td>
                                        <td name="subtotal"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Total</label>
                            <input id="txtTotal" type="text" class="form-control" placeholder="Total" value="{{ $pinjam[0]->total }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Denda</label>
                            @if (empty($pinjam[0]->kembali->denda))
                                <input id="txtDenda" type="text" class="form-control" placeholder="Denda" value="0" readonly>
                            @else
                                <input id="txtDenda" type="text" class="form-control" placeholder="Denda" value="{{ $pinjam[0]->kembali->denda }}" readonly>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtBayar">Bayar</label>
                            @if (empty($pinjam[0]->kembali->bayar))
                                <input type="text" class="form-control" id="txtBayar" placeholder="Bayar" value="0" required readonly>
                            @else
                                <input type="text" class="form-control" id="txtBayar" placeholder="Bayar" value="{{ $pinjam[0]->kembali->bayar }}" required readonly>
                            @endif
                        </div>
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>

<script>
            $(document).ready( function () {
                validateaccept();
                calculate();
            });

            function calculate() {
                $('tr[name="detailAcceptBuku"]').each(function () {
                    var tr = $(this).closest('tr');
                    var harga = parseFloat(tr.find('td[name="harga"]').text());
                    var qty = parseInt(tr.find('td[name="qty"]').text());
                    var total = harga * qty;
                    tr.find('td[name="subtotal"]').text(total);
                });
            };

            function validateaccept() {
                var dntacc = parseInt($('label[name="dontaccept"]').text());
                if (dntacc == 1) {
                    // Munculin badge dan hide tombol accept
                    // $('#btnSaveAccept').prop('disabled', true);
                }
                else {
                    // Hide badge dan munculin tombol accept
                    $('.myBadge').hide();
                }
            }
</script>

    @else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif