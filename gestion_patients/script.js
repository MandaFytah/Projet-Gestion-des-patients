function editPatient(patient) {
    document.getElementById('patient-id').value = patient.id;
    document.getElementById('nom').value = patient.nom;
    document.getElementById('prenom').value = patient.prenom;
    document.getElementById('date_naissance').value = patient.date_naissance;
    document.getElementById('adresse').value = patient.adresse;
    document.getElementById('telephone').value = patient.telephone;
    document.getElementById('email').value = patient.email;
}

function editConsultation(consultation) {
    document.getElementById('consultation-id').value = consultation.id;
    document.getElementById('patient_id').value = consultation.patient_id;
    document.getElementById('date_consultation').value = consultation.date_consultation;
    document.getElementById('notes').value = consultation.notes;
}

function showAddModal() {
    document.getElementById('addPatientModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function editPatient(patient) {
    document.getElementById('edit-patient-id').value = patient.id;
    document.getElementById('edit-nom').value = patient.nom;
    document.getElementById('edit-prenom').value = patient.prenom;
    document.getElementById('edit-date_naissance').value = patient.date_naissance;
    document.getElementById('edit-adresse').value = patient.adresse;
    document.getElementById('edit-telephone').value = patient.telephone;
    document.getElementById('edit-email').value = patient.email;
    document.getElementById('editPatientModal').style.display = 'block';
}

// Fermer les modals lorsque l'utilisateur clique en dehors d'elles
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        closeModal('addPatientModal');
        closeModal('editPatientModal');
    }
}
