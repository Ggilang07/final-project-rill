import { Component, OnInit } from '@angular/core';
import { AlertController, NavController } from '@ionic/angular'; // Hapus IonViewWillEnter
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
  selectedFilter: string = 'terbaru';
  sortOrder: 'terbaru' | 'terlama' = 'terbaru';
  statusFilters: string[] = []; // ['pending', 'approved', ...]
  showFilterPopover = false;

  constructor(
    private alertController: AlertController,
    private navCtrl: NavController,
    private apiService: ApiService,
  ) {}

  ionViewWillEnter() {
    this.loadData(); // fungsi untuk ambil data surat
  }

  ngOnInit() {
    this.loadData();
  }

  loadData() {
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

  // Fungsi untuk filter data berdasarkan pencarian
  getFilteredRequests() {
    let filtered = this.requests;

    // Filter pencarian
    if (this.searchTerm && this.searchTerm.trim() !== '') {
      const searchLower = this.searchTerm.toLowerCase();
      filtered = filtered.filter((request) => {
        const statusLabel = this.getStatusLabel(
          request.status || '',
        ).toLowerCase();
        const bulanLabel = this.getMonthIndo(
          request.tanggalDibuat || request.created_at || '',
        ).toLowerCase();
        return (
          (request.tanggalDibuat || request.created_at || '')
            .toLowerCase()
            .includes(searchLower) ||
          (request.jenisSurat || request.category || '')
            .toLowerCase()
            .includes(searchLower) ||
          (request.nomorsurat || request.letter_number || '')
            .toLowerCase()
            .includes(searchLower) ||
          (request.status || '').toLowerCase().includes(searchLower) ||
          statusLabel.includes(searchLower) || // cari label status indo
          bulanLabel.includes(searchLower) || // cari nama bulan indo
          (request.tanggalSurat || request.created_at || '')
            .toLowerCase()
            .includes(searchLower)
        );
      });
    }

    // Filter status (bisa multi)
    if (this.statusFilters.length > 0) {
      filtered = filtered.filter((request) =>
        this.statusFilters.includes((request.status || '').toLowerCase()),
      );
    }

    // Urutkan
    if (this.sortOrder === 'terbaru') {
      filtered = filtered
        .slice()
        .sort(
          (a, b) =>
            new Date(b.created_at).getTime() - new Date(a.created_at).getTime(),
        );
    } else if (this.sortOrder === 'terlama') {
      filtered = filtered
        .slice()
        .sort(
          (a, b) =>
            new Date(a.created_at).getTime() - new Date(b.created_at).getTime(),
        );
    }

    return filtered;
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

  getStatusLabel(status: string): string {
    switch ((status || '').toLowerCase()) {
      case 'pending':
        return 'Menunggu';
      case 'approved':
        return 'Disetujui';
      case 'rejected':
        return 'Ditolak';
      case 'cancelled':
        return 'Dibatalkan';
      default:
        return status;
    }
  }

  getMonthIndo(dateStr: string): string {
    if (!dateStr) return '';
    const bulanIndo = [
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember',
    ];
    const date = new Date(dateStr);
    return bulanIndo[date.getMonth()];
  }

  // Fungsi untuk handle klik pada row tabel (opsional)
  onRowClick(request: any) {
    console.log('Row clicked:', request);
    // Bisa digunakan untuk navigasi ke detail surat
  }

  goToDetail(request: any) {
    this.navCtrl.navigateForward([
      '/letter-status/detail-status',
      request.request_id, // <-- gunakan request_id
    ]);
  }

  // Fungsi untuk toggle status filter
  toggleStatusFilter(status: string) {
    if (this.statusFilters.includes(status)) {
      this.statusFilters = this.statusFilters.filter((s) => s !== status);
    } else {
      this.statusFilters = [...this.statusFilters, status];
    }
  }

  // Fungsi untuk apply filter (bisa kosong jika hanya trigger change detection)
  applyFilter() {}

  resetFilter() {
    this.sortOrder = 'terbaru';
    this.statusFilters = [];
    this.applyFilter();
  }
}
