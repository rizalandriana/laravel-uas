<!DOCTYPE html>
<html>
<head>
	<title>Print Report Kas Perpustakaan</title>
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
                    <h5>Report Kas Perpustakaan</h5>
                </div>
                <div class="card-body">
                <div style="overflow:auto">
                    <table id="myTableKas" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Member</th>
                                <th>Tgl Pinjam</th>
                                <th>Total</th>
                                <th>Denda</th>
                                <th>Bayar</th>
                                <th>Kas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kembali as $k)
                            <tr id="tr_{{$k->id}}" name="kasData">
                                <td>
                                    {{ $k->pinjam->kode }}
                                    <label for="a" name="idp" style="display:none">{{ $k->pinjam_id }}</label>
                                    <label for="d" name="idk" style="display:none">{{ $k->id }}</label>
                                </td>
                                <td>
                                    <label for="b" name="kodeMember">{{ $k->pinjam->member->kode }}</label> - <label for="c" name="namaMember">{{ $k->pinjam->member->nama }}</label>
                                </td>
                                <td>{{ $k->pinjam->tgl }}</td>
                                <td>{{ $k->pinjam->total }}</td>
                                <td>{{ $k->denda }}</td>
                                <td name="bayar">{{ $k->bayar }}</td>
                                <td name="kas"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    </br>
                    <div class="text-left">
                        <h3><label><i class="fas fa-dollar-sign"></i> Total:&nbsp;</label><label id="totalKas"></label></h3>
                    </div>
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
                // $('#myTableKas').DataTable({
                //     // "scrollX": true
                // });

                calculate();
                window.print();
            });

            function calculate() {
                var kas = 0;
                $('tr[name="kasData"]').each(function () {
                    var tr = $(this).closest('tr');
                    var bayar = parseFloat(tr.find('td[name="bayar"]').text());
                    kas += bayar;
                    tr.find('td[name="kas"]').text(kas);
                });
                $('#totalKas').text(kas);
            };
        </script>
</body>
</html>