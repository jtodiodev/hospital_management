<template>
  <div class="content">
    <form @submit.prevent="addDoctor" class="form">
      <label for="name">Name:</label>
      <input type="text" id="name" v-model="doctor.name" class="input-field">
      <p v-if="errors.name" class="error-message">{{ errors.name }}</p><br><br>

      <label for="specialty">Specialization:</label>
      <input type="text" id="specialty" v-model="doctor.specialty" class="input-field">
      <p v-if="errors.specialty" class="error-message">{{ errors.specialty }}</p><br><br>

      <label for="contact">Contact Number:</label>
      <input type="text" id="contact_number" v-model="doctor.contact_number" class="input-field">
      <p v-if="errors.contact_number" class="error-message">{{ errors.contact_number }}</p><br><br>

      <label for="email">Email:</label>
      <input type="email" id="email" v-model="doctor.email" class="input-field">
      <p v-if="errors.email" class="error-message">{{ errors.email }}</p><br><br>

      <input type="submit" value="Add Doctor" class="submit-button">
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      doctor: { name: '', specialty: '', email: '', contact_number: '' },
      errors: {}
    };
  },
  methods: {
    validateFields() {
      this.errors = {};
      let valid = true;

      if (!this.doctor.name) {
        this.errors.name = 'Name is required';
        valid = false;
      }
      if (!this.doctor.specialty) {
        this.errors.specialty = 'Specialty is required';
        valid = false;
      }
      if (!this.doctor.email) {
        this.errors.email = 'Email is required';
        valid = false;
      } else if (!/\S+@\S+\.\S+/.test(this.doctor.email)) {
        this.errors.email = 'Email must be in correct format';
        valid = false;
      }
      if (!this.doctor.contact_number) {
        this.errors.contact_number = 'Contact Number is required';
        valid = false;
      } else if (!/^\d+$/.test(this.doctor.contact_number)) {
        this.errors.contact_number = 'Contact Number must be numeric';
        valid = false;
      }

      return valid;
    },
    addDoctor() {
      if (!this.validateFields()) {
        return;
      }

      axios.post('http://127.0.0.1:8000/api/doctors', {
        name: this.doctor.name,
        specialty: this.doctor.specialty,
        contact_number: this.doctor.contact_number,
        email: this.doctor.email
      })
        .then(response => {
          // Handle success
          console.log('Doctor added successfully:', response.data);
          alert('Doctor added successfully');
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
            console.error('Error adding doctor:', error.message);
            alert('Error adding doctor');
          }
        });
    },
    clearFields() {
      // Clear all input fields
      this.doctor.name = '';
      this.doctor.specialty = '';
      this.doctor.email = '';
      this.doctor.contact_number = '';
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
