<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Appointment Table</h3>
            <div class="card-tools">
              <button class="btn btn-success custom-button" @click="showAddModal = true">
                New Appointment<i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">Full Name</th>
                  <th style="width: 10%">Age</th>
                  <th style="width: 10%">Gender</th>
                  <th style="width: 10%">Address</th>
                  <th style="width: 10%">Contact No.</th>
                  <th style="width: 10%">Schedule</th>
                  <th style="width: 10%">Doctor</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="appointment in this.appointments" :key="appointment.id">
                  <td>{{ appointment.name }}</td>
                  <td>{{ appointment.age }}</td>
                  <td>{{ appointment.gender }}</td>
                  <td>{{ appointment.address }}</td>
                  <td>{{ appointment.contactNo }}</td>
                  <td>{{ appointment.schedule }}</td>
                  <td>{{ appointment.doctor_name }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="editAppointment(appointment); showEditModal = true">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm" style="margin-left: 10px"
                      @click="deleteAppointment(appointment)">
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
        <h2>Registration</h2>
        <form @submit.prevent="addNewAppointment">
          <input type="text" class="input-field" placeholder="Full Name" v-model="fullName" required readonly />
          <input type="text" class="input-field" placeholder="Age" v-model="age" required />
          <select class="input-field form-select" v-model="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Address" v-model="address" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="contact" required />
          <input type="date" class="input-field" placeholder="Appointment Schedule" v-model="schedule" required />
          <select class="input-field form-select" required v-model="selectedDoctor">
            <option value="" disabled selected>Select Doctor</option>
            <option v-for="doctor in doctors" :key="doctor.id" :value="doctor">
              {{ doctor.name }}
            </option>
          </select>
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>

    <Modal v-if="showEditModal" @close="showEditModal = false">
      <div>
        <h2>Edit Appointment</h2>
        <form @submit.prevent="editAppointmentSubmit">
          <input type="text" class="input-field" placeholder="Full Name" v-model="editedAppointment.name" required />
          <input type="text" class="input-field" placeholder="Age" v-model="editedAppointment.age" required />
          <select class="input-field form-select" v-model="editedAppointment.gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input type="text" class="input-field" placeholder="Address" v-model="editedAppointment.address" required />
          <input type="text" class="input-field" placeholder="Contact No." v-model="editedAppointment.contactNo"
            required />
          <input type="date" class="input-field" placeholder="Appointment Schedule" v-model="editedAppointment.schedule"
            required />
          <select class="input-field form-select" required v-model="editedAppointment.doctor_id">
            <option value="" disabled selected>Select Doctor</option>
            <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
              {{ doctor.name }}
            </option>
          </select>
          <button type="submit" class="btn btn-success">Update</button>
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
      appointments: [],
      selectedDoctor: null,
      gender: '',
      fullName: '',
      editedAppointment: null,
    };
  },
  mounted() {
    this.fetchAppointment();
    this.fetchDoctors();
  },
  methods: {
    fetchDoctors() {
      axios.get('http://127.0.0.1:8000/api/alldoctors')
        .then(response => {
          this.doctors = response.data.users;
        })
        .catch(error => {
          console.error(error);
        });
    },
    fetchAppointment() {
      axios.get('http://127.0.0.1:8000/api/schedules')
        .then(response => {
          console.log('API Response:', response.data);
          this.appointments = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    addNewAppointment() {
      const formData = {
        user_id: this.$store.state.user?.id,
        name: this.$store.state.user?.name,
        age: this.age,
        gender: this.gender,
        address: this.address,
        contactNo: this.contact,
        schedule: this.schedule,
        doctor_id: this.selectedDoctor.id,
        doctor_name: this.selectedDoctor.name,
      };

      axios.post('http://127.0.0.1:8000/api/schedules', formData)
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.error(error);
        });
    },
    deleteAppointment(appointment) {
      axios.delete(`http://127.0.0.1:8000/api/schedules/${appointment.id}`)
        .then(() => {
          this.fetchAppointment();
          alert("Appointment deleted successfully!");
        })
        .catch(error => {
          console.error(error);
          alert("Error deleting appointment: " + error.message);
        });
    },
    editAppointment(appointment) {
      this.editedAppointment = { ...appointment };
      this.showEditModal = true;
    },

    editAppointmentSubmit() {
      axios.put(`http://127.0.0.1:8000/api/schedules/${this.editedAppointment.id}`, {
        user_id: this.$store.state.user?.id,
        name: this.editedAppointment.name,
        age: this.editedAppointment.age,
        gender: this.editedAppointment.gender,
        address: this.editedAppointment.address,
        contactNo: this.editedAppointment.contactNo,
        schedule: this.editedAppointment.schedule,
        doctor_id: this.editedAppointment.doctor_id,
        doctor_name: this.editedAppointment.doctor_name,
      })
        .then(() => {
          this.fetchAppointment();
          this.showEditModal = false;
          alert("Appointment updated successfully!");
        })
        .catch(error => {
          console.error(error);
          alert("Error updating appointment: " + error.message);
        });
    },
  },
  created() {
    const userData = JSON.parse(localStorage.getItem('user'));
    if (userData) {
      this.$store.dispatch('login', userData);
    }
  },
  computed: {
    fullName() {
      return `${this.$store.state.user?.name}`;
    }
  }
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

.input-group button[type="button"]:hover {
  background-color: #74d767;
}
</style>
