<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Patient Record Table</h3>
            <div class="card-tools">
              <button class="btn btn-success custom-button" @click="showAddModal = true">
                Add Patient <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">UUID</th>
                  <th style="width: 10%">Full Name</th>
                  <th style="width: 10%">Gender</th>
                  <th style="width: 10%">Age</th>
                  <th style="width: 10%">Contact No.</th>
                  <th style="width: 10%">Date Added</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="patient in patients" :key="patient.patient_ID">
                  <td>{{ patient.caseNo }}</td>
                  <td>{{ patient.name }}</td>
                  <td>{{ patient.gender }}</td>
                  <td>{{ patient.age }}</td>
                  <td>{{ patient.contactNo }}</td>
                  <td>{{ patient.dateAdded }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="editPatient(patient); showEditModal = true;">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm" style="margin-left: 10px" @click="deletePatient(patient)">
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
        <h2>Patient Profiling</h2>
        <form @submit.prevent="addNewPatient">
          <input type="text" class="input-field" placeholder="Search Patient ID" v-model="patient_id" required
            @input="findUser()" />
          <input type="text" class="input-field" placeholder="Full Name" v-model="patientData.name" required />
          <select class="input-field form-select" v-model="patientData.gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Age" v-model="patientData.age" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="patientData.contactNo" required />
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>

    <Modal v-if="showEditModal" @close="showEditModal = false">
      <div>
        <h2>Update Patient</h2>
        <form @submit.prevent="editPatientSubmit(editedPatient)">
          <input type="text" class="input-field" placeholder="Search Patient ID" v-model="patient_id" readonly />
          <input type="text" class="input-field" :class="{ 'found': userFound, 'not-found': !userFound }"
            placeholder="Full Name" v-model="patientData.name" readonly/>
          <select class="input-field form-select" v-model="patientData.gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Age" v-model="patientData.age" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="patientData.contactNo" required />
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
      editedPatient: null,
      patients: [],
      searchQuery: '',
      patientData: {
        name: '',
        gender: '',
        age: '',
        contactNo: '',
      },
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.fetchPatient();
    });
  },
  methods: {
    findUser() {
      axios.get(`http://localhost:8000/api/user/${this.patient_id}`)
        .then((response) => {
          const user = response.data.user;
          this.patientData.name = user.name;
          this.userFound = true;
        })
        .catch((error) => {
          console.error(error);
          this.userFound = false;
          this.patientData.name = "No user match";
        });
    },
    addNewPatient() {
      if (!this.userFound) { // Corrected from this.patientFound to this.userFound
        alert("Patient not found");
        return;
      }
      axios.post('http://localhost:8000/api/patients', {
        patient_ID: this.patient_id,
        name: this.patientData.name,
        gender: this.patientData.gender,
        age: this.patientData.age,
        contactNo: this.patientData.contactNo,
      })
        .then(() => {
          this.fetchPatient();
          this.patient_id = '';
          this.patientData.name = '';
          this.patientData.gender = '';
          this.patientData.age = '';
          this.patientData.contactNo = '';
          alert("Patient added successfully!");
        })
        .catch((error) => {
          console.error(error);
          alert("Error adding patient: " + error.message);
        });
    },
    fetchPatient() {
      axios
        .get("http://localhost:8000/api/patients")
        .then((response) => {
          this.patients = response.data;
          this.showAddModal = false;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    deletePatient(patient) {
      axios.delete(`http://localhost:8000/api/patients/${patient.caseNo}`)
        .then(() => {
          this.fetchPatient();
          alert("Patient deleted successfully!");
        })
        .catch((error) => {
          console.error(error);
          alert("Error deleting patient: " + error.message);
        });
    },
    editPatient(patient) {
      this.patientData = patient;
      this.patient_id = patient.patient_ID;
      this.editedPatient = patient;
      this.showEditModal = true;
    },
    editPatientSubmit(patient) {
      axios.put(`http://localhost:8000/api/patients/${this.editedPatient.caseNo}`, {
        patient_ID: this.patient_id,
        name: this.patientData.name,
        gender: this.patientData.gender,
        age: this.patientData.age,
        contactNo: this.patientData.contactNo,
      })
        .then(() => {
          this.fetchPatient();
          this.showEditModal = false;
          alert("Patient updated successfully!");
        })
        .catch((error) => {
          console.error(error);
          alert("Error updating patient: " + error.message);
        });
      console.log(this.editedPatient.name);
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
  color: #000000;
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
  border-radius: 0 10px 10px 0;
  background-color: #5cac52;
  color: #333;
  cursor: pointer;
}

.input-group button[type="button"]:hover {
  background-color: #74d767;
}

.found {
  color: green;
}

.not-found {
  color: red;
}
</style>
