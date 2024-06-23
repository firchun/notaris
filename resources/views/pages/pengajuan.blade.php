@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container pb-1">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>

        </div>
    </section>

    <section class="container pt-2">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @elseif (Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $item)
                    <ul>
                        <li>{{ $item }}</li>
                    </ul>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">petunjuk pengisian!</h4>
            <ol>
                <li>Pastikan anda mengisi dengan data yang benar</li>
                <li>Isilah dengan teliti dan jangan sampai ada data yang terlewat </li>
                <li>Pastikan bahwa dokumen anda telah lengkap dan siap di upload</li>
                <li>Dokumen di upload dalam bentuk PDF</li>
            </ol>
        </div>
        <form action="{{ route('pengajuan_layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow shadow-sm border border-warning">
                <div class="card-header bg-warning ">
                    <h5>Formulir Pengajuan {{ $layanan->nama_layanan }} </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <label class="text-danger">Silahkan foto wajah dan KTP dengan jelas</label><br>
                        <img src="{{ asset('img/tutor.png') }}" style="height: 300px"><br>
                        <video id="video" width="400" height="300" autoplay></video><br>
                        <div id="resultContainer" class="text-center" style="display: none;">
                            <img id="capturedImage" width="400" height="300" class="mb-3"><br>
                            <button id="resetButton" class="btn btn-danger">Ambil Foto Ulang</button>
                        </div>
                        <button id="captureButton" class="btn btn-primary">Ambil Foto</button>
                        <input type="file" name="capture" class="form-control" id="captureInput" style="display: none;">
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="id_layanan" value="{{ $layanan->id }}">
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="nama_pemohon">
                    </div>
                    @foreach (App\Models\FormulirLayanan::where('id_layanan', $layanan->id)->get() as $form)
                        <input type="hidden" name="id_formulir_layanan[]" value="{{ $form->id }}">
                        <div class="mb-3">
                            <label>{{ $form->nama_formulir }} <span class="text-danger">*</span></label>
                            <input type="text" name="isi_formulir[]" class="form-control" required>
                        </div>
                    @endforeach
                    <h5>Upload Kelengkapan Berkas</h5>
                    @foreach (App\Models\BerkasLayanan::where('id_layanan', $layanan->id)->get() as $berkas)
                        <input type="hidden" name="id_berkas_layanan[]" value="{{ $berkas->id }}">
                        <div class="mb-3">
                            <label>Berkas : {{ $berkas->nama_berkas }} <span class="text-danger">* (PDF)(Ukuran berkas
                                    maksimal
                                    10MB)</span></label>
                            <input type="file" name="berkas[]" class="form-control" accept=".pdf" required>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Ajukan Sekarang</button>
                </div>
            </div>
        </form>
    </section>
    <script>
        const video = document.getElementById('video');
        const captureButton = document.getElementById('captureButton');
        const captureInput = document.getElementById('captureInput');
        const resetButton = document.getElementById('resetButton');
        const resultContainer = document.getElementById('resultContainer');
        const capturedImage = document.getElementById('capturedImage');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                alert('Harap aktifkan/ijinkan kamera pada browser', error);
            });


        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Ambil gambar dari canvas sebagai data URL
            const imageDataURL = canvas.toDataURL('image/png');

            // Simpan data URL gambar ke dalam variabel
            const blob = dataURLToBlob(imageDataURL);
            const file = new File([blob], "capture.png", {
                type: "image/png"
            });

            // Tampilkan hasil capture dan tombol reset
            capturedImage.src = imageDataURL;
            resultContainer.style.display = 'block';
            resetButton.style.display = 'inline-block';
            // captureInput.style.display = 'none'; // Sembunyikan elemen captureInput
            video.style.display = 'none';
            captureButton.style.display = 'none';
            // Buat FileList dengan satu file
            const files = [file];

            // Buat FileList
            const fileList = new DataTransfer();
            for (let i = 0; i < files.length; i++) {
                fileList.items.add(files[i]);
            }

            // Atur nilai files dari input file
            captureInput.files = fileList.files;

            // Simpan data gambar ke dalam variabel atau FormData
            const formData = new FormData();
            formData.append('capture', file); // Atur nama file sesuai dengan atribut name pada input file

            // Kirim formData bersama data lainnya ketika formulir disubmit
        });

        resetButton.addEventListener('click', () => {
            // Kosongkan hasil capture
            capturedImage.src = '';
            resultContainer.style.display = 'none';
            video.style.display = 'inline-block';
            captureButton.style.display = 'inline-block';
            // captureInput.style.display = 'none';
        });

        function dataURLToBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const contentType = parts[0].split(':')[1];
            const raw = window.atob(parts[1]);
            const rawLength = raw.length;
            const uInt8Array = new Uint8Array(rawLength);

            for (let i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {
                type: contentType
            });
        }
    </script>
@endsection
