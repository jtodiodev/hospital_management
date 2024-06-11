<template>
  <div class="content">
    <br>
    <br>
    <h1>Appointment Management</h1>
    <form @submit.prevent="addOrUpdateAppointment" class="form">
      <div class="form-group">
        <label for="patient">Patient:</label> &nbsp;
        <select id="patient" v-model="newAppointment.patient">
          <option v-for="patient in patients" :key="patient.id" :value="patient.id">
            {{ patient.name }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="doctor">Doctor: </label> &nbsp;
        <select id="doctor" v-model="newAppointment.doctor">
          <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
            {{ doctor.name }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Date: </label> &nbsp;
        <input type="date" id="date" v-model="newAppointment.date">
      </div>
      <div class="form-group">
        <label for="time">Time: </label> &nbsp;
        <input type="time" id="time" v-model="newAppointment.time">
      </div>
      <input type="submit" value="Add Appointment" class="btn-submit">
    </form>
    <table class="appointments-table">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Doctor</th>
          <th>Date</th>
          <th>Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tr v-for="appointment in appointments" :key="appointment.id">
        <td>{{ getPatientName(appointment.patient) }}</td>
        <td>{{ getDoctorName(appointment.doctor) }}</td>
        <td>{{ appointment.date }}</td>
        <td>{{ appointment.time }}</td>
        <td>
          <button @click="editAppointment(appointment)" class="btn-edit">Edit</button> &nbsp;
          <button @click="confirmCancel(appointment)" class="btn-cancel">Cancel</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  computed: {
    patients() {
      return this.$store.state.patients;
    },
    doctors() {
      return this.$store.state.doctors;
    },
    appointments() {
      return this.$store.state.appointments;
    }
  },
  data() {
    return {
      newAppointment: { patient: '', doctor: '', date: '', time: '' },
      editMode: false,
      editIndex: null,
    };
  },
  methods: {
    addOrUpdateAppointment() {
      if (this.editMode) {
        this.$store.commit('updateAppointment', {
          index: this.editIndex,
          appointment: { ...this.newAppointment, id: this.appointments[this.editIndex].id }
        });
        this.editMode = false;
      } else {
        this.$store.commit('addAppointment', { ...this.newAppointment, id: this.appointments.length + 1 });
      }
      this.newAppointment = { patient: '', doctor: '', date: '', time: '' };
    },
    editAppointment(appointment) {
      this.editMode = true;
      this.editIndex = this.appointments.findIndex(a => a.id === appointment.id);
      this.newAppointment = { ...appointment };
    },
    confirmCancel(appointment) {
      if (confirm('Are you sure you want to cancel an appointment?')) {
        this.cancelAppointment(appointment);
      }
    },
    cancelAppointment(appointment) {
      this.$store.commit('cancelAppointment', appointment.id);
    },
    getPatientName(patientId) {
      const patient = this.patients.find(patient => patient.id === patientId);
      return patient ? patient.name : 'Unknown';
    },
    getDoctorName(doctorId) {
      const doctor = this.doctors.find(doctor => doctor.id === doctorId);
      return doctor ? doctor.name : 'Unknown';
    },
  },
};
</script>

<style scoped>
.content {
  margin-left: 240px;
  padding: 30px 20px; 
}

.form {
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-weight: bold;
}

input[type="date"],
input[type="time"],
select {
  padding: 8px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.btn-submit {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.appointments-table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

.btn-edit, .btn-cancel {
  padding: 6px 10px;
  border: none;
  cursor: pointer;
  border-radius: 4px;
}

.btn-edit {
  background-color: #008CBA;
  color: white;
}

.btn-cancel {
  background-color: #f44336;
  color: white;
}
</style>
