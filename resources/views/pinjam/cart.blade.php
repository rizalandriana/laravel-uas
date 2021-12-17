@if (Route::has('login'))
    @auth
        <div style="overflow:auto">
                    <table id="myTable" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkBoxAll" class="custom-checkbox"></th>
                                <th>NIB</th>
                                <th>Judul</th>
                                <th>Harga</th>
                                <th>Stock</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $c)
                            <tr id="tr_{{$c->id}}" name="cartData">
                                <td>
                                    <input type="checkbox" class="custom-checkbox cekbox" data-id="{{$c->id}}">
                                </td>
                                <td>
                                    {{ $c->buku->kode }}
                                    <label for="a" name="idCart" style="display:none">{{ $c->id }}</label>
                                    <label for="b" name="idBuku" style="display:none">{{ $c->buku_id }}</label>
                                </td>
                                <td>
                                    {{ $c->buku->judul_buku }}
                                </td>
                                <td name="harga">{{ $c->buku->harga_sewa }}</td>
                                <td name="stok">{{ $c->buku->stok }}</td>
                                <td>
                                    <input type="number" class="qty" value="{{ $c->qty }}" style="width:50px" min=1 max=10>
                                </td>
                                <td name="subtotal"></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-danger btnDelCart"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        </div>
        <script>
            $('.qty').on("change paste keyup", function() {
                qtychanged = true;
            });
        </script>

@else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif