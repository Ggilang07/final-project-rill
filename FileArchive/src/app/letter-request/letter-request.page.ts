import { Component, OnInit } from '@angular/core';

@Component({
  standalone: false, 
  selector: 'app-letter-request',
  templateUrl: './letter-request.page.html',
  styleUrls: ['./letter-request.page.scss'],
})
export class LetterRequestPage implements OnInit {
  isInformasiOpen = true;
  constructor() { }

  ngOnInit() {
  }
   toggleInformasi() {
    this.isInformasiOpen = !this.isInformasiOpen;
  }
  
}
