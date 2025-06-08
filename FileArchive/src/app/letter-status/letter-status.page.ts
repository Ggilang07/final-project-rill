import { Component, OnInit } from '@angular/core';
import { AlertController, NavController } from '@ionic/angular';

@Component({
  standalone: false,
  selector: 'app-letter-status',
  templateUrl: './letter-status.page.html',
  styleUrls: ['./letter-status.page.scss'],
})
export class LetterStatusPage implements OnInit {

  searchTerm: string = '';
  
  requests = [
    {
      nomorSurat: "SKU/034/KSE/DNB/2025",
      tanggalSurat: "24 April 2025",
      jenisSurat: "Surat Izin Cuti",
      nama: "Gilang",
      status: "pending"
    },
    {
      nomorSurat: "SKU/035/KSE/DNB/2025",
      tanggalSurat: "25 April 2025",
      jenisSurat: "Surat Izin Cuti",
      nama: "Gilang",
      status: "approved"
    },
    {
      nomorSurat: "SKU/036/KSE/DNB/2025",
      tanggalSurat: "26 April 2025",
      jenisSurat: "Surat Izin Cuti",
      nama: "Gilang",
      status: "pending"
    },
    {
      nomorSurat: "SKU/037/KSE/DNB/2025",
      tanggalSurat: "27 April 2025",
      jenisSurat: "Surat Izin Cuti",
      nama: "Gilang",
      status: "rejected"
    },
    {
      nomorSurat: "SKU/038/KSE/DNB/2025",
      tanggalSurat: "28 April 2025",
      jenisSurat: "Surat Izin Cuti",
      nama: "Gilang",
      status: "pending"
    }
  ];

  constructor(
    private alertController: AlertController,
    private navCtrl: NavController
  ) { }

  ngOnInit() {
  }

  // Fungsi untuk filter data berdasarkan pencarian
  getFilteredRequests() {
    if (!this.searchTerm || this.searchTerm.trim() === '') {
      return this.requests;
    }

    const searchLower = this.searchTerm.toLowerCase();
    return this.requests.filter(request => 
      request.nomorSurat.toLowerCase().includes(searchLower) ||
      request.jenisSurat.toLowerCase().includes(searchLower) ||
      request.nama.toLowerCase().includes(searchLower) ||
      request.status.toLowerCase().includes(searchLower) ||
      request.tanggalSurat.toLowerCase().includes(searchLower)
    );
  }

  // Fungsi untuk handle event input pencarian
  filterRequests(event: any) {
    this.searchTerm = event.target.value;
  }

  // Fungsi untuk clear pencarian
  clearSearch() {
    this.searchTerm = '';
  }

  // Fungsi untuk mendapatkan ikon status
  getStatusIcon(status: string): string {
    switch(status) {
      case 'approved': 
        return 'checkmark-circle';
      case 'rejected': 
        return 'close-circle';
      case 'pending': 
        return 'time';
      default: 
        return 'time';
    }
  }

  // Fungsi untuk handle tombol buat surat
  async buatSurat() {
    const alert = await this.alertController.create({
      header: 'Buat Surat Baru',
      message: 'Pilih jenis surat yang ingin dibuat:',
      buttons: [
        {
          text: 'Surat Izin Cuti',
          handler: () => {
            this.navigateToForm('cuti');
          }
        },
        {
          text: 'Surat Izin Sakit',
          handler: () => {
            this.navigateToForm('sakit');
          }
        },
        {
          text: 'Surat Dinas',
          handler: () => {
            this.navigateToForm('dinas');
          }
        },
        {
          text: 'Batal',
          role: 'cancel'
        }
      ]
    });

    await alert.present();
  }

  // Fungsi untuk navigasi ke halaman form
  navigateToForm(jenisSurat: string) {
    // Navigasi ke halaman form sesuai jenis surat
    // Contoh: this.navCtrl.navigateForward('/form-surat/' + jenisSurat);
    console.log('Navigasi ke form:', jenisSurat);
    
    // Untuk demo, tampilkan alert
    this.showFormAlert(jenisSurat);
  }

  // Fungsi demo untuk menampilkan alert form
  async showFormAlert(jenisSurat: string) {
    const alert = await this.alertController.create({
      header: 'Form Surat',
      message: `Membuka form untuk ${jenisSurat}...`,
      buttons: ['OK']
    });

    await alert.present();
  }

  // Fungsi untuk handle klik pada row tabel (opsional)
  onRowClick(request: any) {
    console.log('Row clicked:', request);
    // Bisa digunakan untuk navigasi ke detail surat
  }
}