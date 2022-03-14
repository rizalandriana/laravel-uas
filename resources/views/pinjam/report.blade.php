@extends('welcome')

@section('title', 'Report Peminjaman Buku')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Report Peminjaman Buku</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="text-left">
                                <label><i class="fas fa-list-ul"></i> Total:&nbsp;</label><label id="totalData">{{ $total }}</label>&nbsp;&nbsp;&nbsp;
                                <label><i class="fas fa-check"></i> Done:&nbsp;</label><label id="DoneData">{{ $done }}</label>&nbsp;&nbsp;&nbsp;
                                <label><i class="fas fa-hourglass-half"></i> Pending:&nbsp;</label><label id="PendingData">{{ $pending }}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <button class="btn btn-outline-secondary" onclick="window.open('/pinjam/cetakpdf');"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
                    </br>
                    {{ method_field('PUT') }}
                    <table id="myTablePinjam" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Member</th>
                                <th>Tgl Pinjam</th>
                                <th>Duedate</th>
                                <th>Total</th>
                                <th>Tgl Kembali</th>
                                <th>Denda</th>
                                <th>Bayar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjam as $p)
                            <tr id="tr_{{$p->id}}">
                                <td>
                                    {{ $p->kode }}
                                    <label for="a" name="idp" style="display:none">{{ $p->id }}</label>
                                    @if (empty($p->kembali->id))
                                    <label for="d" name="idk" style="display:none"></label>
                                    @else
                                    <label for="d" name="idk" style="display:none">{{ $p->kembali->id }}</label>
                                    @endif
                                </td>
                                <td>
                                    <label for="b" name="kodeMember">{{ $p->member->kode }}</label> - <label for="c" name="namaMember">{{ $p->member->nama }}</label>
                                </td>
                                <td>{{ $p->tgl }}</td>
                                <td>{{ $p->duedate }}</td>
                                <td>{{ $p->total }}</td>
                                @if (empty($p->kembali->id))
                                <td><span class="badge badge-pill badge-danger">Pending</span></td>
                                <td><span class="badge badge-pill badge-danger">No Data</span></td>
                                <td><span class="badge badge-pill badge-danger">No Data</span></td>
                                @else
                                <td>{{ $p->kembali->tgl }}</td>
                                <td>{{ $p->kembali->denda }}</td>
                                <td>{{ $p->kembali->bayar }}</td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btnViewDetail"><i class="fas fa-book-reader"></i></button>
                                        <button type="button" class="btn btn-outline-secondary btnAccept"><i class="fas fa-search"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('modal')
    <!-- Modal untuk Search Member -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="divDetail">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Search Buku -->
    <div class="modal fade" id="modalAccept" tabindex="-1" role="dialog" aria-labelledby="modalAcceptTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="divAccept">
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')

        <script>

            $(document).ready( function () {
                $('#myTablePinjam').DataTable({
                    "scrollX": true
                });
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                // timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            function toastsuccess() {
                Toast.fire({
                    icon: 'success',
                    title: 'Save data successfully'
                })
            };

            // $('td').click(function(event){
            //     event.preventDefault();
            //     var obj = $(this);
            //     viewdetail(obj);
            // });

            $('.btnViewDetail').click(function(event) {
                event.preventDefault();
                var obj = $(this);
                viewdetail(obj);
            });

            function viewdetail(obj) {
                // var row_index = $(this).parent().index();
                // var col_index = $(this).index();
                // var td_length = $('td').length;
                var tr = obj.closest('tr');
                var id = (tr.find('label[name="idp"]').text()).trim();
                var route = '/kembali/pinjamdetail/' + id;
                $('#divDetail').load(route);
                $('#modalDetail').modal('show');
            }

            $('.btnAccept').click(function(event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="idp"]').text()).trim();
                var route = '/pinjam/reportdetail/' + id;
                $('#divAccept').load(route);
                $('#modalAccept').modal('show');
            });

        </script>
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
@endif