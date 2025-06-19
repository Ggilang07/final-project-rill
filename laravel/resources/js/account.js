// filepath: c:\laragon\www\final-project-rill\laravel\resources\js\account.js
window.deleteAccount = function (userId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Akun akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/accounts/${userId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    Accept: "application/json",
                },
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Akun berhasil dihapus.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal menghapus akun',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
            });
        }
    });
};
