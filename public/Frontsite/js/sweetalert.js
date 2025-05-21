// Fungsi load script dinamis dengan Promise
function loadScript(src) {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = () => resolve();
        script.onerror = () => reject(new Error(`Failed to load script ${src}`));
        document.head.appendChild(script);
    });
}

(async function () {
    try {
        // Load SweetAlert2 dan Bootstrap JS secara berurutan
        await loadScript('https://cdn.jsdelivr.net/npm/sweetalert2@11');
        await loadScript('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', main);
        } else {
            main();
        }

        async function showAlerts() {
            if (typeof window.LOGIN_ERROR_MESSAGE !== 'undefined' && window.LOGIN_ERROR_MESSAGE) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: window.LOGIN_ERROR_MESSAGE,
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            }

            if (typeof window.LOGIN_SUCCESS_MESSAGE !== 'undefined' && window.LOGIN_SUCCESS_MESSAGE) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: window.LOGIN_SUCCESS_MESSAGE,
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            }

            if (typeof window.LOGIN_SUCCESS_ALERT !== 'undefined' && window.LOGIN_SUCCESS_ALERT) {
                if (document.body.classList.contains('login-page')) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        text: window.LOGIN_SUCCESS_ALERT,
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                }
            }

            if (typeof window.STANDARD_SUCCESS_MESSAGE !== 'undefined' && window.STANDARD_SUCCESS_MESSAGE) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: window.STANDARD_SUCCESS_MESSAGE,
                    timer: 2500,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            }
        }

        async function main() {
            await showAlerts();

            // Logout dengan SweetAlert konfirmasi
            const logoutBtn = document.getElementById('logout-btn');
            const logoutForm = document.getElementById('logout-form');

            if (logoutBtn && logoutForm) {
                logoutBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin logout?',
                        text: "Kamu akan keluar dari akun ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }

            // Konfirmasi simpan list (khusus tombol Simpan List, type="button")
            const listForm = document.getElementById('listForm');
            const simpanBtn = document.querySelector('button.btn-primary.btn-icon');

            if (listForm && simpanBtn) {
                simpanBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin menyimpan list?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, simpan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa',
                    }).then((result) => {
                        if (result.isConfirmed) {
                        listForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                        }
                    });
                });
            }

            // Konfirmasi untuk tombol Selesai dan Hapus di daftar belanja
            document.querySelectorAll('.btn-confirm').forEach(button => {
                button.addEventListener('click', function () {
                    const message = this.dataset.message || 'Apakah Anda yakin?';
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        }
    } catch (error) {
        console.error('Gagal load library:', error);
    }
})();