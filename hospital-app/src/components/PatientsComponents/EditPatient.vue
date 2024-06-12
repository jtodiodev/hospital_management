<template>
    <div class="content">
      <label>Name: </label>
      <input v-model="editedPatient.name" type="text" class="input-field">
      <p v-if="errors.name" class="error-message">{{ errors.name }}</p><br><br>
  
      <label>Age: </label>
      <input v-model="editedPatient.age" type="number" class="input-field">
      <p v-if="errors.age" class="error-message">{{ errors.age }}</p><br><br>
  
      <label>Phone Number: </label>
      <input v-model="editedPatient.phone_number" type="text" class="input-field">
      <p v-if="errors.phone_number" class="error-message">{{ errors.phone_number }}</p><br><br>
  
      <label>Address: </label>
      <input v-model="editedPatient.address" type="text" class="input-field">
      <p v-if="errors.address" class="error-message">{{ errors.address }}</p><br><br>
  
      <div class="action-button">
        <button @click="updatePatient" class="submit-button">Update</button>
        <button @click="cancelEdit" class="submit-button">Cancel</button>
      </div>
      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
      <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      patient: Object
    },
    data() {
      return {
        editedPatient: { ...this.patient },
        errors: {},
        errorMessage: '',
        successMessage: ''
      };
    },
    methods: {
      validateFields() {
        this.errors = {};
        let valid = true;
  
        if (!this.editedPatient.name) {
          this.errors.name = 'Name is required';
          valid = false;
        }
        if (!this.editedPatient.age) {
          this.errors.age = 'Age is required';
          valid = false;
        } else if (!Number.isInteger(Number(this.editedPatient.age))) {
          this.errors.age = 'Age must be an integer';
          valid = false;
        }
        if (!this.editedPatient.phone_number) {
          this.errors.phone_number = 'Phone Number is required';
          valid = false;
        }
        if (!this.editedPatient.address) {
          this.errors.address = 'Address is required';
          valid = false;
        }
  
        return valid;
      },
      async updatePatient() {
        if (!this.validateFields()) {
          return;
        }
  
        try {
          // Clear previous messages
          this.errorMessage = '';
          this.successMessage = '';
  
          // Construct the correct URL
          const url = `http://127.0.0.1:8000/api/patients/${this.editedPatient.id}`;
  
          // Send a PUT request to update the patient details
          const response = await fetch(url, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(this.editedPatient)
          });
  
          if (response.ok) {
            const updatedPatient = await response.json();
            // Emit an event to notify the parent component of successful update
            this.$emit('update-patient', updatedPatient);
            alert('Patient updated successfully!');
            this.clearFields();
            location.reload();
          } else {
            // Handle error if update fails
            const errorData = await response.json();
            this.errorMessage = errorData.message || 'Failed to update patient.';
          }
        } catch (error) {
          console.error('Error updating patient:', error);
          this.errorMessage = 'An error occurred while updating the patient.';
        }
      },
      cancelEdit() {
        // Emit an event to notify the parent component to cancel the edit
        this.$emit('cancel-edit');
      },
      clearFields() {
        // Clear all input fields
        this.editedPatient.name = '';
        this.editedPatient.age = '';
        this.editedPatient.phone_number = '';
        this.editedPatient.address = '';
      }
    }
  };
  </script>
  
  <style scoped>
  .content {
    margin-left: 240px;
    padding: 80px 20px 20px;
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
    margin-right: 10px;
  }
  
  .submit-button:hover {
    background-color: #45a049;
  }
  
  .error-message {
    color: red;
    margin-top: 10px;
  }
  
  .success-message {
    color: green;
    margin-top: 10px;
  }
  </style>
  