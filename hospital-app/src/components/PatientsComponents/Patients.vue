<template>
  <div class="content">
    <h1>Patient Management</h1>

    <!-- Add Patient or Edit Patient -->
    <div class="input-field">
      <template v-if="!editingPatient">
        <AddPatient @add-patient="addPatient" />
      </template>
      <template v-else>
        <EditPatient :patient="currentPatient" @update-patient="updatePatient" @cancel-edit="cancelEdit" />
      </template>
    </div>

    <!-- Patient List -->
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Phone Number</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="patient in patients" :key="patient.id">
          <td>{{ patient.name }}</td>
          <td>{{ patient.age }}</td>
          <td>{{ patient.phone_number }}</td>
          <td>{{ patient.address }}</td>
          <td>
            <div class="action-button">
              <button @click="editPatient(patient)" class="btn btn-warning">Edit</button>
              <button @click="deletePatient(patient)" class="btn btn-danger">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import AddPatient from './AddPatient.vue';
import EditPatient from './EditPatient.vue';
import axios from 'axios';

export default {
  components: {
    AddPatient,
    EditPatient,
  },
  data() {
    return {
      patients: [],
      currentPatient: { name: '', age: '', phone_number: '', address: '' },
      editingPatient: false,
    };
  },
  mounted() {
    this.fetchPatients();
  },
  methods: {
    async fetchPatients() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/patients');
        this.patients = response.data;
      } catch (error) {
        console.error('Error fetching patients:', error);
        alert('Failed to fetch patients. Please try again later.');
      }
    },
    editPatient(patient) {
      this.currentPatient = { ...patient };
      this.editingPatient = true;
    },
    async deletePatient(patient) {
      const confirmDelete = confirm(`Are you sure you want to delete ${patient.name}?`);
      if (confirmDelete) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/patients/${patient.id}`);
          this.patients = this.patients.filter(p => p.id !== patient.id);
          alert('Patient removed successfully!');
        } catch (error) {
          console.error('Error deleting patient:', error);
          alert('An error occurred while deleting the patient.');
        }
      }
    },
    cancelEdit() {
      this.currentPatient = { name: '', age: '', phone_number: '', address: '' };
      this.editingPatient = false;
    },
    async addPatient(patient) {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/patients', patient);
        this.patients.push(response.data);
      } catch (error) {
        console.error('Error adding patient:', error);
        alert('An error occurred while adding the patient.');
      }
    },
    async updatePatient(patient) {
      try {
        await axios.put(`http://127.0.0.1:8000/api/patients/${patient.id}`, patient);
        const index = this.patients.findIndex(p => p.id === patient.id);
        this.$set(this.patients, index, patient);
        this.cancelEdit();
      } catch (error) {
        console.error('Error updating patient:', error);
        alert('An error occurred while updating the patient.');
      }
    },
  },
};
</script>

<style scoped>
.content {
  margin-left: 240px;
  padding: 80px 20px 20px;
}

.input-field {
  margin-left: -20%;
  margin-top: -5%;
}

.submit-button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #45a049;
}

.action-button {
  display: flex;
  gap: 5px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f0f0f0;
}
</style>
