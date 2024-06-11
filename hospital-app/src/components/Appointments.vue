<template>
    <div class="content">
      <h1>Appointment Management</h1>
      <form @submit.prevent="addAppointment">
        <label for="patient">Patient:</label>
        <select id="patient" v-model="newAppointment.patient">
          <option v-for="patient in patients" :key="patient.id" :value="patient.id">
            {{ patient.name }}
          </option>
        </select><br><br>
        <label for="doctor">Doctor:</label>
        <select id="doctor" v-model="newAppointment.doctor">
          <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
            {{ doctor.name }}
          </option>
        </select><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" v-model="newAppointment.date"><br><br>
        <label for="time">Time:</label>
        <input type="time" id="time" v-model="newAppointment.time"><br><br>
        <input type="submit" value="Add Appointment">
      </form>
      <table>
        <tr>
          <th>Patient</th>
          <th>Doctor</th>
          <th>Date</th>
          <th>Time</th>
          <th>Actions</th>
        </tr>
        <tr v-for="appointment in appointments" :key="appointment.id">
          <td>{{ getPatientName(appointment.patient) }}</td>
          <td>{{ getDoctorName(appointment.doctor) }}</td>
          <td>{{ appointment.date }}</td>
          <td>{{ appointment.time }}</td>
          <td>
            <button @click="editAppointment(appointment)">Edit</button>
            <button @click="deleteAppointment(appointment)">Delete</button>
          </td>
        </tr>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        patients: [
          { id: 1, name: 'John Doe' },
          { id: 2, name: 'Jane Doe' },
        ],
        doctors: [
          { id: 1, name: 'Dr. Smith' },
          { id: 2, name: 'Dr. Johnson' },
        ],
        appointments: [
          { id: 1, patient: 1, doctor: 1, date: '2022-01-01', time: '10:00 AM' },
          { id: 2, patient: 2, doctor: 2, date: '2022-01-02', time: '11:00 AM' },
        ],
        newAppointment: { patient: '', doctor: '', date: '', time: '' },
      };
    },
    methods: {
      addAppointment() {
        this.appointments.push({...this.newAppointment, id: this.appointments.length + 1 });
        this.newAppointment = { patient: '', doctor: '', date: '', time: '' };
      },
      editAppointment(appointment) {
        // implement edit functionality
      },
      deleteAppointment(appointment) {
        this.appointments = this.appointments.filter(a => a.id !== appointment.id);
      },
      getPatientName(patientId) {
        return this.patients.find(patient => patient.id === patientId).name;
      },
      getDoctorName(doctorId) {
        return this.doctors.find(doctor => doctor.id === doctorId).name;
      },
    },
  };
  </script>
  
  <style scoped>
  .content {
    margin-left: 240px; /* width of the sidebar */
    padding: 80px 20px 20px; /* add padding top equal to the height of the header */
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
  }
  
  th {
    background-color: #f0f0f0;
  }
  </style>