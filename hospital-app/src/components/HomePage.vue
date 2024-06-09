<template>
  <div class="dashboard-container">
    <h1>Dashboard</h1>
    <button class="logout-button" @click="logout">Logout</button>
    <div class="card-container">
      <div class="card">
        <h2>Card 1</h2>
        <p>Some content for card 1.</p>
      </div>
      <div class="card">
        <h2>Card 2</h2>
        <p>Some content for card 2.</p>
      </div>
      <div class="card">
        <h2>Card 3</h2>
        <p>Some content for card 3.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomePage',
  methods: {
    logout() {
      // Remove the authentication flag from local storage
      localStorage.removeItem('authenticated');
      // Redirect to the login page
      this.$router.push({ name: 'Login' });
    }
  }
};
</script>

<style scoped>
.dashboard-container {
  padding: 20px;
}

.logout-button {
  margin-bottom: 20px;
  padding: 10px 20px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.card-container {
  display: flex;
  gap: 20px;
}

.card {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.card h2 {
  margin-top: 0;
}

.card p {
  margin: 0;
}
</style>
