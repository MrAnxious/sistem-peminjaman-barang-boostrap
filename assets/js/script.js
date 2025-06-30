// Fungsi pencarian barang
function searchItems() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let cards = document.getElementsByClassName('barang-card');

    Array.from(cards).forEach(card => {
        let title = card.getElementsByClassName('card-title')[0].innerText.toLowerCase();
        let desc = card.getElementsByClassName('card-text')[0].innerText.toLowerCase();
        
        if (title.includes(input) || desc.includes(input)) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
}

// Validasi form peminjaman
function validatePinjam(form) {
    let tanggal_pinjam = new Date(form.tanggal_pinjam.value);
    let tanggal_kembali = new Date(form.tanggal_kembali.value);
    let today = new Date();
    
    if (tanggal_pinjam < today) {
        alert('Tanggal pinjam tidak boleh kurang dari hari ini!');
        return false;
    }
    
    if (tanggal_kembali <= tanggal_pinjam) {
        alert('Tanggal kembali harus lebih besar dari tanggal pinjam!');
        return false;
    }
    
    return true;
}

// Preview gambar sebelum upload
function previewImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Sweet Alert untuk konfirmasi
function confirmDelete(url) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
    return false;
}
