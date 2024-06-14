<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Doctors Table</h3>
            <div class="card-tools">
              <button class="btn btn-success custom-button" @click="showAddModal = true">
                Register Doctor <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">Liscensed ID</th>
                  <th style="width: 10%">Full Name</th>
                  <th style="width: 10%">Gender</th>
                  <th style="width: 10%">Age</th>
                  <th style="width: 10%">Contact No.</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="doctor in doctors" :key="doctor.licensed_id">
                  <td>{{ doctor.licensed_id }}</td>
                  <td>{{ doctor.name }}</td>
                  <td>{{ doctor.gender }}</td>
                  <td>{{ doctor.age }}</td>
                  <td>{{ doctor.contactNo }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="editDoctor(doctor); showEditModal = true">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm" style="margin-left: 10px" @click="deleteDoctor(doctor)">
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <Modal v-if="showAddModal" @close="showAddModal = false">
      <div>
        <h2>Doctor Profiling</h2>
        <form @submit.prevent="addNewDoctor">
          <input type="text" class="input-field" placeholder="Search Doctor ID" v-model="doctor_id" required
            @input="findUser()" />
          <input type="text" class="input-field" :class="{ 'found': userFound, 'not-found':!userFound }"
            placeholder="Full Name" v-model="doctorData.name" readonly />
          <select class="input-field form-select" v-model="doctorData.gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Age" v-model="doctorData.age" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="doctorData.contactNo" required />
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>
    <Modal v-if="showEditModal" @close="showEditModal = false">
      <div>
        <h2>Edit Doctor</h2>
        <form @submit.prevent="editDoctorSubmit(editedDoctor)">
          <input type="text" class="input-field" placeholder="Licensed ID" v-model="editedDoctor.licensed_id" readonly />
          <input type="text" class="input-field" placeholder="Full Name" v-model="editedDoctor.name" />
          <select class="input-field form-select" v-model="editedDoctor.gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Age" v-model="editedDoctor.age" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="editedDoctor.contactNo" required />
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>
  </div>
</template>

<script>
import Modal from "./modal/modal.vue";
import axios from "axios";

export default {
  name: "Dashboard",
  components: { Modal },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      doctors: [],
      doctor_id: '',
      doctorData: {
        name: '',
        gender: '',
        age: '',
        contactNo: '',
},
      userFound: false,
      editedDoctor: null,
    };
  },
  mounted() {
    this.fetchDoctors()
  },
  methods: {
      findUser() {
      axios.get(`http://localhost:8000/api/doctor/${this.doctor_id}`)
       .then(response => {
          const user = response.data.user;
          this.doctorData.name = user.name;
          this.userFound = true;
        })
       .catch(error => {
          console.error(error);
          this.userFound = false;
          this.doctorData.name = "No user match";
        });
    },
    fetchDoctors() {
      axios.get('http://localhost:8000/api/doctors')
       .then(response => {
          this.doctors = response.data
        })
       .catch(error => {
          console.error(error)
        })
    },
    addNewDoctor() {
      if (!this.userFound) {
        alert("User not found");
        return;
      }
      axios.post('http://localhost:8000/api/doctors', {
        user_id: this.doctor_id,
        name: this.doctorData.name,
        gender: this.doctorData.gender,
        age: this.doctorData.age,
        contactNo: this.doctorData.contactNo,
      })
       .then(() => {
          this.fetchDoctors();
          this.doctor_id = '';
          this.doctorData.name = '';
          this.doctorData.gender = '';
          this.doctorData.age = '';
          this.doctorData.contactNo = '';
          this.showAddModal = false;
          alert("Doctor added successfully!");
        })
       .catch(error => {
          console.error(error);
          alert("Error adding doctor: " + error.message);
        });
    },
    editDoctor(doctor) {
      this.editedDoctor = doctor;
      this.showEditModal = true;
    },
    editDoctorSubmit(editedDoctor) {
      axios.put(`http://localhost:8000/api/doctors/${editedDoctor.licensed_id}`, {
        licensed_id: editedDoctor.licensed_id,
        name: editedDoctor.name,
        gender: editedDoctor.gender,
        age: editedDoctor.age,
        contactNo: editedDoctor.contactNo,
      })
       .then(() => {
          this.fetchDoctors();
          this.showEditModal = false;
          alert("Doctor updated successfully!");
        })
       .catch(error => {
          console.error(error);
          alert("Error updating doctor: " + error.message);
        });
    },
    deleteDoctor(doctor) {
      axios.delete(`http://localhost:8000/api/doctors/${doctor.licensed_id}`)
       .then(() => {
          this.fetchDoctors();
          alert("Doctor deleted successfully!");
        })
       .catch(error => {
          console.error(error);
          alert("Error deleting doctor: " + error.message);
        });
    },
  },
};
</script>

<style scoped>
@font-face {
  font-family: "Cambria";
  src: url("../assets/Fonts/Cambria-Font-For-Windows.ttf") format("truetype");
}

.container {
  margin-left: 240px;
  padding: 80px 20px 20px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

table {
  margin-bottom: 0;
  cursor: default;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: #fff;
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.input-field,
.form-select {
  width: 100%;
  padding: 10px 0;
  margin: 5px 0;
  border: none;
  border-bottom: 1px solid #999;
  outline: none;
  background: transparent;
  color: #777;
  border-radius: 0;
}

.table th,
span {
  font-family: "Cambria", sans-serif;
  color: #100000;
  font-size: 17px;
}

form {
  grid-row: 1;
}

button[type="submit"] {
  grid-row: 2;
  justify-self: center;
  margin: 5px auto;
  display: block;
  text-align: center;
}

.input-group {
  position: relative;
}

.input-group button[type="button"] {
  position: absolute;
  right: 0;
  top: 0;
  padding: 10px;
  border: none;
  border-radius: 010px 10px 0;
  background-color: #5cac52;
  color: #333;
  cursor: pointer;
}

.input-group button[type="button"]:hover {
  background-color: #74d767;
}
</style>