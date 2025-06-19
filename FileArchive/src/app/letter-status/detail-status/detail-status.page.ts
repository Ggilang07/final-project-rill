import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ApiService } from '../../services/api.service';

@Component({
  standalone: false,
  selector: 'app-detail-status',
  templateUrl: './detail-status.page.html',
  styleUrls: ['./detail-status.page.scss'],
})
export class DetailStatusPage implements OnInit {
  // Interface untuk data detail status
  detailStatus: {
    nomorSurat: string;
    tanggalSurat: string;
    tanggalDibuat: string;
    jenisSurat: string;
    alasan: string;
    status: 'Pending' | 'Disetujui' | 'Ditolak' | string;
    menungguPemohon: string;
    karyawan: string;
    divalidasiOleh: string;
  } = {
    nomorSurat: '',
    tanggalSurat: '',
    tanggalDibuat: '',
    jenisSurat: '',
    alasan: '',
    status: 'Pending',
    menungguPemohon: '',
    karyawan: '',
    divalidasiOleh: '',
  };

  isLoading = true;

  constructor(
    private route: ActivatedRoute,
    private apiService: ApiService
  ) {}

  ngOnInit() {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.apiService.getLetterDetail(id).subscribe(
        (data) => {
          // Jika respons API Anda membungkus data di dalam properti "data", gunakan data.data
          const detail = data.data ?? data;
          this.detailStatus = {
            nomorSurat: detail.letter_number || detail.nomorSurat || '-',
            tanggalSurat: detail.letter_date || detail.tanggalSurat || '-',
            tanggalDibuat: detail.created_at || '-',
            jenisSurat: detail.category ? this.formatCategory(detail.category) : '-',
            alasan: detail.reason || detail.alasan || '-',
            status: this.mapStatus(detail.status),
            menungguPemohon: detail.menungguPemohon || '-',
            karyawan: detail.user?.name || detail.karyawan || '-',
            divalidasiOleh: detail.validated_by || detail.divalidasiOleh || '-',
          };
          this.isLoading = false;
        },
        (err) => {
          this.isLoading = false;
        }
      );
    }
  }

  formatCategory(category: string): string {
    return category
      .split('_')
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
      .join(' ');
  }

  mapStatus(status: string): string {
    switch (status) {
      case 'approved':
        return 'Disetujui';
      case 'pending':
        return 'Pending';
      case 'rejected':
        return 'Ditolak';
      default:
        return status || '-';
    }
  }

  /**
   * Fungsi pembantu untuk mendapatkan gaya badge status berdasarkan nilai status.
   * Menggunakan kelas Tailwind CSS secara langsung untuk konsistensi gaya.
   * @param status String status ('Disetujui', 'Pending', 'Ditolak').
   * @returns Kelas Tailwind CSS untuk badge status.
   */
  getStatusBadge(status: string): string {
    switch (status) {
      case 'Disetujui':
        return 'bg-green-100 text-green-800';
      case 'Pending':
        return 'bg-yellow-100 text-yellow-800';
      case 'Ditolak':
        return 'bg-red-100 text-red-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  }
}