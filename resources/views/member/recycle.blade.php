@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <div class="modal-header">
            <h5 class="modal-title" id="modalRecycleTitle">Member (Deleted)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <button id="btnRestore" type="button" class="btn btn-outline-primary" data-url="{{ url('/member/restoreAll') }}"><i class="fas fa-undo-alt"></i> Restore</button>
                <div class="btn-group float-right" role="group">
                    <button id="btnDelPermanentAll" type="button" class="btn btn-outline-danger" data-url="{{ url('/member/hapuspermanenAll') }}"><i class="fas fa-fire"></i> Permanently Delete</button>
                </div>
            </div>
            
            <br/>
            <br/>
            <div style="overflow:auto">
            <table id="myTableRecycle" class="table table-bordered table-hover table-striped display">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkBoxRecycleAll" class="custom-checkbox"></th>
                        <th>NIM</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Alamat</th>
                        <th>HP</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memberRecycle as $mr)
                    <tr id="tr_{{$mr->id}}">
                        <td>
                            <input type="checkbox" class="custom-checkbox cekboxRecycle" data-id="{{$mr->id}}">
                        </td>
                        <td>
                            {{ $mr->kode }}
                            <label for="a" name="idr" style="display:none">{{ $mr->id }}</label>
                        </td>
                        <td>
                            @if (empty($mr->foto))
                                <div class="text-center"><i class="fas fa-user fa-5x"></i></div>
                            @else
                                <img width="100px" src="{{ url('/data_file/'.$mr->foto) }}">
                            @endif
                        </td>
                        <td>{{ $mr->nama }}</td>
                        <td>{{ $mr->kategori->nama }}</td>
                        <td>{{ $mr->alamat }}</td>
                        <td>{{ $mr->hp }}</td>
                        <td>{{ $mr->email }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="/member/restore/{{ $mr->id }}" class="btn btn-outline-primary" onclick="toastrestore()"><i class="fas fa-undo-alt"></i></a>
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