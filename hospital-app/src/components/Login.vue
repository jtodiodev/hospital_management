<template>
  <div class="hero">
    <div class="form-box">
      <div class="social-icons">
        <img src="@/assets/hospi.png" />
      </div>
      <div class="button-box">
        <div id="btn" :style="{ left: isLogin ? '0' : '110px' }"></div>
        <button type="button" class="toggle-btn" @click="showLogin">
          LOGIN
        </button>
        <button type="button" class="toggle-btn" @click="showRegister">
          SIGN UP
        </button>
      </div>
      <form v-if="isLogin" class="input-group-login" @submit.prevent="login">
        <input
          type="text"
          class="input-field"
          placeholder="Email address"
          v-model="email"
          required
        />
        <input
          type="password"
          class="input-field"
          placeholder="Enter Password"
          v-model="password"
          required
        />
        <div class="checkbox-wrapper">
          <input type="checkbox" class="check-box" v-model="rememberPassword" />
          <span>Remember Password</span>
        </div>
        <button type="submit" class="submit-btn">LOGIN</button>
      </form>
      <form v-else class="input-group-register" @submit.prevent="register">
        <select class="input-field form-select" v-model="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="admin">Admin</option>
          <option value="doctor">Doctor</option>
          <option value="patient">Patient</option>
        </select>
        <input
          type="text"
          class="input-field"
          placeholder="Full Name"
          v-model="fullName"
          required
        />
        <input
          type="email"
          class="input-field"
          placeholder="Email address"
          v-model="email"
          required
        />
        <input
          type="password"
          class="input-field"
          placeholder="Enter Password"
          v-model="password"
          required
        />
        <input
          type="password"
          class="input-field"
          placeholder="Confirm Password"
          v-model="confirmPassword"
          required
        />

        <div class="checkbox-wrapper">
          <input type="checkbox" class="check-box" v-model="agreeTerms" />
          <span>I agree to the terms & conditions</span>
        </div>
        <button type="submit" class="submit-btn">SIGN UP</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      isLogin: true,
      email: "",
      password: "",
      confirmPassword: "",
      fullName: "",
      rememberPassword: false,
      agreeTerms: false,
      role: "",
    };
  },
  methods: {
    showLogin() {
      this.isLogin = true;
    },
    showRegister() {
      this.isLogin = false;
    },
    async login() {
      try {
        await axios.post("http://127.0.0.1:8000/api/login", {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem('authenticated', true);
        this.$router.push({ name: 'Home' });
      } catch (error) {
        alert("Error logging in");
        console.error("Error logging in:", error);
      }
    },

    async register() {
      if (!this.agreeTerms) {
        alert("You must agree to the terms and conditions to register.");
        return;
      }

      try {
        await axios.post("http://127.0.0.1:8000/api/register", {
          role: this.role,
          name: this.fullName,
          email: this.email,
          password: this.password,
        });
        alert("Registration successful");
        this.email = "";
        this.password = "";
        this.confirmPassword = "";
        this.fullName = "";
        this.rememberPassword = false;
        this.agreeTerms = false;
        this.role = "";
      } catch (error) {
        alert("Error registering");
        console.error("Error registering:", error);
      }
    },
  },
};
</script>

<style scoped>
.hero {
  height: 100vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
    url("@/assets/banner.jpg");
  background-position: center;
  background-size: cover;
  position: relative;
}

.form-box {
  width: 380px;
  height: 520px;
  background: #b3f9be;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  position: relative;
}

.button-box {
  display: flex;
  justify-content: space-between;
  margin: 0 auto;
  position: relative;
  width: 220px;
  box-shadow: 0 0 20px 9px #ff61241f;
  border-radius: 30px;
  z-index: 1;
}

.toggle-btn {
  flex: 1;
  padding: 10px 0;
  cursor: pointer;
  background: transparent;
  border: none;
  outline: none;
  text-align: center;
  font-size: 16px;
  z-index: 2;

  font-family: "Cambria", sans-serif;
  color: #100000;
  font-size: 15px;
  font-weight: bold;
}

#btn {
  position: absolute;
  top: 0;
  left: 0;
  width: 110px;
  height: 100%;
  background: linear-gradient(to right, #5271ff, #7ed957);
  border-radius: 30px;
  transition: 0.5s;
  z-index: 0;
}

.social-icons {
  display: flex;
  justify-content: center;
  margin: -80px;
}

.social-icons img {
  width: 200px;
  margin: 15px;
  cursor: pointer;
}

.input-group-register {
  position: absolute;
  width: 280px;
  top: 130px;
  left: 50%;
  transform: translateX(-50%);
  transition: 0.5s;
}

.input-group-login {
  position: absolute;
  width: 280px;
  top: 190px;
  left: 50%;
  transform: translateX(-50%);
  transition: 0.5s;
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
  color: #777;
  border-radius: 0;
}

.checkbox-wrapper {
  display: flex;
  align-items: center;
  margin: 20px 0;
}

.check-box {
  margin-right: 10px;
}

.submit-btn {
  width: 100%;
  padding: 10px 30px;
  cursor: pointer;
  display: block;
  margin: auto;
  background: linear-gradient(to right, #7ed957, #5271ff);
  border: none;
  outline: none;
  border-radius: 30px !important;
  font-weight: bold;
}

/* Import Cambria font */
@font-face {
  font-family: "Cambria";
  src: url("../assets/Fonts/Cambria-Font-For-Windows.ttf") format("truetype");
}

.input-field,
.form-select,
.submit-btn,
span {
  font-family: "Cambria", sans-serif;
  color: #100000;
  font-size: 15px;
}
</style>
