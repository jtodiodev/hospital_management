import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import DashBoard from '../components/DashBoard.vue';
import Doctors from '../components/DoctorComponents/Doctors.vue';
import Appointments from '../components/Appointments.vue';
import MedicalRecords from '../components/MedicalRecords.vue';
import Patients from '../components/Patients.vue';

const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/dashboard', name: 'Dashboard', component: DashBoard, meta: { requiresAuth: true } },
  { path: '/doctors', name: 'Doctors', component: Doctors, meta: { requiresAuth: true } },
  { path: '/appointments', name: 'Appointments', component: Appointments, meta: { requiresAuth: true } },
  { path: '/medical-records', name: 'MedicalRecords', component: MedicalRecords, meta: { requiresAuth: true } },
  { path: '/patients', name: 'Patients', component: Patients, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('authenticated');
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'Login' });
  } else {
    next();
  }
}); 

export default router;