@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <div class="modal-header">
            <h5 class="modal-title" id="modalRecycleTitle">Buku (Deleted)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <button id="btnRestore" type="button" class="btn btn-outline-primary" data-url="{{ url('/buku/restoreAll') }}"><i class="fas fa-undo-alt"></i> Restore</button>
                <div class="btn-group float-right" role="group">
                    <button id="btnDelPermanentAll" type="button" class="btn btn-outline-danger" data-url="{{ url('/buku/hapuspermanenAll') }}"><i class="fas fa-fire"></i> Permanently Delete</button>
                </div>
            </div>
            
            <br/>
            <br/>
            <div style="overflow:auto">
            <table id="myTableRecycle" class="table table-bordered table-hover table-striped display">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkBoxRecycleAll" class="custom-checkbox"></th>
                        <th>NIB</th>
                        <th>Picture</th>
                        <th>Judul</th>
                        <th>Tahun</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tempat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukuRecycle as $br)
                    <tr id="tr_{{$br->id}}">
                        <td>
                            <input type="checkbox" class="custom-checkbox cekboxRecycle" data-id="{{$br->id}}">
                        </td>
                        <td>
                            {{ $br->kode }}
                            <label for="a" name="idr" style="display:none">{{ $br->id }}</label>
                        </td>
                        <td>
                            @if (empty($br->gambar))
                                <!-- <div class="text-center"><i class="fas fa-user fa-5x"></i></div> -->
                                <img width="100px" src="{{ url('/data_file/book_cover.png') }}">
                            @else
                                <img width="100px" src="{{ url('/data_file/'.$br->gambar) }}">
                            @endif
                        </td>
                        <td>{{ $br->judul_buku }}</td>
                        <td>{{ $br->tahun }}</td>
                        <td>{{ $br->pengarang }}</td>
                        <td>{{ $br->penerbit }}</td>
                        <td>{{ $br->tempat }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="/buku/restore/{{ $br->id }}" class="btn btn-outline-primary" onclick="toastrestore()"><i class="fas fa-undo-alt"></i></a>
                                <button type="button" class="btn btn-outline-danger btnHapus"><i class="fas fa-fire"></i></button>
                            </div>
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
                $('#myTableRecycle').DataTable({
                    "scrollX": true
                });
            } );

            $('#checkBoxRecycleAll').click(function () {
                if ($(this).is(":checked")) {
                    $(".cekboxRecycle").prop("checked", true)
                }
                else {
                    $(".cekboxRecycle").prop("checked", false)
                }
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