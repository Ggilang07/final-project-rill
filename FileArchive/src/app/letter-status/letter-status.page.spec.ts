import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LetterStatusPage } from './letter-status.page';

describe('LetterStatusPage', () => {
  let component: LetterStatusPage;
  let fixture: ComponentFixture<LetterStatusPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(LetterStatusPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
