@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8">
  <h2 class="mb-4 text-xl font-semibold">QR Scanner</h2>
  <div id="reader" class="w-full"></div>
  <div id="result" class="mt-4"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
  function onScanSuccess(decodedText) {
    document.getElementById('result').innerHTML = 'Terbaca: ' + decodedText;
    fetch(decodedText)
      .then(r => r.json())
      .then(data => {
        document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
      })
      .catch(() => {
        document.getElementById('result').innerHTML += '<div class="text-red-600">Gagal mengambil data.</div>';
      });
    html5QrcodeScanner.clear();
  }

  const html5QrcodeScanner = new Html5Qrcode('reader');
  const config = { fps: 10, qrbox: 250 };
  Html5Qrcode.getCameras()
    .then(cameras => {
      if (cameras && cameras.length) {
        html5QrcodeScanner.start(cameras[0].id, config, onScanSuccess);
      }
    })
    .catch(err => console.error(err));
</script>
@endpush
