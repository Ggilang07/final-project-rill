// resources/js/user-modal.js
export default function userFormModal() {
    return {
        open: false,
        formMode: "add",
        form: {
            id: "",
            nama: "",
            email: "",
            password: "",
            date: "",
            address: "",
            nik: "",
            no_kk: "",
            role: "",
        },
        fields: [
            { id: "nama", label: "Nama", model: "nama", type: "text" },
            { id: "email", label: "Email", model: "email", type: "email" },
            {
                id: "password",
                label: "Password",
                model: "password",
                type: "password",
            },
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
                options: ["Karyawan", "Admin"],
            },
        ],

        openAdd() {
            this.formMode = "add";
            this.form = {
                id: "",
                nama: "",
                email: "",
                password: "",
                date: "",
                address: "",
                nik: "",
                no_kk: "",
                role: "",
            };
            this.open = true;
        },

        openEdit(data) {
            this.formMode = "edit";
            this.form = { ...data };
            this.open = true;
        },

        close() {
            this.open = false;
        },

        submitForm() {
            alert(
                `${this.formMode === "add" ? "Menambahkan" : "Mengedit"} akun: ${this.form.nama}`,
            );
            this.close();
        },
    };
}
