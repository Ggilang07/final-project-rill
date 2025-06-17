// filepath: c:\laragon\www\final-project-rill\laravel\resources\js\account.js
window.deleteAccount = function (userId) {
    if (confirm("Apakah Anda yakin ingin menghapus akun ini?")) {
        fetch(`/accounts/${userId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert("Gagal menghapus akun");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Terjadi kesalahan");
            });
    }
};
