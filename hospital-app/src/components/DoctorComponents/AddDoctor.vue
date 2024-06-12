<template>
  <div class="content">
    <form @submit.prevent="addDoctor" class="form">
      <label for="name">Name:</label>
      <input type="text" id="name" v-model="doctor.name" class="input-field"><br><br>
      <label for="specialty">Specialty:</label>
      <input type="text" id="specialty" v-model="doctor.specialty" class="input-field"><br><br>
      <label for="contact">Contact Number:</label>
      <input type="text" id="contact" v-model="doctor.contact" class="input-field"><br><br>
      <label for="email">Email:</label>
      <input type="email" id="email" v-model="doctor.email" class="input-field"><br><br>
      <input type="submit" value="Add Doctor" class="submit-button">
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      doctor: { name: '', specialty: '', email: '', contact: '' }
    };
  },
  methods: {
    addDoctor() {
      this.$emit('add-doctor', { ...this.doctor });
      this.doctor = { name: '', specialty: '', email: '', contact: '' }; // Reset form
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
</style>
