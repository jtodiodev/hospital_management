<template>
  <div class="content">
    <h1>Doctor Management</h1>

    <!-- Add Doctor or Edit Doctor -->
    <div class="input-field">
      <template v-if="!editingDoctor">
        <AddDoctor @add-doctor="addDoctor" />
      </template>
      <template v-else>
        <EditDoctor :doctor="currentDoctor" @update-doctor="updateDoctor" @cancel-edit="cancelEdit" />
      </template>
    </div>

    <!-- Doctor List -->
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Specialty</th>
          <th>Email</th>
          <th>Contact Number</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
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
      </tbody>
    </table>
  </div>
</template>

<script>
import AddDoctor from './AddDoctor.vue';
import EditDoctor from './EditDoctor.vue';

export default {
  components: {
    AddDoctor,
    EditDoctor
  },
  data() {
    return {
      doctors: [], // Placeholder for doctor data
      currentDoctor: { name: '', specialty: '', email: '', contact: '' },
      editingDoctor: false
    };
  },
  methods: {
    addDoctor(newDoctor) {
      newDoctor.id = this.doctors.length + 1;
      this.doctors.push(newDoctor);

      alert("Doctor Added Successfully!");
    },
    editDoctor(doctor) {
      this.currentDoctor = { ...doctor };
      this.editingDoctor = true;
    },
    updateDoctor(updatedDoctor) {
      const index = this.doctors.findIndex(d => d.id === updatedDoctor.id);
      if (index !== -1) {
        // Replace the doctor object at the specified index
        this.doctors.splice(index, 1, updatedDoctor);

        alert("Doctor Updated Successfully!");
      }
      this.cancelEdit();
    },
    deleteDoctor(doctor) {
      const confirmDelete = confirm(`Are you sure you want to delete Dr. ${doctor.name}?`);
      if (confirmDelete) {
        this.doctors = this.doctors.filter(d => d.id !== doctor.id);

        alert("Doctor Removed Successfully!");
      }
    },
    cancelEdit() {
      this.currentDoctor = { name: '', specialty: '', email: '', contact: '' };
      this.editingDoctor = false;
    }
  }
};
</script>

<style scoped>
/* Add your styling for the main component here */
</style>


<style scoped>
.content {
  margin-left: 240px;
  /* width of the sidebar */
  padding: 80px 20px 20px;
  /* add padding top equal to the height of the header */
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
