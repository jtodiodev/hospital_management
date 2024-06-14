<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="role-filters">
          <div class="card custom-card" :class="{ selected: selectedRole === 'All' }"
            style="width: 10rem; display: inline-block; margin-right: 10px" @click="filterByRole('All')">
            <div class="card-body">
              <h5 class="card-title">All</h5>
            </div>
          </div>
          <div class="card custom-card" :class="{ selected: selectedRole === 'Doctor' }"
            style="width: 10rem; display: inline-block; margin-right: 10px" @click="filterByRole('Doctor')">
            <div class="card-body">
              <h5 class="card-title">Doctor</h5>
            </div>
          </div>
          <div class="card custom-card" :class="{ selected: selectedRole === 'Patient' }"
            style="width: 10rem; display: inline-block" @click="filterByRole('Patient')">
            <div class="card-body">
              <h5 class="card-title">Patient</h5>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User Table</h3>
            <div class="card-tools">
              <button class="btn btn-success custom-button" @click="showAddModal = true">
                Add User <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th style="width: 20%">Role</th>
                  <th style="width: 20%">ID</th>
                  <th style="width: 20%">Fullname</th>
                  <th style="width: 20%">Email</th>
                  <th style="width: 20%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in filteredUsers" :key="user.id">
                  <td>{{ user.role }}</td>
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="editUser(user); showEditModal = true">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm" style="margin-left: 10px" @click="deleteUser(user)">
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
        <h2>Add User</h2>
        <form @submit.prevent="addNewUser">
          <select class="input-field form-select" v-model="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Doctor">Doctor</option>
            <option value="Patient">Patient</option>
          </select>
          <input type="text" class="input-field" placeholder="Full Name" v-model="fullName" required />
          <input type="email" class="input-field" placeholder="Email address" v-model="email" required />
          <input type="password" class="input-field" placeholder="Enter Password" v-model="password" required />
          <button type="submit" class="btn btn-success custom-btn">Save</button>
        </form>
      </div>
    </Modal>

    <Modal v-if="showEditModal" @close="showEditModal = false">
      <div>
        <h2>Edit User</h2>
        <form @submit.prevent="updateUser">
          <select class="input-field form-select" v-model="selectedUser.role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Doctor">Doctor</option>
            <option value="Patient">Patient</option>
          </select>
          <input type="text" class="input-field" placeholder="Full Name" v-model="selectedUser.name" required />
          <input type="email" class="input-field" placeholder="Email address" v-model="selectedUser.email" required />
          <button type="submit" class="btn btn-success custom-btn">Update</button>
        </form>
      </div>
    </Modal>
  </div>
</template>

<script>
import Modal from "./modal/modal.vue";
import axios from "axios";

export default {
  name: "Dashboard",
  components: { Modal },
  data() {
    return {
      users: [],
      filteredUsers: [],
      selectedRole: "All",
      showAddModal: false,
      showEditModal: false,
      role: "",
      fullName: "",
      email: "",
      password: "",
      newUser: {
        role: "",
        fullname: "",
        email: "",
      },
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios
        .get("http://localhost:8000/api/users")
        .then((response) => {
          this.users = response.data.users;
          this.filteredUsers = this.users;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    filterByRole(role) {
      this.selectedRole = role;
      if (role === "All") {
        this.filteredUsers = this.users;
      } else {
        this.filteredUsers = this.users.filter((user) => user.role === role);
      }
    },
    async addNewUser() {
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/register",
          {
            role: this.role,
            name: this.fullName,
            email: this.email,
            password: this.password,
          }
        );
        const newUser = response.data;
        this.users.push(newUser);
        this.filteredUsers = this.users;
        alert("Added successful");
        this.email = "";
        this.password = "";
        this.fullName = "";
        this.role = "";
        this.showAddModal = false;
      } catch (error) {
        alert("Error registering");
        console.error("Error registering:", error);
      }
      this.fetchUsers();
    },
    deleteUser(user) {
      if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        axios.delete(`http://localhost:8000/api/user/${user.id}`)
          .then(response => {
            this.users = this.users.filter(u => u.id !== user.id);
            this.filteredUsers = this.users;
            alert("User deleted successfully");
          })
          .catch(error => {
            console.error(error);
            alert("Error deleting user");
          });
      }
    },
    editUser(user) {
      this.selectedUser = { ...user };
      this.showEditModal = true;
    },
    updateUser() {
      const updatedUser = {
        role: this.selectedUser.role,
        name: this.selectedUser.name,
        email: this.selectedUser.email,
      };

      axios.put(`http://localhost:8000/api/user/${this.selectedUser.id}`, updatedUser)
        .then(response => {
          const index = this.users.findIndex(user => user.id === this.selectedUser.id);
          this.users.splice(index, 1, updatedUser);
          this.filteredUsers = this.users;
          alert("User updated successfully");
          this.showEditModal = false;
          this.fetchUsers();
        })
        .catch(error => {
          console.error(error);
          alert("Error updating user");
        });
    }
  },
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

.dashboard-stats {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 20px;
}

.stat {
  margin: 20px;
  width: 200px;
  background-color: #fff;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.stat h2 {
  margin-top: 0;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.role-filters {
  font-family: "Cambria", sans-serif;
  font-weight: bold;
  margin-bottom: 10px;
}

.custom-card {
  cursor: pointer;
}

.custom-card:hover {
  background-color: #abb5b0;
}

.custom-card.selected {
  background-color: #7ac29a;
  cursor: default;
}

.custom-card.selected:hover {
  background-color: #7ac29a;
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
  padding: 20px;
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
  color: #020202;
  border-radius: 0;
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

.table th,
span {
  font-family: "Cambria", sans-serif;
  color: #100000;
  font-size: 17px;
}
</style>
