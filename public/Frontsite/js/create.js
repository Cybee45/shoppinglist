document.addEventListener('DOMContentLoaded', function () {
  const barangList = [];
  const barangFiles = [];

  function renderTable() {
    const tbody = document.querySelector('#barangListTable tbody');
    tbody.innerHTML = '';
    barangList.forEach((item, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${item.nama_barang}</td>
        <td>${item.jumlah}</td>
        <td>${item.harga}</td>
        <td>${item.kategori}</td>
        <td><button type="button" class="btn btn-danger btn-sm" data-index="${index}">Hapus</button></td>
      `;
      tbody.appendChild(row);
    });

    // Event hapus barang
    document.querySelectorAll('#barangListTable tbody button').forEach(button => {
      button.addEventListener('click', function () {
        const idx = parseInt(this.getAttribute('data-index'));
        barangList.splice(idx, 1);
        barangFiles.splice(idx, 1);
        renderTable();
      });
    });
  }

  document.getElementById('addBarangBtn').addEventListener('click', function () {
    const nama_barang = document.getElementById('nama_barang').value.trim();
    const jumlah = document.getElementById('jumlah').value.trim();
    const harga = document.getElementById('harga').value.trim();
    const kategori = document.getElementById('kategori').value;
    const imageInput = document.getElementById('image');

    if (!nama_barang || !jumlah || !harga) {
      alert('Nama, jumlah, dan harga harus diisi!');
      return;
    }

    barangList.push({ nama_barang, jumlah, harga, kategori });
    barangFiles.push(imageInput.files[0] || null);

    renderTable();

    // Reset input
    document.getElementById('nama_barang').value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('harga').value = '';
    document.getElementById('kategori').selectedIndex = 0;
    imageInput.value = '';
  });

  document.getElementById('listForm').addEventListener('submit', function (e) {
    console.log('[DEBUG] Form submit berhasil dipanggil!');
    e.preventDefault();

    if (barangList.length === 0) {
      alert('Tambah minimal satu barang!');
      return;
    }

    const form = e.target;
    const formData = new FormData(form);

    barangList.forEach((item, index) => {
      for (const key in item) {
        formData.append(`items[${index}][${key}]`, item[key]);
      }
      if (barangFiles[index]) {
        formData.append(`items[${index}][image]`, barangFiles[index]);
      }
    });

    fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: { 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value }
    }).then(res => {
      if (res.redirected) {
        window.location.href = res.url;
      } else {
        return res.text().then(html => {
          document.body.innerHTML = html;
        });
      }
    }).catch(() => alert('Gagal simpan data!'));
  });
});