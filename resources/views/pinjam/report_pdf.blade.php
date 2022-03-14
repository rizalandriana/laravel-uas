<!DOCTYPE html>
<html>
<head>
	<title>Print Report Peminjaman Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
</head>
<body>
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Report Peminjaman Buku</h5>
                </div>
                <div class="card-body">
                <div class="form-row">
                        <div class="col-md-12">
                            <div class="text-left">
                                <label><i class="fas fa-list-ul"></i> Total:&nbsp;</label><label id="totalData">{{ $total }}</label>&nbsp;&nbsp;&nbsp;
                                <label><i class="fas fa-check"></i> Done:&nbsp;</label><label id="DoneData">{{ $done }}</label>&nbsp;&nbsp;&nbsp;
                                <label><i class="fas fa-hourglass-half"></i> Pending:&nbsp;</label><label id="PendingData">{{ $pending }}</label>
                            </div>
                        </div>
                    </div>
                <div style="overflow:auto">
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
                                <td>-</td>
                                <td>0</td>
                                <td>0</td>
                                @else
                                <td>{{ $p->kembali->tgl }}</td>
                                <td>{{ $p->kembali->denda }}</td>
                                <td>{{ $p->kembali->bayar }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- style overflow auto -->
                </div>
            </div>
        </div>

        <script src="/js/jquery.js"></script>
        <script src="/js/popper.js"></script> 
        <script src="/js/bootstrap.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        @yield('script')
        <script>
            $(document).ready( function () {
                // $('#myTablePinjam').DataTable({
                //     // "scrollX": true
                // });
                
                window.print();
            });
        </script>
</body>
</html>