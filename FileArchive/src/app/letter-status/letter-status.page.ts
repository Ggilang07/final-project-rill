import { Component, OnInit } from '@angular/core';
import { AlertController, NavController } from '@ionic/angular';
import { ApiService } from '../services/api.service';

@Component({
  standalone: false,
  selector: 'app-letter-status',
  templateUrl: './letter-status.page.html',
  styleUrls: ['./letter-status.page.scss'],
})
export class LetterStatusPage implements OnInit {
  requests: any[] = [];
  isLoading = false;
  searchTerm: string = '';

  constructor(
    private alertController: AlertController,
    private navCtrl: NavController,
    private apiService: ApiService,
  ) {}

  ngOnInit() {
    this.loadStatus();
  }

  loadStatus() {
    this.isLoading = true;
    this.apiService.getStatusLetter().subscribe(
      (response) => {
        this.requests = response.data ?? response;
        this.isLoading = false;
      },
      (error) => {
        console.error('Error fetching letters:', error);
        this.isLoading = false;
      },
    );
  }

  loadLink() {
    this.isLoading = true;
    this.apiService.getLinkNValidator().subscribe(
      (response) => {
        // Jika response berupa { data: [...] } (Laravel resource), gunakan response.data
        this.requests = response.data ?? response;
        this.isLoading = false;
      },
      (error) => {
        console.error('Error fetching letters:', error);
        this.isLoading = false;
      },
    );
  }

  // Fungsi untuk filter data berdasarkan pencarian
  getFilteredRequests() {
    if (!this.searchTerm || this.searchTerm.trim() === '') {
      return this.requests;
    }

    const searchLower = this.searchTerm.toLowerCase();
    return this.requests.filter(
      (request) =>
        (request.nomorSurat || request.letter_number || '')
          .toLowerCase()
          .includes(searchLower) ||
        (request.jenisSurat || request.category || '')
          .toLowerCase()
          .includes(searchLower) ||
        (request.nama || request.user?.name || '')
          .toLowerCase()
          .includes(searchLower) ||
        (request.status || '').toLowerCase().includes(searchLower) ||
        (request.tanggalSurat || request.created_at || '')
          .toLowerCase()
          .includes(searchLower),
    );
  }

  formatCategory(category: string): string {
    return category
      .split('_')
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
      .join(' ');
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
    switch (status) {
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
          },
        },
        {
          text: 'Surat Izin Sakit',
          handler: () => {
            this.navigateToForm('sakit');
          },
        },
        {
          text: 'Surat Dinas',
          handler: () => {
            this.navigateToForm('dinas');
          },
        },
        {
          text: 'Batal',
          role: 'cancel',
        },
      ],
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
      buttons: ['OK'],
    });

    await alert.present();
  }

  // Fungsi untuk handle klik pada row tabel (opsional)
  onRowClick(request: any) {
    console.log('Row clicked:', request);
    // Bisa digunakan untuk navigasi ke detail surat
  }

  goToDetail(request: any) {
    // Misal menggunakan letter_number sebagai parameter, bisa diganti sesuai kebutuhan
    this.navCtrl.navigateForward(['/letter-status/detail-status', request.letter_number]);
  }
}
