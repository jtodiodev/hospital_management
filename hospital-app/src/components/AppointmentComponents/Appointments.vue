<template>
    <div class="content">
        <h1>Appointment Management</h1>
        <br><br><br>
        <AddAppointment :doctors="doctors" @appointment-added="fetchAppointments" />
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="appointment in appointments" :key="appointment.id">
                    <td>{{ appointment.patient_name }}</td>
                    <td>{{ appointment.doctor ? appointment.doctor.name : 'Unknown' }}</td>
                    <td>{{ appointment.date }}</td>
                    <td>{{ appointment.time }}</td>
                    <td>
                        <button class="btn-edit" @click="editAppointment(appointment)">Edit</button> &nbsp;
                        <button class="btn-cancel" @click="deleteAppointment(appointment.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import AddAppointment from './AddAppointment.vue';
import axios from 'axios';

export default {
    components: {
        AddAppointment
    },
    data() {
        return {
            appointments: [],
            doctors: []
        };
    },
    mounted() {
        this.fetchAppointments();
        this.fetchDoctors();
    },
    methods: {
        fetchAppointments() {
            // Fetch appointments with doctor details
            axios.get('http://127.0.0.1:8000/api/appointments?_expand=doctor')
                .then(response => {
                    this.appointments = response.data;
                })
                .catch(error => {
                    console.error('Error fetching appointments:', error);
                });
        },
        deleteAppointment(id) {
            // Delete appointment
            axios.delete(`http://127.0.0.1:8000/api/appointments/${id}`)
                .then(() => {
                    this.fetchAppointments(); // Refresh appointments after deletion
                })
                .catch(error => {
                    console.error('Error deleting appointment:', error);
                });
        },
        editAppointment(appointment) {
            // Edit appointment
        },
        fetchDoctors() {
            axios.get('http://127.0.0.1:8000/api/doctors')
                .then(response => {
                    this.doctors = response.data;
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                });
        }
    }
};
</script>

<style scoped>
.content {
    margin: 30px auto;
    max-width: 800px;
}

h1 {
    margin-bottom: 20px;
    font-size: 24px;
}

.appointments-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.btn-edit, .btn-cancel {
    padding: 8px 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn-edit {
    background-color: #4CAF50;
    color: white;
}

.btn-cancel {
    background-color: #f44336;
    color: white;
}

.btn-edit:hover, .btn-cancel:hover {
    background-color: #45a049;
}

.btn-cancel:hover {
    background-color: #d32f2f;
}

/* Custom dropdown style */
.select-wrapper {
    position: relative;
    margin-bottom: 10px;
}

.select-wrapper select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.select-wrapper::after {
    content: '\25BC';
    font-size: 12px;
    color: #555;
    position: absolute;
    top: calc(50% - 6px);
    right: 10px;
    pointer-events: none;
}

</style>
