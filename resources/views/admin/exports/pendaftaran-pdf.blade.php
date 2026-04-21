<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pendaftaran</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1E3A5F; }
        h1 { font-size: 20px; margin-bottom: 6px; }
        p { font-size: 12px; margin-top: 0; color: #64748B; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { font-size: 11px; padding: 8px; border-bottom: 1px solid #E2E8F0; text-align: left; }
        th { text-transform: uppercase; font-size: 9px; letter-spacing: 0.08em; color: #94A3B8; }
    </style>
</head>
<body>
    <h1>Data Pendaftaran</h1>
    <p>Kelola seluruh data pendaftaran mahasiswa baru.</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Gelombang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $row)
                <tr>
                    <td>{{ $row->no_pendaftaran ?? ('#PMB' . str_pad($row->id, 4, '0', STR_PAD_LEFT)) }}</td>
                    <td>{{ $row->user?->nama_lengkap ?? $row->nama_lengkap }}</td>
                    <td>{{ $row->user?->email ?? $row->email }}</td>
                    <td>{{ $row->prodi->nama_prodi }}</td>
                    <td>{{ $row->gelombang->nama_gelombang }}</td>
                    <td>{{ $row->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
