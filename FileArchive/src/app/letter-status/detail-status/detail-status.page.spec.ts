import { ComponentFixture, TestBed } from '@angular/core/testing';
import { DetailStatusPage } from './detail-status.page';

describe('DetailStatusPage', () => {
  let component: DetailStatusPage;
  let fixture: ComponentFixture<DetailStatusPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailStatusPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
