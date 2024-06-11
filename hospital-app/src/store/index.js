import { createStore } from 'vuex'; 

export default createStore({
  state: {
    patients: [
      { id: 1, name: 'John Doe', age: 30, diagnosis: 'Flu' },
      { id: 2, name: 'Jane Doe', age: 25, diagnosis: 'Cold' },
    ],
    doctors: [
      { id: 1, name: 'Dr. Smith', specialty: 'Cardiology', hospital: 'Hospital A' },
      { id: 2, name: 'Dr. Johnson', specialty: 'Neurology', hospital: 'Hospital B' },
    ],
    appointments: [
      { id: 1, patient: 1, doctor: 1, date: '2022-01-01', time: '10:00 AM' },
      { id: 2, patient: 2, doctor: 2, date: '2022-01-02', time: '11:00 AM' },
    ],
  },
  mutations: {
    addAppointment(state, appointment) {
      state.appointments.push(appointment);
    },
    updateAppointment(state, payload) {
      state.appointments.splice(payload.index, 1, payload.appointment);
    },
    cancelAppointment(state, appointmentId) {
      state.appointments = state.appointments.filter(a => a.id !== appointmentId);
    },
    addPatient(state, patient) {
      state.patients.push(patient);
    },
    deletePatient(state, patientId) {
      state.patients = state.patients.filter(p => p.id !== patientId);
    },
    addDoctor(state, doctor) {
      state.doctors.push(doctor);
    },
    deleteDoctor(state, doctorId) {
      state.doctors = state.doctors.filter(d => d.id !== doctorId);
    },
  },
  actions: {
    // If needed
  },
  getters: {
    // If needed
  }
});

