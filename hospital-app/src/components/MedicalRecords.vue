<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Medical Records</h3>
            <div class="card-tools">
              <button class="btn btn-success custom-button" @click="showAddModal = true">
                Create New <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">Lab No.</th>
                  <th style="width: 10%">Patient's name</th>
                  <th style="width: 10%">Weight</th>
                  <th style="width: 10%">Doctor</th>
                  <th style="width: 10%">Desease</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="record in records" :key="record.id">
                  <td>{{ record.labNo }}</td>
                  <td>{{ record.patientName }}</td>
                  <td>{{ record.weight }}</td>
                  <td>{{ record.doctor }}</td>
                  <td>{{ record.disease }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="editRecord(record); showEditModal = true">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm" style="margin-left: 10px" @click="confirmDelete(record.id)">
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
        <form @submit.prevent="addNewRecord">
          <input type="text" class="input-field" placeholder="Lab No." v-model="newRecord.labNo" required />
          <input type="text" class="input-field" placeholder="Patient's Name" v-model="newRecord.patientName"
            required />
          <input type="text" class="input-field" placeholder="Weight" v-model="newRecord.weight" required />
          <input type="text" class="input-field" placeholder="Doctor" v-model="newRecord.doctor" required />
          <input type="text" class="input-field" placeholder="Disease" v-model="newRecord.disease" required />

          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>
    <Modal v-if="showEditModal" @close="showEditModal = false">
      <div>
        <h2>Edit Record</h2>
        <form @submit.prevent="editRecordSubmit">
          <input type="text" class="input-field" placeholder="Lab No." v-model="editedRecord.labNo" required />
          <input type="text" class="input-field" placeholder="Patient's Name" v-model="editedRecord.patientName"
            required />
          <input type="text" class="input-field" placeholder="Weight" v-model="editedRecord.weight" required />
          <input type="text" class="input-field" placeholder="Doctor" v-model="editedRecord.doctor" required />
          <input type="text" class="input-field" placeholder="Disease" v-model="editedRecord.disease" required />

          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </Modal>
  </div>
</template>

<script>
import Modal from "./modal/modal.vue";

export default {
  name: "Dashboard",
  components: { Modal },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      records: [
      {
          id: 1,
          labNo: "Lab001",
          patientName: "John Doe",
          weight: "70kg",
          doctor: "Dr. Smith",
          disease: "Hypertension"
        },
        {
          id: 2,
          labNo: "Lab002",
          patientName: "Jane Doe",
          weight: "60kg",
          doctor: "Dr. Johnson",
          disease: "Diabetes"
        },
        {
          id: 3,
          labNo: "Lab003",
          patientName: "Bob Smith",
          weight: "80kg",
          doctor: "Dr. Brown",
          disease: "Asthma"
        },
        {
          id: 4,
          labNo: "Lab004",
          patientName: "Alice Johnson",
          weight: "65kg",
          doctor: "Dr. Davis",
          disease: "Arthritis"
        },
        {
          id: 5,
          labNo: "Lab005",
          patientName: "Mike Brown",
          weight: "75kg",
          doctor: "Dr. Taylor",
          disease: "Hypothyroidism"
        }
      ],
      newRecord: {
        labNo: "",
        patientName: "",
        weight: "",
        doctor: "",
        disease: ""
      },
      editedRecord: {
        id: "",
        labNo: "",
        patientName: "",
        weight: "",
        doctor: "",
        disease: ""
      }
    };
  },
  methods: {
    confirmDelete(id) {
      if (confirm("Are you sure you want to delete this record?")) {
        this.deleteRecord(id);
        alert("Record deleted successfully!");
      }
    },
    fetchRecords() {
      const records = localStorage.getItem("records");
      if (records) {
        this.records = JSON.parse(records);
      } else {
        this.records = [];
      }
    },
    addNewRecord() {
      const newRecord = { ...this.newRecord };
      newRecord.id = Math.random().toString(36).substr(2, 9);
      this.records.push(newRecord);
      localStorage.setItem("records", JSON.stringify(this.records));
      this.showAddModal = false;
      this.newRecord = {
        labNo: "",
        patientName: "",
        weight: "",
        doctor: "",
        disease: ""
      };
      alert("Record added successfully!");
    },
    deleteRecord(id) {
      this.records = this.records.filter(record => record.id !== id);
      localStorage.setItem("records", JSON.stringify(this.records));
    },
    editRecord(record) {
      this.editedRecord = { ...record };
    },
    editRecordSubmit() {
      const index = this.records.findIndex(record => record.id === this.editedRecord.id);
      if (index !== -1) {
        this.records[index] = this.editedRecord;
        localStorage.setItem("records", JSON.stringify(this.records));
      }
      this.showEditModal = false;
      alert("Record updated successfully!");
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
  border-radius: 0 10px 10px 0;
  background-color: #5cac52;
  color: #333;
  cursor: pointer;
}

.input-group button[type="button"]:hover {
  background-color: #74d767;
}
</style>
