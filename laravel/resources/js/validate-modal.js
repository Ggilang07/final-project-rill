export default function modalValidate() {
    return {
        isOpen: false,
        requestId: null,
        linkSurat: "",
        error: "",

        open(id) {
            this.isOpen = true;
            this.requestId = id;
            this.linkSurat = "";
            this.error = "";
        },

        close() {
            this.isOpen = false;
            this.requestId = null;
            this.linkSurat = "";
            this.error = "";
        },

        async submit(status) {
            if (status === "approved" && !this.linkSurat) {
                this.error = "Link surat harus diisi terlebih dahulu.";
                return;
            }

            try {
                const response = await fetch("/validate-request", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        request_id: this.requestId,
                        status: status,
                        link_pdf: this.linkSurat,
                    }),
                });

                const result = await response.json();

                if (result.success) {
                    window.location.reload();
                } else {
                    this.error = result.message || "Terjadi kesalahan.";
                }
            } catch (e) {
                this.error = "Gagal mengirim data ke server.";
            }
        },
    };
}
