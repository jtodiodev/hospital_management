<template>
    <div class="container">
      <div class="modal" @click.self="closeModal">
        <div class="modal-content">
          <div class="close" @click="closeModal">&times;</div>
          <slot></slot>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      closeModal() {
        this.$emit('close');
      }
    }
  }
  </script>
  
  <style scoped>
  .container {
    margin-left: 5000px;
    padding: 100px 20px 20px;
  }
  
  .modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
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
  max-width: 400px; /* updated */
  max-height: 400px; /* updated */
  position: relative;
  display: flex;
  flex-direction: column;
  overflow: auto; /* added */
}
  
  .close {
    position: absolute;
    top: 0px;
    right: 15px;
    font-size: 29px;
    cursor: pointer;
    color: #aaa;
    transition: color 0.2s ease;
  }
  
  .close:hover {
    color: #e81313;
  }
  
  @media (max-width: 768px) {
   .modal-content {
      width: 300px;
      height: 300px;
    }
  }
  </style>