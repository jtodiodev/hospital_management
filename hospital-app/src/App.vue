<template>
  <div>
    <div v-if="showNavbar">
      <header class="custom-header">
        <h1>{{ featureTitle }}</h1>
        <div class="dropdown">
          <button class="dropbtn" @click="toggleDropdown">&#9881;</button>
          <div :class="{ 'dropdown-content': true, 'show': isDropdownOpen }">
            <a href="#" @click.prevent="logout">Logout</a>
          </div>
        </div>
      </header>
      <div class="sidebar">
        <h1>Hospital Title</h1>
        <hr />
        <div class="profile">
          <div class="profile-pic"></div>
          <div class="profile-info">
            <h2>{{ $store.state.user?.name }}</h2>
            <p>{{ $store.state.user?.role }}</p>
          </div>
        </div>
        <hr />
        <nav>
          <ul>
            <li>
              <a @click="$router.push({ name: 'Dashboard' })"
                :class="{ selected: selectedHref === '#dash-board' }">DASHBOARD</a>
            </li>
            <li>
              <a @click="$router.push({ name: 'Patients' })"
                :class="{ selected: selectedHref === '#patient-management' }">PATIENT MANAGEMENT</a>
            </li>
            <li>
              <a @click="$router.push({ name: 'Doctors' })"
                :class="{ selected: selectedHref === '#doctor-management' }">DOCTOR MANAGEMENT</a>
            </li>
            <li>
              <a @click="$router.push({ name: 'Appointments' })"
                :class="{ selected: selectedHref === '#appointment-management' }">APPOINTMENT MANAGEMENT</a>
            </li>
            <li>
              <a @click="$router.push({ name: 'MedicalRecords' })"
                :class="{ selected: selectedHref === '#medical-records' }">MEDICAL RECORDS</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>

export default {
  name: "App",
  data() {
    return {
      selectedHref: "#dash-board",
      isDropdownOpen: false,
      featureTitle: 'Dashboard',
    };
  },
  computed: {
    showNavbar() {
      return this.$route.name !== "Login";
    },
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    logout() {
      localStorage.removeItem('authenticated');
      this.$router.push({ name: 'Login' });
      this.selectedHref = "#dash-board";
      this.featureTitle = "Dashboard";
    },
    handleClickOutside(event) {
      if (!event.target.closest('.dropdown')) {
        this.isDropdownOpen = false;
      }
    }
  },
  mounted() {
    document.addEventListener('click', this.handleClickOutside);
    this.$watch(
      () => this.$route.name,
      (newRouteName) => {
        switch (newRouteName) {
          case 'Dashboard':
            this.selectedHref = "#dash-board";
            this.featureTitle = "Dashboard";
            break;
          case 'Patients':
            this.selectedHref = "#patient-management";
            this.featureTitle = "Patient Management";
            break;
          case 'Doctors':
            this.selectedHref = "#doctor-management";
            this.featureTitle = "Doctor Management";
            break;
          case 'Appointments':
            this.selectedHref = "#appointment-management";
            this.featureTitle = "Appointment Management";
            break;
          case 'MedicalRecords':
            this.selectedHref = "#medical-records";
            this.featureTitle = "Medical Records";
            break;
        }
      }
    );
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  created() {
    const userData = JSON.parse(localStorage.getItem('user'));
    if (userData) {
      this.$store.dispatch('login', userData);
    }
  }
};
</script>

<style scoped>
body {
  display: flex;
  margin: 0;
  font-family: Arial, sans-serif;
}

.sidebar {
  width: 240px;
  background-color: #2c3e50;
  color: white;
  position: fixed;
  padding: 20px 20px 100%;
  box-sizing: border-box;
  overflow-y: auto;
  left: 0;
  font-size: 14px;
}

.sidebar h1 {
  text-align: center;
  margin: 0;
  font-size: 20px;
}

.sidebar hr {
  border: 0;
  height: 1px;
  background: #bdc3c7;
  margin: 20px 0;
}

.profile {
  display: flex;
  align-items: center;
  flex-direction: column;
  text-align: center;
  margin-bottom: 20px;
}

.profile-pic {
  width: 60px;
  height: 60px;
  background-color: #ecf0f1;
  border-radius: 50%;
  margin-bottom: 10px;
}

.profile-info h2 {
  margin: 0;
  font-size: 16px;
}

.profile-info p {
  margin: 5px 0 0;
  font-size: 12px;
  color: #bdc3c7;
}

nav ul {
  list-style-type: none;
  padding: 0;
}

nav ul li {
  padding: 10px 0;
}

nav ul li a {
  color: rgb(188, 182, 182);
  text-decoration: none;
  display: block;
  text-align: left;
  line-height: 3;
  cursor: pointer;
}

.selected {
  color: #7ac29a;
  cursor: default;
}

.selected:hover {
  color: #7ac29a;
}

nav ul li a:hover {
  color: rgb(249, 249, 249);
}

.button {
  width: 100%;
  padding: 10px;
  background-color: #e74c3c;
  border: none;
  color: white;
  cursor: pointer;
  margin-top: 20px;
}

.button:hover {
  background-color: #c0392b;
}

.custom-header {
  background-color: #ffffff;
  color: rgb(94, 85, 85);
  padding: 8.9px 21px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  width: calc(100% - 240px);
  right: 0;
  z-index: 1;
  border-bottom: 1px solid #ccc;
}

.custom-header h1 {
  font-size: 24px;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropbtn {
  background-color: #ffffff;
  border: none;
  cursor: pointer;
  font-size: 20px;
  padding: 8px 10px;
  transition: transform 0.3s ease;
}

.dropbtn:hover {
  transform: rotate(90deg);
}

.dropdown-content {
  display: none;
  position: absolute;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  top: 60px;
  right: 20px;
}

.dropdown-content {
  position: absolute;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  top: 60px;
  right: 20px;
  display: none;
  background-color: #fff;
  border-radius: 4px;
  padding: 8px;
}

.dropdown-content a {
  color: #333;
  text-decoration: none;
  display: block;
  padding: 8px;
}

.dropdown-content a:hover {
  background-color: #f5f5f5;
}

.show {
  display: block;
}
</style>
