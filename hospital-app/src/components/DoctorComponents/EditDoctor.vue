<template>
  <div class="content">
    <label>Name: </label>
    <input v-model="editedDoctor.name" type="text"><br><br>
    <label>Specialty: </label>
    <input v-model="editedDoctor.specialty" type="text"><br><br>
    <label>Email: </label>
    <input v-model="editedDoctor.email" type="email"><br><br>
    <label>Contact Number: </label>
    <input v-model="editedDoctor.contact_number" type="text"><br><br>
    <div class="action-button">
      <button @click="updateDoctor" class="submit-button">Update</button>
      <button @click="cancelEdit" class="submit-button">Cancel</button>
    </div>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
  </div>
</template>

<script>
export default {
  props: {
    doctor: Object
  },
  data() {
    return {
      editedDoctor: { ...this.doctor },
      errorMessage: '',
      successMessage: ''
    };
  },
  methods: {
    async updateDoctor() {
      try {
        // Clear previous messages
        this.errorMessage = '';
        this.successMessage = '';
        
        // Construct the correct URL
        const url = `http://127.0.0.1:8000/api/doctors/${this.editedDoctor.id}`;

        // Send a PUT request to update the doctor details
        const response = await fetch(url, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.editedDoctor)
        });

        if (response.ok) {
          const updatedDoctor = await response.json();
          // Emit an event to notify the parent component of successful update
          this.$emit('update-doctor', updatedDoctor);
          alert('Doctor updated successfully!');
          this.clearFields();
          location.reload();
          
        } else {
          // Handle error if update fails
          const errorData = await response.json();
          this.errorMessage = errorData.message || 'Failed to update doctor.';
        }
      } catch (error) {
        console.error('Error updating doctor:', error);
        this.errorMessage = 'An error occurred while updating the doctor.';
      }
    },
    cancelEdit() {
      // Emit an event to notify the parent component to cancel the edit
      this.$emit('cancel-edit');
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
  padding: 80px 20px 20px;
}

input {
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
