import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.AOS = AOS;

document.addEventListener('livewire:navigated', () => {
    AOS.init();
});

AOS.init();
