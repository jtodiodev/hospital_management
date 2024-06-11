<template>
  <div class="content">
    <h1>Doctor Management</h1>
    <!-- Add/Edit Doctor Form -->
    <form v-if="editingDoctor" @submit.prevent="updateDoctor" class="form">
      <label for="edit-name">Name:</label>
      <input type="text" id="edit-name" v-model="editedDoctor.name" class="input-field"><br><br>
      <label for="edit-specialty">Specialty:</label>
      <input type="text" id="edit-specialty" v-model="editedDoctor.specialty" class="input-field"><br><br>
      <label for="edit-contact">Contact Number:</label>
      <input type="text" id="edit-contact" v-model="editedDoctor.contact" class="input-field"><br><br>
      <label for="edit-email">Email:</label>
      <input type="email" id="edit-email" v-model="editedDoctor.email" class="input-field"><br><br>
      <input type="submit" value="Update Doctor" class="submit-button">
    </form>
    <!-- Add Doctor Form -->
    <form v-else @submit.prevent="addDoctor" class="form">
      <label for="name">Name:</label>
      <input type="text" id="name" v-model="newDoctor.name" class="input-field"><br><br>
      <label for="specialty">Specialty:</label>
      <input type="text" id="specialty" v-model="newDoctor.specialty" class="input-field"><br><br>
      <label for="contact">Contact Number:</label>
      <input type="text" id="contact" v-model="newDoctor.contact" class="input-field"><br><br>
      <label for="email">Email:</label>
      <input type="email" id="email" v-model="newDoctor.email" class="input-field"><br><br>
      <input type="submit" value="Add Doctor" class="submit-button">
    </form>

    <!-- Doctor List -->
    <table>
      <tr>
        <th>Name</th>
        <th>Specialty</th>
        <th>Email</th>
        <th>Contact Number</th>
        <th>Actions</th>
      </tr>
      <tr v-for="doctor in doctors" :key="doctor.id">
        <td>{{ doctor.name }}</td>
        <td>{{ doctor.specialty }}</td>
        <td>{{ doctor.email }}</td>
        <td>{{ doctor.contact }}</td>
        <td>
          <div class="action-button">
            <button @click="editDoctor(doctor)" class="btn btn-warning">Edit</button>
            <button @click="deleteDoctor(doctor)" class="btn btn-danger">Delete</button>
          </div>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  computed: {
    doctors() {
      return this.$store.state.doctors;
    }
  },
  data() {
    return {
      newDoctor: { name: '', specialty: '', email: '', contact: '' },
      editingDoctor: null,
      editedDoctor: { name: '', specialty: '', email: '', contact: '' }
    };
  },
  methods: {
    addDoctor() {
      this.$store.commit('addDoctor', { ...this.newDoctor, id: this.doctors.length + 1 });
      this.resetForm();
    },
    editDoctor(doctor) {
      // Set the editingDoctor and fill the editedDoctor with the details of the selected doctor
      this.editingDoctor = doctor.id;
      this.editedDoctor = { ...doctor };
    },
    updateDoctor() {
      // Update the doctor in the store
      this.$store.commit('updateDoctor', this.editedDoctor);
      this.resetForm();
    },
    deleteDoctor(doctor) {
      this.$store.commit('deleteDoctor', doctor.id);
    },
    resetForm() {
      this.newDoctor = { name: '', specialty: '', email: '', contact: '' };
      this.editingDoctor = null;
      this.editedDoctor = { name: '', specialty: '', email: '', contact: '' };
    }
  }
};
</script>


<style scoped>
.content {
  margin-left: 240px;
  /* width of the sidebar */
  padding: 80px 20px 20px;
  /* add padding top equal to the height of the header */
}

form {
  margin-bottom: 20px;
}

.input-field {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
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
