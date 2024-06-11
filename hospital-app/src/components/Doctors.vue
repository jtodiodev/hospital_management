<template>
    <div class="content">
      <h1>Doctor Management</h1>
      <form @submit.prevent="addDoctor">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="newDoctor.name"><br><br>
        <label for="specialty">Specialty:</label>
        <input type="text" id="specialty" v-model="newDoctor.specialty"><br><br>
        <label for="hospital">Hospital:</label>
        <input type="text" id="hospital" v-model="newDoctor.hospital"><br><br>
        <input type="submit" value="Add Doctor">
      </form>
      <table>
        <tr>
          <th>Name</th>
          <th>Specialty</th>
          <th>Hospital</th>
          <th>Actions</th>
        </tr>
        <tr v-for="doctor in doctors" :key="doctor.id">
          <td>{{ doctor.name }}</td>
          <td>{{ doctor.specialty }}</td>
          <td>{{ doctor.hospital }}</td>
          <td>
            <button @click="editDoctor(doctor)">Edit</button>
            <button @click="deleteDoctor(doctor)">Delete</button>
          </td>
        </tr>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        doctors: [
          { id: 1, name: 'Dr. Smith', specialty: 'Cardiology', hospital: 'Hospital A' },
          { id: 2, name: 'Dr. Johnson', specialty: 'Neurology', hospital: 'Hospital B' },
        ],
        newDoctor: { name: '', specialty: '', hospital: '' },
      };
    },
    methods: {
      addDoctor() {
        this.doctors.push({...this.newDoctor, id: this.doctors.length + 1 });
        this.newDoctor = { name: '', specialty: '', hospital: '' };
      },
      editDoctor(doctor) {
        // implement edit functionality
      },
      deleteDoctor(doctor) {
        this.doctors = this.doctors.filter(d => d.id!== doctor.id);
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