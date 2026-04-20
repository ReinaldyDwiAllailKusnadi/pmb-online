<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; color: #1f2a37; margin: 0; }
        .card { border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; }
        .header { background: #1b2f52; color: #fff; padding: 24px; display: flex; justify-content: space-between; align-items: center; }
        .header-title { display: flex; gap: 16px; align-items: center; }
        .cap-box { width: 48px; height: 48px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #1b2f52; font-weight: bold; }
        .header h4 { margin: 0; font-size: 16px; letter-spacing: 1px; text-transform: uppercase; }
        .header p { margin: 4px 0 0; font-size: 10px; color: rgba(255,255,255,0.7); }
        .reg { text-align: right; }
        .reg span { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #f2b200; font-weight: bold; }
        .reg strong { display: block; font-size: 18px; font-family: 'DejaVu Sans Mono', monospace; }
        .body { padding: 32px; }
        .row { display: flex; gap: 24px; }
        .photo { width: 150px; height: 210px; border: 2px dashed #cbd5f5; border-radius: 6px; position: relative; overflow: hidden; background: #f8fafc; }
        .photo img { width: 100%; height: 100%; object-fit: cover; }
        .photo-label { position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.5); color: #fff; font-size: 8px; padding: 3px 6px; border-radius: 4px; }
        .details { flex: 1; display: flex; flex-direction: column; gap: 16px; }
        .field { border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; }
        .field label { display: block; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; color: #94a3b8; font-weight: bold; }
        .field span { display: block; font-size: 14px; font-weight: bold; color: #1f2a37; }
        .field-grid { display: flex; gap: 16px; }
        .footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 28px; }
        .qr-box { width: 90px; height: 90px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #334155; }
        .qr-text { max-width: 200px; font-size: 9px; color: #94a3b8; margin-top: 8px; line-height: 1.4; }
        .sign { text-align: center; }
        .sign-date { font-size: 9px; color: #64748b; margin-bottom: 36px; }
        .sign-line { width: 140px; height: 60px; border-bottom: 1px solid #cbd5f5; margin: 0 auto 8px; position: relative; }
        .sign-line span { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-family: 'Times New Roman', serif; font-size: 22px; color: rgba(27,47,82,0.1); transform: rotate(-6deg); font-style: italic; }
        .sign-name { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #1b2f52; }
        .bottom { display: flex; justify-content: space-between; padding: 12px 24px; font-size: 8px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; color: #94a3b8; background: #f8fafc; border-top: 1px solid #eef2f7; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="header-title">
                <div class="cap-box">🎓</div>
                <div>
                    <h4>Kartu Tanda Peserta</h4>
                    <p>Penerimaan Mahasiswa Baru TA 2024/2025</p>
                </div>
            </div>
            <div class="reg">
                <span>No. Pendaftaran</span>
                <strong>{{ $student->no_pendaftaran }}</strong>
            </div>
        </div>

        <div class="body">
            <div class="row">
                <div class="photo">
                    <img src="{{ $student->foto_url }}" alt="Student">
                    <div class="photo-label">Pas Foto 3x4</div>
                </div>

                <div class="details">
                    <div class="field">
                        <label>Nama Lengkap</label>
                        <span>{{ $student->nama_lengkap }}</span>
                    </div>
                    <div class="field">
                        <label>Program Studi Pilihan</label>
                        <span>{{ $student->program_studi }}</span>
                    </div>
                    <div class="field-grid">
                        <div class="field" style="flex:1;">
                            <label>Asal Sekolah</label>
                            <span>{{ $student->asal_sekolah }}</span>
                        </div>
                        <div class="field" style="flex:1;">
                            <label>Lokasi Ujian</label>
                            <span>{{ $student->lokasi_ujian }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div>
                    <div class="qr-box">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1f2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <path d="M14 14h3v3h-3z"></path>
                            <path d="M19 14h2v2h-2z"></path>
                            <path d="M14 19h2v2h-2z"></path>
                            <path d="M19 19h2v2h-2z"></path>
                        </svg>
                    </div>
                    <div class="qr-text">Scan kode di atas untuk memverifikasi keaslian dokumen secara online melalui portal resmi kami.</div>
                </div>
                <div class="sign">
                    <div class="sign-date">Jakarta, 15 Juli 2024</div>
                    <div class="sign-line"><span>Panitia PMB</span></div>
                    <div class="sign-name">Panitia Admisi Akademi PMB</div>
                </div>
            </div>
        </div>

        <div class="bottom">
            <span>Dokumen Sah & Berlaku Selama Masa Pendaftaran</span>
            <span>Halaman 1 dari 1</span>
        </div>
    </div>
</body>
</html>
