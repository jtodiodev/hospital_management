<template>
    <div class="content">
      <form @submit.prevent="addPatient" class="form">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="patient.name" class="input-field">
        <p v-if="errors.name" class="error-message">{{ errors.name }}</p><br><br>
  
        <label for="age">Age:</label>
        <input type="number" id="age" v-model="patient.age" class="input-field">
        <p v-if="errors.age" class="error-message">{{ errors.age }}</p><br><br>
  
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" v-model="patient.phone_number" class="input-field">
        <p v-if="errors.phone_number" class="error-message">{{ errors.phone_number }}</p><br><br>
  
        <label for="address">Address:</label>
        <input type="text" id="address" v-model="patient.address" class="input-field">
        <p v-if="errors.address" class="error-message">{{ errors.address }}</p><br><br>
  
        <input type="submit" value="Add Patient" class="submit-button">
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        patient: { name: '', age: '', phone_number: '', address: '' },
        errors: {}
      };
    },
    methods: {
      validateFields() {
        this.errors = {};
        let valid = true;
  
        if (!this.patient.name) {
          this.errors.name = 'Name is required';
          valid = false;
        }
        if (!this.patient.age) {
          this.errors.age = 'Age is required';
          valid = false;
        } else if (!Number.isInteger(Number(this.patient.age))) {
          this.errors.age = 'Age must be an integer';
          valid = false;
        }
        if (!this.patient.phone_number) {
          this.errors.phone_number = 'Phone Number is required';
          valid = false;
        }
        if (!this.patient.address) {
          this.errors.address = 'Address is required';
          valid = false;
        }
  
        return valid;
      },
      addPatient() {
        if (!this.validateFields()) {
          return;
        }
  
        axios.post('http://127.0.0.1:8000/api/patients', {
          name: this.patient.name,
          age: this.patient.age,
          phone_number: this.patient.phone_number,
          address: this.patient.address
        })
          .then(response => {
            // Handle success
            console.log('Patient added successfully:', response.data);
            alert('Patient added successfully');
            this.clearFields();
            location.reload();
          })
          .catch(error => {
            // Handle error
            if (error.response && error.response.data && error.response.data.errors) {
              // Extract validation errors from the response
              const errors = error.response.data.errors;
              // Log or display the validation errors
              console.error('Validation errors:', errors);
              alert('Validation errors:\n' + JSON.stringify(errors));
            } else {
              // Handle other types of errors
              console.error('Error adding patient:', error.message);
              alert('Error adding patient');
            }
          });
      },
      clearFields() {
        // Clear all input fields
        this.patient.name = '';
        this.patient.age = '';
        this.patient.phone_number = '';
        this.patient.address = '';
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
  
  .error-message {
    color: red;
  }
  </style>
  