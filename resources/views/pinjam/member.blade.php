@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <div class="modal-header">
            <h5 class="modal-title" id="modalMemberTitle">Select Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <div style="overflow:auto">
            <table id="myTableMember" class="table table-bordered table-hover table-striped display">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($member as $m)
                    <tr id="tr_{{$m->id}}">
                        <td>
                            @if (empty($m->foto))
                                <!-- <div class="text-center"><i class="fas fa-user fa-5x"></i></div> -->
                                <img width="80px" src="{{ url('/data_file/User_icon_BLACK-01.png') }}">
                            @else
                                <img width="80px" src="{{ url('/data_file/'.$m->foto) }}">
                            @endif
                        </td>
                        <td>
                            <label name="kodeMember">{{ $m->kode }}</label>
                            <label for="a" name="idm" style="display:none">{{ $m->id }}</label>
                        </td>
                        <td name="namaMember">{{ $m->nama }}</td>
                        <td>{{ $m->kategori->nama }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btnSelectMember"><i class="fas fa-check-circle"></i></button>
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
                $('#myTableMember').DataTable({
                    // "scrollX": true
                });
            } );
        </script>
    @else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif