import "./bootstrap";
import "./account";
import './chart-dashboard';
import userFormModal from './user-modal';
import modalValidate from "./details-modal";

// Register the modal function globally
window.modalValidate = modalValidate;
window.userFormModal = userFormModal;