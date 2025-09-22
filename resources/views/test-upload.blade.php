<!DOCTYPE html>
<html>

<head>
  <title>Test Upload Gambar</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <h1>Test Upload Gambar Motor</h1>

  <form action="{{ route('owner.motors.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
      <label>Nama Motor:</label>
      <input type="text" name="nama_motor" value="Honda Beat Test" required>
    </div>

    <div>
      <label>Merk:</label>
      <select name="merk" required>
        <option value="Honda">Honda</option>
      </select>
    </div>

    <div>
      <label>Model:</label>
      <input type="text" name="model" value="Beat Street" required>
    </div>

    <div>
      <label>Tahun:</label>
      <select name="tahun" required>
        <option value="2023">2023</option>
      </select>
    </div>

    <div>
      <label>Plat Nomor:</label>
      <input type="text" name="plat_nomor" value="B 1234 TEST" required>
    </div>

    <div>
      <label>Kapasitas Mesin:</label>
      <select name="kapasitas_mesin" required>
        <option value="125">125 CC</option>
      </select>
    </div>

    <div>
      <label>Harga per Hari:</label>
      <input type="text" name="harga_per_hari" value="75000" required>
    </div>

    <div>
      <label>Deskripsi:</label>
      <textarea name="deskripsi" required>Motor test untuk debugging upload gambar</textarea>
    </div>

    <div>
      <label>Foto Motor:</label>
      <input type="file" name="foto_motor" accept="image/*" required>
    </div>

    <button type="submit">Submit Test</button>
  </form>

  @if($errors->any())
  <div style="color: red;">
    <h3>Errors:</h3>
    <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(session('success'))
  <div style="color: green;">
    <h3>Success:</h3>
    <p>{{ session('success') }}</p>
  </div>
  @endif
</body>

</html>