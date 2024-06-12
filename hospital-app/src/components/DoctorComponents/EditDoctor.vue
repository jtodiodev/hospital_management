<template>
  <div class="content">
    <label>Name: </label>
    <input v-model="editedDoctor.name" type="text"><br><br>
    <label>Specialty: </label>
    <input v-model="editedDoctor.specialty" type="text"><br><br>
    <label>Email: </label>
    <input v-model="editedDoctor.email" type="email"><br><br>
    <label>Contact Number: </label>
    <input v-model="editedDoctor.contact" type="text"><br><br>
    <div class="action-button">
      <button @click="updateDoctor" class="submit-button">Update</button>
      <button @click="cancelEdit" class="submit-button">Cancel</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    doctor: Object
  },
  data() {
    return {
      editedDoctor: { ...this.doctor }
    };
  },
  methods: {
    updateDoctor() {
      this.$emit('update-doctor', this.editedDoctor);
    },
    cancelEdit() {
      // Emit an event to notify the parent component to cancel the edit
      this.$emit('cancel-edit');
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
</style>
