window.confirmLogout = function (e) {
    Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Anda akan keluar dari aplikasi.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}