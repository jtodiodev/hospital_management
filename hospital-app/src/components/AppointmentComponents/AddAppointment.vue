<template>
    <form @submit.prevent="submitForm" class="add-appointment-form">
        <div>
            <label for="patientName">Patient Name:</label>
            <input type="text" v-model="patientName" id="patientName" required class="input-field">
        </div>
        <div class="select-wrapper">
            <label for="doctor">Doctor:</label>
            <select v-model="selectedDoctor" id="doctor" required class="input-field">
                <option value="" disabled>Select Doctor</option>
                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
            </select>
        </div>
        <div>
            <label for="date">Date:</label>
            <input type="date" v-model="date" id="date" required class="input-field">
        </div>
        <div>
            <label for="time">Time:</label>
            <input type="time" v-model="time" id="time" required class="input-field">
        </div>
        <button type="submit" class="submit-button">Add Appointment</button>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    props: ['doctors'],
    data() {
        return {
            patientName: '',
            selectedDoctor: null,
            date: '',
            time: ''
        };
    },
    methods: {
        submitForm() {
            const newAppointment = {
                patient_name: this.patientName,
                doctor_name: this.doctors.find(doctor => doctor.id === parseInt(this.selectedDoctor)).name,
                date: this.date,
                time: this.time
            };

            axios.post('http://127.0.0.1:8000/api/appointments', newAppointment)
                .then(response => {
                    // Emit an event to inform parent component about the new appointment
                    this.$emit('appointment-added', response.data);

                    // Reset form fields
                    this.patientName = '';
                    this.selectedDoctor = null;
                    this.date = '';
                    this.time = '';
                })
                .catch(error => {
                    console.error('Error adding appointment:', error);
                });
        }
    }
};
</script>

<style scoped>
.add-appointment-form {
    margin-bottom: 20px;
}

.input-field {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.select-wrapper {
    position: relative;
    margin-bottom: 10px;
}

.select-wrapper select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    cursor: pointer;
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
