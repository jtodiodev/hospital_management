<template>
  <div class="content">
    <h1>Medical Records</h1>
    <div class="input-field">
      <label for="name">Name:</label>
      <input v-model="newPatient.name" type="text" id="name" class="input-large">
    </div>
    <div class="input-field">
      <label for="age">Age:</label>
      <input v-model="newPatient.age" type="number" id="age" class="input-large">
    </div>
    <div class="input-field">
      <label for="diagnosis">Diagnosis:</label>
      <input v-model="newPatient.diagnosis" type="text" id="diagnosis" class="input-large">
    </div>
    <div class="input-field">
      <label for="date">Date:</label>
      <input v-model="newPatient.date" type="date" id="date" class="input-large">
    </div>
    <div>
  <button @click="addOrUpdatePatient" class="green-button">{{ isEditing ? 'Update' : 'Add' }} Patient</button>
  <button v-if="isEditing" @click="cancelEdit" class="red-button" style="margin-left: 10px;">Cancel</button>
</div>
    <br>
    <br>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Diagnosis</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="patient in patients" :key="patient.id">
          <td>{{ patient.name }}</td>
          <td>{{ patient.age }}</td>
          <td>{{ patient.diagnosis }}</td>
          <td>{{ patient.date }}</td>
          <td>
            <button @click="editPatient(patient)" class="yellow-button">Edit</button>
            <button @click="deletePatient(patient)" class="red-button">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      patients: [],
      newPatient: { name: '', age: '', diagnosis: '', date: '' },
      isEditing: false,
      editingPatientId: null
    };
  },
  methods: {
    addOrUpdatePatient() {
      if (
        !this.newPatient.name ||
        !this.newPatient.age ||
        !this.newPatient.diagnosis ||
        !this.newPatient.date
      ) {
        alert("Please fill in all fields.");
        return;
      }

      if (this.isEditing) {
        this.updatePatient();
      } else {
        this.addPatient();
      }
    },
    addPatient() {
      axios.post('http://127.0.0.1:8000/api/medical-record', this.newPatient)
        .then(response => {
          this.patients.push(response.data);
          this.clearForm();
          alert('Patient added successfully');
        })
        .catch(error => {
          console.error('Error adding patient:', error);
        });
    },
    updatePatient() {
      axios.put(`http://127.0.0.1:8000/api/medical-record/${this.editingPatientId}`, this.newPatient)
        .then(response => {
          const index = this.patients.findIndex(patient => patient.id === this.editingPatientId);
          if (index !== -1) {
            this.patients[index] = response.data;
          }
          this.clearForm();
          alert('Patient updated successfully');
        })
        .catch(error => {
          console.error('Error updating patient:', error);
        });
    },
    editPatient(patient) {
      this.newPatient = { ...patient };
      this.isEditing = true;
      this.editingPatientId = patient.id;
    },
    cancelEdit() {
      this.clearForm();
    },
    deletePatient(patient) {
      if (confirm("Are you sure you want to delete this patient record?")) {
        axios.delete(`http://127.0.0.1:8000/api/medical-record/${patient.id}`)
          .then(() => {
            this.patients = this.patients.filter(p => p.id !== patient.id);
            alert('Patient deleted successfully');
          })
          .catch(error => {
            console.error('Error deleting patient:', error);
          });
      }
    },
    clearForm() {
      this.newPatient = { name: '', age: '', diagnosis: '', date: '' };
      this.isEditing = false;
      this.editingPatientId = null;
    },
    fetchPatients() {
      axios.get('http://127.0.0.1:8000/api/medical-record')
        .then(response => {
          this.patients = response.data;
        })
        .catch(error => {
          console.error('Error fetching patients:', error);
        });
    },
  },
  created() {
    this.fetchPatients();
  },
};
</script>

<style scoped>
.content {
  margin-left: 240px;
  padding: 80px 20px 20px;
}

.button-container {
  margin-top: 20px;
}

.input-field {
  margin-bottom: 10px;
}

label {
  display: inline-block;
  width: 100px;
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

.green-button {
  background-color: green;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.yellow-button {
  background-color: yellow;
  color: black;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

.red-button {
  background-color: red;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.input-large {
  width: 300px;
}
</style>
