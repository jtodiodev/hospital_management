import axios from 'axios';

// Set the default authorization header with the token from localStorage
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

export default axios;
