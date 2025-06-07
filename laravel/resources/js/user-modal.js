// resources/js/user-modal.js
export default function userFormModal() {
    return {
        open: false,
        formMode: "add",
        form: {
            id: "",
            nama: "",
            email: "",
            // password: "",
            date: "",
            address: "",
            nik: "",
            no_kk: "",
            role: "",
        },
        fields: [
            { id: "nama", label: "Nama", model: "nama", type: "text" },
            { id: "email", label: "Email", model: "email", type: "email" },
            // {
            //     id: "password",
            //     label: "Password",
            //     model: "password",
            //     type: "password",
            // },
            { id: "date", label: "Tanggal Lahir", model: "date", type: "date" },
            { id: "address", label: "Alamat", model: "address", type: "text" },
            {
                id: "nik",
                label: "Nomor Kartu Keluarga",
                model: "nik",
                type: "number",
            },
            {
                id: "no_kk",
                label: "Nomor Induk Keluarga",
                model: "no_kk",
                type: "number",
            },
            {
                id: "role",
                label: "Role Pengguna",
                model: "role",
                type: "select",
                options: [
                    {
                        value: "",
                        label: "Pilih Peran Pengguna",
                    },
                    { value: "karyawan", label: "Karyawan" },
                    { value: "admin", label: "Admin" },
                ],
            },
        ],

        openAdd() {
            this.formMode = "add";
            this.form = {
                id: "",
                nama: "",
                email: "",
                date: "",
                address: "",
                nik: "",
                no_kk: "",
                role: "", // WAJIB string kosong
            };
            console.log("Form role saat openAdd:", this.form.role); // 👈 Tambahkan ini
            this.open = false;
            this.$nextTick(() => {
                this.open = true;
            });
        },

        openEdit(data) {
            this.formMode = "edit";
            this.form = { ...data };
            this.open = true;
        },

        close() {
            this.open = false;
            this.form.role = ""; // reset ke kosong saat modal ditutup
        },

        submitForm() {
            if (this.form.role === "") {
                alert("Role Pengguna harus dipilih.");
                return;
            }
            let url =
                this.formMode === "add"
                    ? "/accounts"
                    : `/accounts/${this.form.id}`;
            let method = this.formMode === "add" ? "POST" : "POST";
            let formData = new FormData();
            formData.append(
                "_token",
                document.querySelector('meta[name="csrf-token"]').content,
            );
            if (this.formMode === "edit") formData.append("_method", "PUT");
            formData.append("name", this.form.nama);
            formData.append("email", this.form.email);
            // formData.append("password", this.form.password);
            formData.append("date_of_birth", this.form.date);
            formData.append("address", this.form.address);
            formData.append("nik", this.form.nik);
            formData.append("no_kk", this.form.no_kk);
            formData.append("role", this.form.role);

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    Accept: "application/json",
                },
            })
                .then(async (res) => {
                    if (res.ok) {
                        window.location.reload();
                    } else {
                        let data = await res.json();
                        let msg = "Gagal menyimpan data!";
                        if (data && data.errors) {
                            msg +=
                                "\n" +
                                Object.values(data.errors).flat().join("\n");
                        }
                        alert(msg);
                    }
                })
                .catch((err) => {
                    alert("Terjadi error jaringan atau server!");
                    console.error(err);
                });
        },
    };
}
