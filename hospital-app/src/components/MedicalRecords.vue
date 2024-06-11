<template>
    <div class="content">
      <h1>Medical Records</h1>
      <table>
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Diagnosis</th>
          <th>Actions</th>
        </tr>
        <tr v-for="patient in patients" :key="patient.id">
          <td>{{ patient.name }}</td>
          <td>{{ patient.age }}</td>
          <td>{{ patient.diagnosis }}</td>
          <td>
            <button @click="editPatient(patient)">Edit</button>
            <button @click="deletePatient(patient)">Delete</button>
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
          { id: 1, name: 'John Doe', age: 30, diagnosis: 'Flu' },
          { id: 2, name: 'Jane Doe', age: 25, diagnosis: 'Cold' },
        ],
        newPatient: { name: '', age: '', diagnosis: '' },
      };
    },
    methods: {
      addPatient() {
        this.patients.push({ ...this.newPatient, id: this.patients.length + 1 });
        this.newPatient = { name: '', age: '', diagnosis: '' };
      },
      editPatient(patient) {
        // implement edit functionality
      },
      deletePatient(patient) {
        this.patients = this.patients.filter(p => p.id !== patient.id);
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