import './bootstrap';

// Debug Alpine initialization
document.addEventListener('livewire:init', () => {
    console.log('Livewire initialized!');
});

document.addEventListener('alpine:init', () => {
    console.log('Alpine initialized!');
});

// Optional console log to check if the script is loading
console.log('app.js loaded');
