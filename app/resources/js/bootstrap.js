import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Importando o jQuery
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Importando o slick-carousel
import 'slick-carousel/slick/slick.min.js';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

// Inicializar o slick globalmente
$(document).ready(function () {
    if ($('.carousel .style-card').length > 0) {
        $('.carousel').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
        });
    }
});