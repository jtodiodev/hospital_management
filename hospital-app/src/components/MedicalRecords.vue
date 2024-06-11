<template>
  <div class="content">
    <h2>Doctor's Medical Records</h2>
    <div class="header">
      <div class="search-container">
        <input id="search-input" type="text" v-model="searchText" @input="filterMedicalRecords" placeholder="Search">
        <button @click="showCreateModal" class="create-button">Create Medical Records</button>
      </div>
    </div>
    <div class="table-container">
      <table class="medical-records-table">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(medicalRecord, index) in filteredMedicalRecords" :key="index">
            <td>{{ medicalRecord.patientName }}</td>
            <td>{{ medicalRecord.date }}</td>
            <td>
              <button @click="viewMedicalRecord(medicalRecord)" class="view-button">View</button>
              <button @click="updateMedicalRecord(medicalRecord)" class="update-button">Update</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal for creating medical records -->
    <div v-if="showCreateModalFlag" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h3>Create Medical Record</h3>
        <form>
          <label for="patientName">Patient Name:</label>
          <input type="text" id="patientName" v-model="newMedicalRecord.patientName" required>
          <label for="date">Date:</label>
          <input type="date" id="date" v-model="newMedicalRecord.date" required>
          <div class="button-container">
            <button type="button" class="next-button" @click="nextStep">Next</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal for viewing medical records -->
    <div v-if="showViewModalFlag" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeViewModal">&times;</span>
        <h3>View Medical Record</h3>
        <div>
          <label>Patient Name:</label>
          <span>{{ selectedMedicalRecord.patientName }}</span>
        </div>
        <div>
          <label>Date:</label>
          <span>{{ selectedMedicalRecord.date }}</span>
        </div>
        <!-- Add other fields as needed -->
      </div>
    </div>

    <!-- Modal for physical exam -->
    <div v-if="showChecklistModalFlag" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h3>Physical Exam</h3>
        <form>
          <div>
            <label>EENT:</label><br>
            <input type="radio" id="eentNormal" value="normal" v-model="newMedicalRecord.eent">
            <label for="eentNormal">Normal</label><br>
            <input type="radio" id="eentAbnormal" value="abnormal" v-model="newMedicalRecord.eent">
            <label for="eentAbnormal">Abnormal</label>
          </div>
          <div>
            <label>Heart:</label><br>
            <input type="radio" id="heartNormal" value="normal" v-model="newMedicalRecord.heart">
            <label for="heartNormal">Normal</label><br>
            <input type="radio" id="heartAbnormal" value="abnormal" v-model="newMedicalRecord.heart">
            <label for="heartAbnormal">Abnormal</label>
          </div>
          <div>
            <label>Lungs:</label><br>
            <input type="radio" id="lungsNormal" value="normal" v-model="newMedicalRecord.lungs">
            <label for="lungsNormal">Normal</label><br>
            <input type="radio" id="lungsAbnormal" value="abnormal" v-model="newMedicalRecord.lungs">
            <label for="lungsAbnormal">Abnormal</label>
          </div>
          <div>
            <label>Abdomen:</label><br>
            <input type="radio" id="abdomenNormal" value="normal" v-model="newMedicalRecord.abdomen">
            <label for="abdomenNormal">Normal</label><br>
            <input type="radio" id="abdomenAbnormal" value="abnormal" v-model="newMedicalRecord.abdomen">
            <label for="abdomenAbnormal">Abnormal</label>
          </div>
          <div>
            <label>Genitalia:</label><br>
            <input type="radio" id="genitaliaNormal" value="normal" v-model="newMedicalRecord.genitalia">
            <label for="genitaliaNormal">Normal</label><br>
            <input type="radio" id="genitaliaAbnormal" value="abnormal" v-model="newMedicalRecord.genitalia">
            <label for="genitaliaAbnormal">Abnormal</label>
          </div>
          <div>
            <label>Extremities:</label><br>
            <input type="radio" id="extremitiesNormal" value="normal" v-model="newMedicalRecord.extremities">
            <label for="extremitiesNormal">Normal</label><br>
            <input type="radio" id="extremitiesAbnormal" value="abnormal" v-model="newMedicalRecord.extremities">
            <label for="extremitiesAbnormal">Abnormal</label>
          </div>
          <div>
            <label for="impression">Impression:</label><br>
            <input type="text" id="impression" v-model="newMedicalRecord.impression">
          </div>
          <div>
            <label for="treatment">Treatment:</label><br>
            <input type="text" id="treatment" v-model="newMedicalRecord.treatment">
          </div>
          <div class="button-container">
            <button type="button" class="back-button" @click="prevStep">Back</button>
            <button type="button" class="submit-button" @click="submitMedicalRecord">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      medicalRecords: [],
      searchText: '',
      showCreateModalFlag: false,
      showViewModalFlag: false,
      showChecklistModalFlag: false,
      selectedMedicalRecord: {},
      newMedicalRecord: {
        patientName: '',
        date: '',
        eent: '',
        heart: '',
        lungs: '',
        abdomen: '',
        genitalia: '',
        extremities: '',
        impression: '',
        treatment: ''
      }
    };
  },
  computed: {
    filteredMedicalRecords() {
      if (!this.searchText) {
        return this.medicalRecords;
      }
      const searchTextLower = this.searchText.toLowerCase();
      return this.medicalRecords.filter(medicalRecord =>
        medicalRecord.patientName.toLowerCase().includes(searchTextLower) ||
        medicalRecord.date.includes(searchTextLower)
      );
    }
  },
  methods: {
  async fetchMedicalRecords() {
    try {
      const response = await fetch('http://localhost:8080/api/medical-records');
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json();
      this.medicalRecords = data;
    } catch (error) {
      console.error('Failed to fetch medical records:', error);
    }
  },
  async submitMedicalRecord() {
    try {
      const response = await fetch('http://localhost:8080/api/medical-records', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newMedicalRecord)
      });
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const newRecord = await response.json();
      this.medicalRecords.push(newRecord);
      this.resetForm();
      this.showChecklistModalFlag = false;
    } catch (error) {
      console.error('Failed to submit medical record:', error);
    }
  },
  resetForm() {
    this.newMedicalRecord = {
      patientName: '',
      date: '',
      eent: '',
      heart: '',
      lungs: '',
      abdomen: '',
      genitalia: '',
      extremities: '',
      impression: '',
      treatment: ''
    };
  },
  viewMedicalRecord(medicalRecord) {
    this.selectedMedicalRecord = medicalRecord;
    this.showViewModalFlag = true;
  },
  showCreateModal() {
    this.showCreateModalFlag = true;
  },
  closeModal() {
    this.showCreateModalFlag = false;
    this.showViewModalFlag = false;
    this.showChecklistModalFlag = false;
  },
  closeViewModal() {
    this.showViewModalFlag = false;
  },
  nextStep() {
    if (!this.newMedicalRecord.patientName || !this.newMedicalRecord.date) {
      alert('Please fill out all fields.');
      return;
    }
    this.showCreateModalFlag = false;
    this.showChecklistModalFlag = true;
  },
  prevStep() {
    this.showChecklistModalFlag = false;
    this.showCreateModalFlag = true;
  }
},
created() {
  this.fetchMedicalRecords();
}
};
</script>


<style scoped>
.content {
  margin-left: 240px; /* width of the sidebar */
  padding: 80px 20px 20px; /* add padding top equal to the height of the header */
}
/* Styles for the modal */
.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}
.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.button-container {
  margin-top: 20px;
  text-align: right;
}
.next-button, .back-button, .submit-button {
  padding: 8px 16px;
  border: none;
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
  border-radius: 4px;
  margin-left: 8px;
}
.next-button:hover, .back-button:hover, .submit-button:hover {
  background-color: #45a049;
}

.header {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}
.search-container {
  display: flex;
  align-items: center;
  margin-right: auto; /* Pushes the search box to the left */
  margin-left: auto; /* Pushes the search box to the right */
}
.search-container input[type="text"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.create-button {
  padding: 8px 16px;
  border: none;
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
  border-radius: 4px;
  margin-left: 20px; /* Adjusted margin for the button */
}
.create-button:hover {
  background-color: #45a049;
}
.table-container {
  margin: 0 auto;
  width: 70%;
}
.medical-records-table {
  width: 100%;
  border-collapse: collapse;
}
.medical-records-table th, .medical-records-table td {
  padding: 8px;
  border-bottom: 1px solid #ddd;
}
.medical-records-table th {
  background-color: #f2f2f2;
  text-align: left;
}
.medical-records-table tbody tr:hover {
  background-color: #f5f5f5;
}
.view-button {
  padding: 8px 12px;
  border: none;
  background-color: #0074D9;
  color: white;
  cursor: pointer;
  border-radius: 4px;
  margin-right: 8px; /* Adjust the margin as needed */
}
.view-button:hover {
  background-color: #0056b3; /* Darker blue for view button on hover */
}
.update-button {
  padding: 8px 12px;
  border: none;
  background-color: #FF6347; /* Yellow color for update button */
  color: white;
  cursor: pointer;
  border-radius: 4px;
}
.update-button:hover {
  background-color: #cc4c30; /* Darker yellow for update button on hover */
}
.view-button:disabled, .update-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>
